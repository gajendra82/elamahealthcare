@extends('admin.layouts.app')

@section('title', 'Contact Enquiries')
@section('page-title', 'Contact Enquiries')

@section('content')
<div x-data="enquiriesCrud()" x-init="init()">
    <div class="mb-6">
        <p class="text-sm text-gray-600">View and manage contact form submissions.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 overflow-x-auto">
        <table id="enquiries-table" class="w-full text-sm" style="width:100%">
            <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Actions</th></tr></thead>
        </table>
    </div>

    <div x-show="viewOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="viewOpen = false"></div>
        <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="px-6 py-4 border-b flex justify-between sticky top-0 bg-white">
                <h3 class="text-lg font-semibold">Enquiry Details</h3>
                <button @click="viewOpen = false" class="text-2xl text-gray-400">&times;</button>
            </div>
            <div class="p-6 space-y-4" x-show="item">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="text-gray-500">Name</span><p class="font-medium" x-text="item?.name"></p></div>
                    <div><span class="text-gray-500">Email</span><p class="font-medium" x-text="item?.email"></p></div>
                    <div><span class="text-gray-500">Phone</span><p class="font-medium" x-text="item?.phone || '—'"></p></div>
                    <div><span class="text-gray-500">Date</span><p class="font-medium" x-text="item?.created_at ? new Date(item.created_at).toLocaleString() : ''"></p></div>
                </div>
                <div><span class="text-gray-500 text-sm">Subject</span><p class="font-medium" x-text="item?.subject"></p></div>
                <div><span class="text-gray-500 text-sm">Message</span><p class="text-gray-800 whitespace-pre-wrap mt-1" x-text="item?.message"></p></div>
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select x-model="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        <option value="new">New</option>
                        <option value="read">Read</option>
                        <option value="replied">Replied</option>
                    </select>
                </div>
                <p x-show="error" x-text="error" class="text-sm text-red-600"></p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="viewOpen = false" class="px-4 py-2 text-sm border rounded-lg">Close</button>
                    <button @click="updateStatus()" :disabled="saving" class="px-4 py-2 text-sm text-white bg-primary rounded-lg">Update Status</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function enquiriesCrud() {
    return {
        viewOpen: false, item: null, status: 'new', saving: false, error: '', table: null,
        init() {
            this.table = Admin.initDataTable('#enquiries-table', 'contact-enquiries', [
                { data: 'created_at', render: d => d ? new Date(d).toLocaleDateString() : '—' },
                { data: 'name' },
                { data: 'email' },
                { data: 'subject', render: d => Admin.truncate(d, 40) },
                { data: 'status', render: d => Admin.badge(d) },
                { data: null, orderable: false, searchable: false, render: (d,t,row) => `
                    <button data-view="${row.id}" class="text-primary text-sm">View</button>` },
            ]);
            $('#enquiries-table').on('click', '[data-view]', async (e) => {
                try {
                    this.item = await Admin.fetch(`${Admin.apiBase}/contact-enquiries/${e.currentTarget.dataset.view}`);
                    this.status = this.item.status;
                    this.error = '';
                    this.viewOpen = true;
                    this.table.ajax.reload(null, false);
                } catch (err) { Admin.toast(err.message, 'error'); }
            });
        },
        async updateStatus() {
            this.saving = true; this.error = '';
            try {
                await Admin.fetch(`${Admin.apiBase}/contact-enquiries/${this.item.id}`, {
                    method: 'PATCH',
                    body: { status: this.status },
                });
                Admin.toast('Status updated');
                this.viewOpen = false;
                this.table.ajax.reload();
            } catch (err) { this.error = err.message; } finally { this.saving = false; }
        },
    };
}
</script>
@endpush
