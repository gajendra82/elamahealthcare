@extends('admin.layouts.app')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')

@section('content')
<div x-data="testimonialsCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage customer testimonials.</p>
        <button @click="openCreate()" class="px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg">Add Testimonial</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="testimonials-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Photo</th><th>Name</th><th>Company</th><th>Rating</th><th>Active</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Testimonial' : 'Add Testimonial'"></h3>
                <button @click="modalOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Name *</label><input type="text" x-model="form.name" required class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Company</label><input type="text" x-model="form.company" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Designation</label><input type="text" x-model="form.designation" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Rating (1-5)</label><input type="number" x-model="form.rating" min="1" max="5" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Content *</label>
                    <textarea x-model="form.content" required rows="4" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Photo</label>
                    <input type="file" @change="onPhotoChange($event)" accept="image/*" class="w-full text-sm">
                    <img x-show="photoPreview" :src="photoPreview" class="mt-2 h-20 w-20 rounded-full object-cover">
                </div>
                <div><label class="inline-flex gap-2 text-sm"><input type="checkbox" x-model="form.is_active" class="rounded"> Active</label></div>
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
function testimonialsCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, photoFile: null, photoPreview: null, table: null,
        defaultForm() { return { name: '', company: '', designation: '', content: '', rating: 5, is_active: true }; },
        onPhotoChange(e) { this.photoFile = e.target.files[0] || null; this.photoPreview = this.photoFile ? URL.createObjectURL(this.photoFile) : this.photoPreview; },
        init() {
            this.table = Admin.initDataTable('#testimonials-table', 'testimonials', [
                { data: 'photo', orderable: false, render: d => d ? `<img src="${Admin.storageUrl(d)}" class="h-10 w-10 rounded-full object-cover">` : '—' },
                { data: 'name' },
                { data: 'company', defaultContent: '—' },
                { data: 'rating', render: d => '★'.repeat(d || 5) },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 text-sm">Delete</button>` },
            ]);
            $('#testimonials-table').on('click', '[data-edit]', async (e) => { this.openEdit(await Admin.fetch(`${Admin.apiBase}/testimonials/${e.currentTarget.dataset.edit}`)); });
            $('#testimonials-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete?')) return;
                await Admin.fetch(`${Admin.apiBase}/testimonials/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                Admin.toast('Deleted'); this.table.ajax.reload();
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.photoFile = null; this.photoPreview = null; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id;
            this.form = { name: item.name, company: item.company || '', designation: item.designation || '', content: item.content, rating: item.rating ?? 5, is_active: !!item.is_active };
            this.photoFile = null; this.photoPreview = item.photo ? Admin.storageUrl(item.photo) : null; this.modalOpen = true;
        },
        async save() {
            this.saving = true; const fd = new FormData();
            Object.entries(this.form).forEach(([k,v]) => { if (k === 'is_active') fd.append(k, v ? '1' : '0'); else if (v !== null && v !== '') fd.append(k, v); });
            if (this.photoFile) fd.append('photo', this.photoFile);
            if (this.editId) fd.append('_method', 'PUT');
            try {
                await Admin.fetch(`${Admin.apiBase}/testimonials${this.editId ? '/'+this.editId : ''}`, { method: 'POST', body: fd });
                Admin.toast('Saved'); this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
