@extends('admin.layouts.app')

@section('title', 'News')
@section('page-title', 'News')

@section('content')
<div x-data="newsCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage news articles and announcements.</p>
        <button @click="openCreate()" class="px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg">Add Article</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="news-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Image</th><th>Title</th><th>Published</th><th>Active</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Article' : 'Add Article'"></h3>
                <button @click="modalOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Title *</label>
                    <input type="text" x-model="form.title" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Slug</label><input type="text" x-model="form.slug" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Published At</label><input type="datetime-local" x-model="form.published_at" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Excerpt</label>
                    <textarea x-model="form.excerpt" rows="2" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Content</label>
                    <textarea x-model="form.content" rows="5" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Featured Image</label>
                    <input type="file" @change="onImageChange($event)" accept="image/*" class="w-full text-sm">
                    <img x-show="imagePreview" :src="imagePreview" class="mt-2 h-32 object-cover rounded-lg">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Meta Title</label><input type="text" x-model="form.meta_title" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div class="flex items-end pb-2"><label class="inline-flex gap-2 text-sm"><input type="checkbox" x-model="form.is_active" class="rounded"> Active</label></div>
                </div>
                <div><label class="block text-sm font-medium mb-1">Meta Description</label><textarea x-model="form.meta_description" rows="2" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea></div>
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
function newsCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, imageFile: null, imagePreview: null, table: null,
        defaultForm() { return { title: '', slug: '', excerpt: '', content: '', published_at: '', meta_title: '', meta_description: '', is_active: true }; },
        onImageChange(e) { this.imageFile = e.target.files[0] || null; this.imagePreview = this.imageFile ? URL.createObjectURL(this.imageFile) : this.imagePreview; },
        formatDateForInput(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return d.toISOString().slice(0, 16);
        },
        init() {
            this.table = Admin.initDataTable('#news-table', 'news', [
                { data: 'image', orderable: false, render: d => d ? `<img src="${Admin.storageUrl(d)}" class="h-10 w-14 object-cover rounded">` : '—' },
                { data: 'title' },
                { data: 'published_at', render: d => d ? new Date(d).toLocaleDateString() : '—' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 text-sm">Delete</button>` },
            ]);
            $('#news-table').on('click', '[data-edit]', async (e) => { this.openEdit(await Admin.fetch(`${Admin.apiBase}/news/${e.currentTarget.dataset.edit}`)); });
            $('#news-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete?')) return;
                await Admin.fetch(`${Admin.apiBase}/news/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                Admin.toast('Deleted'); this.table.ajax.reload();
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.imageFile = null; this.imagePreview = null; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id;
            this.form = { title: item.title, slug: item.slug || '', excerpt: item.excerpt || '', content: item.content || '', published_at: this.formatDateForInput(item.published_at), meta_title: item.meta_title || '', meta_description: item.meta_description || '', is_active: !!item.is_active };
            this.imageFile = null; this.imagePreview = item.image ? Admin.storageUrl(item.image) : null; this.modalOpen = true;
        },
        async save() {
            this.saving = true; const fd = new FormData();
            Object.entries(this.form).forEach(([k,v]) => { if (k === 'is_active') fd.append(k, v ? '1' : '0'); else if (v !== null && v !== '') fd.append(k, v); });
            if (this.imageFile) fd.append('image', this.imageFile);
            if (this.editId) fd.append('_method', 'PUT');
            try {
                await Admin.fetch(`${Admin.apiBase}/news${this.editId ? '/'+this.editId : ''}`, { method: 'POST', body: fd });
                Admin.toast('Saved'); this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
