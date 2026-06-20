@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div x-data="categoriesCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Organize products into categories.</p>
        <button @click="openCreate()" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg transition">
            Add Category
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="categories-table" class="w-full text-sm" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Active</th>
                    <th>Sort</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Category' : 'Add Category'"></h3>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" x-model="form.name" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" x-model="form.slug" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <input type="text" x-model="form.icon" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea x-model="form.description" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" x-model="form.sort_order" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="checkbox" x-model="form.is_active" class="rounded border-gray-300 text-primary">
                            Active
                        </label>
                    </div>
                </div>
                <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm border rounded-lg">Cancel</button>
                    <button type="submit" :disabled="saving" class="px-4 py-2 text-sm text-white bg-primary rounded-lg disabled:opacity-50">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function categoriesCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, table: null,
        defaultForm() { return { name: '', slug: '', icon: '', description: '', sort_order: 0, is_active: true }; },
        init() {
            this.table = Admin.initDataTable('#categories-table', 'categories', [
                { data: 'id' },
                { data: 'name' },
                { data: 'slug' },
                { data: 'products_count', defaultContent: '0' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: 'sort_order', defaultContent: '0' },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary hover:underline text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 hover:underline text-sm">Delete</button>` },
            ], { order: [[5, 'asc']] });

            $('#categories-table').on('click', '[data-edit]', async (e) => {
                try {
                    const item = await Admin.fetch(`${Admin.apiBase}/categories/${e.currentTarget.dataset.edit}`);
                    this.openEdit(item);
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
            $('#categories-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete this category?')) return;
                try {
                    await Admin.fetch(`${Admin.apiBase}/categories/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                    Admin.toast('Category deleted');
                    this.table.ajax.reload();
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.error = ''; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id;
            this.form = { name: item.name, slug: item.slug || '', icon: item.icon || '', description: item.description || '', sort_order: item.sort_order ?? 0, is_active: !!item.is_active };
            this.error = ''; this.modalOpen = true;
        },
        async save() {
            this.saving = true; this.error = '';
            try {
                const url = this.editId ? `${Admin.apiBase}/categories/${this.editId}` : `${Admin.apiBase}/categories`;
                await Admin.fetch(url, { method: this.editId ? 'PUT' : 'POST', body: this.form });
                Admin.toast(this.editId ? 'Category updated' : 'Category created');
                this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
