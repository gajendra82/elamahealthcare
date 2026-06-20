@extends('admin.layouts.app')

@section('title', 'CSR Gallery')
@section('page-title', 'CSR Gallery')

@section('content')
<div x-data="csrCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage CSR gallery images.</p>
        <button @click="openCreate()" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg transition">Add Item</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="csr-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Image</th><th>Title</th><th>Active</th><th>Sort</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Item' : 'Add Item'"></h3>
                <button @click="modalOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Title *</label>
                    <input type="text" x-model="form.title" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea x-model="form.description" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Image <span x-show="!editId">*</span></label>
                    <input type="file" @change="onImageChange($event)" accept="image/*" :required="!editId" class="w-full text-sm">
                    <img x-show="imagePreview" :src="imagePreview" class="mt-2 h-32 w-full object-cover rounded-lg border">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Sort Order</label>
                        <input type="number" x-model="form.sort_order" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" x-model="form.is_active" class="rounded"> Active</label>
                    </div>
                </div>
                <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm border rounded-lg">Cancel</button>
                    <button type="submit" :disabled="saving" class="px-4 py-2 text-sm text-white bg-primary rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function csrCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, imageFile: null, imagePreview: null, table: null,
        defaultForm() { return { title: '', description: '', sort_order: 0, is_active: true }; },
        onImageChange(e) { this.imageFile = e.target.files[0] || null; this.imagePreview = this.imageFile ? URL.createObjectURL(this.imageFile) : this.imagePreview; },
        init() {
            this.table = Admin.initDataTable('#csr-table', 'csr-gallery', [
                { data: 'image', orderable: false, render: d => d ? `<img src="${Admin.storageUrl(d)}" class="h-12 w-16 object-cover rounded">` : '—' },
                { data: 'title' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: 'sort_order', defaultContent: '0' },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 text-sm">Delete</button>` },
            ], { order: [[3, 'asc']] });
            $('#csr-table').on('click', '[data-edit]', async (e) => {
                const item = await Admin.fetch(`${Admin.apiBase}/csr-gallery/${e.currentTarget.dataset.edit}`);
                this.openEdit(item);
            });
            $('#csr-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete?')) return;
                await Admin.fetch(`${Admin.apiBase}/csr-gallery/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                Admin.toast('Deleted'); this.table.ajax.reload();
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.imageFile = null; this.imagePreview = null; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id; this.form = { title: item.title, description: item.description || '', sort_order: item.sort_order ?? 0, is_active: !!item.is_active };
            this.imageFile = null; this.imagePreview = item.image ? Admin.storageUrl(item.image) : null; this.modalOpen = true;
        },
        async save() {
            this.saving = true; const fd = new FormData();
            Object.entries(this.form).forEach(([k,v]) => { if (k === 'is_active') fd.append(k, v ? '1' : '0'); else if (v !== null && v !== '') fd.append(k, v); });
            if (this.imageFile) fd.append('image', this.imageFile);
            if (this.editId) fd.append('_method', 'PUT');
            try {
                await Admin.fetch(`${Admin.apiBase}/csr-gallery${this.editId ? '/'+this.editId : ''}`, { method: 'POST', body: fd });
                Admin.toast('Saved'); this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
