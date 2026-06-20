@extends('admin.layouts.app')

@section('title', 'Partners')
@section('page-title', 'Partners')

@section('content')
<div x-data="partnersCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage partner organizations.</p>
        <button @click="openCreate()" class="px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg">Add Partner</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="partners-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Logo</th><th>Name</th><th>Website</th><th>Active</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Partner' : 'Add Partner'"></h3>
                <button @click="modalOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input type="text" x-model="form.name" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Website</label>
                    <input type="url" x-model="form.website" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Logo</label>
                    <input type="file" @change="onLogoChange($event)" accept="image/*" class="w-full text-sm">
                    <img x-show="logoPreview" :src="logoPreview" class="mt-2 h-16 object-contain">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea x-model="form.description" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Sort Order</label><input type="number" x-model="form.sort_order" min="0" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div class="flex items-end pb-2"><label class="inline-flex gap-2 text-sm"><input type="checkbox" x-model="form.is_active" class="rounded"> Active</label></div>
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
function partnersCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, logoFile: null, logoPreview: null, table: null,
        defaultForm() { return { name: '', website: '', description: '', sort_order: 0, is_active: true }; },
        onLogoChange(e) { this.logoFile = e.target.files[0] || null; this.logoPreview = this.logoFile ? URL.createObjectURL(this.logoFile) : this.logoPreview; },
        init() {
            this.table = Admin.initDataTable('#partners-table', 'partners', [
                { data: 'logo', orderable: false, render: d => d ? `<img src="${Admin.storageUrl(d)}" class="h-10 max-w-[80px] object-contain">` : '—' },
                { data: 'name' },
                { data: 'website', render: d => d ? `<a href="${d}" target="_blank" class="text-primary hover:underline">${Admin.truncate(d, 30)}</a>` : '—' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 text-sm">Delete</button>` },
            ]);
            $('#partners-table').on('click', '[data-edit]', async (e) => { this.openEdit(await Admin.fetch(`${Admin.apiBase}/partners/${e.currentTarget.dataset.edit}`)); });
            $('#partners-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete?')) return;
                await Admin.fetch(`${Admin.apiBase}/partners/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                Admin.toast('Deleted'); this.table.ajax.reload();
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.logoFile = null; this.logoPreview = null; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id; this.form = { name: item.name, website: item.website || '', description: item.description || '', sort_order: item.sort_order ?? 0, is_active: !!item.is_active };
            this.logoFile = null; this.logoPreview = item.logo ? Admin.storageUrl(item.logo) : null; this.modalOpen = true;
        },
        async save() {
            this.saving = true; const fd = new FormData();
            Object.entries(this.form).forEach(([k,v]) => { if (k === 'is_active') fd.append(k, v ? '1' : '0'); else if (v !== null && v !== '') fd.append(k, v); });
            if (this.logoFile) fd.append('logo', this.logoFile);
            if (this.editId) fd.append('_method', 'PUT');
            try {
                await Admin.fetch(`${Admin.apiBase}/partners${this.editId ? '/'+this.editId : ''}`, { method: 'POST', body: fd });
                Admin.toast('Saved'); this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
