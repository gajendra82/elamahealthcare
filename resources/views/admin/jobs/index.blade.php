@extends('admin.layouts.app')

@section('title', 'Career Jobs')
@section('page-title', 'Career Jobs')

@section('content')
<div x-data="jobsCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage open career positions.</p>
        <button @click="openCreate()" class="px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg">Add Job</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="jobs-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Title</th><th>Department</th><th>Location</th><th>Type</th><th>Applications</th><th>Active</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Job' : 'Add Job'"></h3>
                <button @click="modalOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Title *</label>
                    <input type="text" x-model="form.title" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium mb-1">Slug</label><input type="text" x-model="form.slug" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Type</label>
                        <select x-model="form.type" class="w-full rounded-lg border px-3 py-2 text-sm">
                            <option value="">— Select —</option>
                            <option value="full-time">Full-time</option>
                            <option value="part-time">Part-time</option>
                            <option value="contract">Contract</option>
                        </select>
                    </div>
                    <div><label class="block text-sm font-medium mb-1">Department</label><input type="text" x-model="form.department" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                    <div><label class="block text-sm font-medium mb-1">Location</label><input type="text" x-model="form.location" class="w-full rounded-lg border px-3 py-2 text-sm"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea x-model="form.description" rows="4" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Requirements</label>
                    <textarea x-model="form.requirements" rows="4" class="w-full rounded-lg border px-3 py-2 text-sm"></textarea>
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
function jobsCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, table: null,
        defaultForm() { return { title: '', slug: '', department: '', location: '', type: '', description: '', requirements: '', is_active: true }; },
        init() {
            this.table = Admin.initDataTable('#jobs-table', 'career-jobs', [
                { data: 'title' },
                { data: 'department', defaultContent: '—' },
                { data: 'location', defaultContent: '—' },
                { data: 'type', defaultContent: '—' },
                { data: 'applications_count', defaultContent: '0' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 text-sm">Delete</button>` },
            ]);
            $('#jobs-table').on('click', '[data-edit]', async (e) => { this.openEdit(await Admin.fetch(`${Admin.apiBase}/career-jobs/${e.currentTarget.dataset.edit}`)); });
            $('#jobs-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete this job posting?')) return;
                await Admin.fetch(`${Admin.apiBase}/career-jobs/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                Admin.toast('Deleted'); this.table.ajax.reload();
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id;
            this.form = { title: item.title, slug: item.slug || '', department: item.department || '', location: item.location || '', type: item.type || '', description: item.description || '', requirements: item.requirements || '', is_active: !!item.is_active };
            this.modalOpen = true;
        },
        async save() {
            this.saving = true;
            try {
                const url = this.editId ? `${Admin.apiBase}/career-jobs/${this.editId}` : `${Admin.apiBase}/career-jobs`;
                await Admin.fetch(url, { method: this.editId ? 'PUT' : 'POST', body: this.form });
                Admin.toast('Saved'); this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
