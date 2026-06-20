@extends('admin.layouts.app')

@section('title', 'Leadership')
@section('page-title', 'Leadership')

@section('content')
<div x-data="leadershipCrud()" x-init="init()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <p class="text-sm text-gray-600">Manage leadership team profiles.</p>
        <button @click="openCreate()" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg transition">
            Add Member
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="leadership-table" class="w-full text-sm" style="width:100%">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Active</th>
                    <th>Sort</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="modalOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold" x-text="editId ? 'Edit Member' : 'Add Member'"></h3>
                <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form @submit.prevent="save()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" x-model="form.name" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Designation *</label>
                        <input type="text" x-model="form.designation" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Qualification</label>
                        <input type="text" x-model="form.qualification" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" x-model="form.sort_order" min="0" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                        <input type="file" @change="onPhotoChange($event)" accept="image/*" class="w-full text-sm">
                        <img x-show="photoPreview" :src="photoPreview" class="mt-2 h-24 w-24 object-cover rounded-lg border">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Experience</label>
                        <textarea x-model="form.experience" rows="2" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Achievements</label>
                        <textarea x-model="form.achievements" rows="2" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                    </div>
                    <div>
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
function leadershipCrud() {
    return {
        modalOpen: false, editId: null, saving: false, error: '', form: {}, photoFile: null, photoPreview: null, table: null,
        defaultForm() { return { name: '', designation: '', qualification: '', experience: '', achievements: '', sort_order: 0, is_active: true }; },
        onPhotoChange(e) {
            this.photoFile = e.target.files[0] || null;
            this.photoPreview = this.photoFile ? URL.createObjectURL(this.photoFile) : this.photoPreview;
        },
        init() {
            this.table = Admin.initDataTable('#leadership-table', 'leadership', [
                { data: 'photo', orderable: false, render: d => d ? `<img src="${Admin.storageUrl(d)}" class="h-10 w-10 rounded-full object-cover">` : '—' },
                { data: 'name' },
                { data: 'designation' },
                { data: 'is_active', render: d => Admin.boolBadge(d) },
                { data: 'sort_order', defaultContent: '0' },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-edit="${row.id}" class="text-primary hover:underline text-sm mr-2">Edit</button>
                    <button data-delete="${row.id}" class="text-red-600 hover:underline text-sm">Delete</button>` },
            ], { order: [[4, 'asc']] });

            $('#leadership-table').on('click', '[data-edit]', async (e) => {
                try {
                    const item = await Admin.fetch(`${Admin.apiBase}/leadership/${e.currentTarget.dataset.edit}`);
                    this.openEdit(item);
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
            $('#leadership-table').on('click', '[data-delete]', async (e) => {
                if (!confirm('Delete this member?')) return;
                try {
                    await Admin.fetch(`${Admin.apiBase}/leadership/${e.currentTarget.dataset.delete}`, { method: 'DELETE' });
                    Admin.toast('Deleted'); this.table.ajax.reload();
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
        },
        openCreate() { this.editId = null; this.form = this.defaultForm(); this.photoFile = null; this.photoPreview = null; this.error = ''; this.modalOpen = true; },
        openEdit(item) {
            this.editId = item.id;
            this.form = { name: item.name, designation: item.designation, qualification: item.qualification || '', experience: item.experience || '', achievements: item.achievements || '', sort_order: item.sort_order ?? 0, is_active: !!item.is_active };
            this.photoFile = null;
            this.photoPreview = item.photo ? Admin.storageUrl(item.photo) : null;
            this.error = ''; this.modalOpen = true;
        },
        async save() {
            this.saving = true; this.error = '';
            const fd = new FormData();
            Object.entries(this.form).forEach(([k, v]) => {
                if (k === 'is_active') fd.append(k, v ? '1' : '0');
                else if (v !== null && v !== '') fd.append(k, v);
            });
            if (this.photoFile) fd.append('photo', this.photoFile);
            if (this.editId) fd.append('_method', 'PUT');

            try {
                const url = this.editId ? `${Admin.apiBase}/leadership/${this.editId}` : `${Admin.apiBase}/leadership`;
                await Admin.fetch(url, { method: 'POST', body: fd });
                Admin.toast(this.editId ? 'Updated' : 'Created');
                this.modalOpen = false; this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
