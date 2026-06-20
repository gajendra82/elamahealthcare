@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div x-data="productsCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage pharmaceutical products catalogue.</p>
        <button @click="openCreate()" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="products-table" class="w-full text-sm" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Format</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- Modal --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold text-gray-800" x-text="editId ? 'Edit Product' : 'Add Product'"></h3>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                        <input type="text" x-model="form.product_name" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select x-model="form.category_id" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                            <option value="">— None —</option>
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                        <select x-model="form.status" required class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                        <input type="text" x-model="form.format" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                        <input type="text" x-model="form.dosage" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Packaging</label>
                        <input type="text" x-model="form.packaging" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" x-model="form.slug" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm" placeholder="Auto-generated if empty">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                        <input type="text" x-model="form.image" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Composition</label>
                        <textarea x-model="form.composition" rows="2" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea x-model="form.description" rows="3" class="w-full rounded-lg border-gray-300 border px-3 py-2 text-sm"></textarea>
                    </div>
                </div>
                <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" :disabled="saving" class="px-4 py-2 text-sm text-white bg-primary hover:bg-primary-dark rounded-lg disabled:opacity-50">
                        <span x-text="saving ? 'Saving...' : 'Save'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function productsCrud() {
    return {
        modalOpen: false,
        editId: null,
        saving: false,
        error: '',
        categories: [],
        form: {},
        table: null,

        defaultForm() {
            return { product_name: '', category_id: '', status: 'active', format: '', dosage: '', packaging: '', slug: '', image: '', composition: '', description: '' };
        },

        async init() {
            try {
                const res = await Admin.fetch(`${Admin.apiBase}/categories?per_page=100`);
                this.categories = res.data || [];
            } catch (e) { Admin.toast(e.message, 'error'); }

            this.table = Admin.initDataTable('#products-table', 'products', [
                { data: 'id' },
                { data: 'product_name' },
                { data: 'category_relation', render: (d, t, row) => d?.name || row.category || '—' },
                { data: 'status', render: d => Admin.badge(d) },
                { data: 'format', defaultContent: '—' },
                { data: null, orderable: false, searchable: false, render: (d, t, row) => `
                    <button data-edit="${row.id}" class="text-primary hover:underline text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 hover:underline text-sm">Delete</button>
                ` },
            ]);

            $('#products-table').on('click', '[data-edit]', async (e) => {
                const id = e.currentTarget.dataset.edit;
                try {
                    const item = await Admin.fetch(`${Admin.apiBase}/products/${id}`);
                    this.openEdit(item);
                } catch (err) { Admin.toast(err.message, 'error'); }
            });

            $('#products-table').on('click', '[data-delete]', async (e) => {
                const id = e.currentTarget.dataset.delete;
                if (!confirm('Delete this product?')) return;
                try {
                    await Admin.fetch(`${Admin.apiBase}/products/${id}`, { method: 'DELETE' });
                    Admin.toast('Product deleted');
                    this.table.ajax.reload();
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
        },

        openCreate() {
            this.editId = null;
            this.form = this.defaultForm();
            this.error = '';
            this.modalOpen = true;
        },

        openEdit(item) {
            this.editId = item.id;
            this.form = {
                product_name: item.product_name || '',
                category_id: item.category_id || '',
                status: item.status || 'active',
                format: item.format || '',
                dosage: item.dosage || '',
                packaging: item.packaging || '',
                slug: item.slug || '',
                image: item.image || '',
                composition: item.composition || '',
                description: item.description || '',
            };
            this.error = '';
            this.modalOpen = true;
        },

        async save() {
            this.saving = true;
            this.error = '';
            const payload = { ...this.form };
            if (!payload.category_id) payload.category_id = null;

            try {
                if (this.editId) {
                    await Admin.fetch(`${Admin.apiBase}/products/${this.editId}`, { method: 'PUT', body: payload });
                    Admin.toast('Product updated');
                } else {
                    await Admin.fetch(`${Admin.apiBase}/products`, { method: 'POST', body: payload });
                    Admin.toast('Product created');
                }
                this.modalOpen = false;
                this.table.ajax.reload();
            } catch (err) {
                this.error = err.message;
            } finally {
                this.saving = false;
            }
        },
    };
}
</script>
@endpush
