@extends('admin.layouts.app')

@section('title', 'Media Library')
@section('page-title', 'Media Library')

@section('content')
<div x-data="mediaLibrary()" x-init="load()">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex gap-3 items-center">
            <input type="search" x-model="search" @input.debounce.400ms="load()" placeholder="Search files..."
                   class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-64">
        </div>
        <label class="inline-flex items-center gap-2 px-4 py-2 bg-secondary hover:bg-secondary-dark text-white text-sm font-medium rounded-lg cursor-pointer transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
            Upload File
            <input type="file" @change="upload($event)" class="hidden" :disabled="uploading">
        </label>
    </div>

    <div x-show="loading" class="text-center py-12 text-gray-500">Loading media...</div>

    <div x-show="!loading && files.length === 0" class="text-center py-12 bg-white rounded-xl border border-gray-100">
        <p class="text-gray-500">No files uploaded yet.</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <template x-for="file in files" :key="file.path">
            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm group">
                <div class="aspect-square bg-gray-50 flex items-center justify-center p-2">
                    <template x-if="isImage(file.name)">
                        <img :src="file.url" :alt="file.name" class="max-h-full max-w-full object-contain">
                    </template>
                    <template x-if="!isImage(file.name)">
                        <div class="text-center p-4">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-gray-500 mt-2 truncate" x-text="file.name"></p>
                        </div>
                    </template>
                </div>
                <div class="p-3 border-t border-gray-100">
                    <p class="text-xs font-medium text-gray-800 truncate" x-text="file.name" :title="file.name"></p>
                    <p class="text-xs text-gray-500" x-text="formatSize(file.size)"></p>
                    <div class="flex gap-2 mt-2">
                        <button @click="copyUrl(file.url)" class="text-xs text-primary hover:underline">Copy URL</button>
                        <button @click="remove(file)" class="text-xs text-red-600 hover:underline">Delete</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection

@push('scripts')
<script>
function mediaLibrary() {
    return {
        files: [],
        search: '',
        loading: true,
        uploading: false,

        isImage(name) {
            return /\.(jpe?g|png|gif|webp|svg)$/i.test(name);
        },

        formatSize(bytes) {
            if (!bytes) return '0 B';
            const units = ['B', 'KB', 'MB'];
            let i = 0;
            while (bytes >= 1024 && i < units.length - 1) { bytes /= 1024; i++; }
            return `${bytes.toFixed(1)} ${units[i]}`;
        },

        async load() {
            this.loading = true;
            try {
                const params = this.search ? `?search=${encodeURIComponent(this.search)}` : '';
                const res = await Admin.fetch(`${Admin.apiBase}/media${params}`);
                this.files = res.data || [];
            } catch (err) {
                Admin.toast(err.message, 'error');
            } finally {
                this.loading = false;
            }
        },

        async upload(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.uploading = true;
            const fd = new FormData();
            fd.append('file', file);
            try {
                await Admin.fetch(`${Admin.apiBase}/media/upload`, { method: 'POST', body: fd });
                Admin.toast('File uploaded');
                await this.load();
            } catch (err) {
                Admin.toast(err.message, 'error');
            } finally {
                this.uploading = false;
                e.target.value = '';
            }
        },

        async remove(file) {
            if (!confirm(`Delete ${file.name}?`)) return;
            try {
                await Admin.fetch(`${Admin.apiBase}/media`, { method: 'DELETE', body: { path: file.path } });
                Admin.toast('File deleted');
                await this.load();
            } catch (err) {
                Admin.toast(err.message, 'error');
            }
        },

        copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => Admin.toast('URL copied', 'info'));
        },
    };
}
</script>
@endpush
