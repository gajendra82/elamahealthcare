@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div x-data="settingsForm()" x-init="load()">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-sm text-gray-600">Configure site-wide settings by group.</p>
        <div class="flex gap-2 flex-wrap">
            <template x-for="group in groups" :key="group">
                <button @click="activeGroup = group"
                        :class="activeGroup === group ? 'bg-primary text-white' : 'bg-white text-gray-700 border border-gray-300'"
                        class="px-4 py-2 text-sm font-medium rounded-lg transition capitalize"
                        x-text="group"></button>
            </template>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form @submit.prevent="save()" class="space-y-4">
            <template x-for="(value, key) in currentSettings" :key="key">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 capitalize" x-text="key.replace(/_/g, ' ')"></label>
                    <template x-if="String(value).length > 100 || key.includes('description') || key.includes('mission') || key.includes('vision')">
                        <textarea x-model="form[key]" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"></textarea>
                    </template>
                    <template x-if="!(String(value).length > 100 || key.includes('description') || key.includes('mission') || key.includes('vision'))">
                        <input type="text" x-model="form[key]" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    </template>
                </div>
            </template>

            <p x-show="error" x-text="error" class="text-sm text-red-600"></p>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" :disabled="saving || loading" class="px-6 py-2 text-sm text-white bg-secondary hover:bg-secondary-dark rounded-lg disabled:opacity-50">
                    <span x-text="saving ? 'Saving...' : 'Save ' + activeGroup + ' Settings'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function settingsForm() {
    return {
        settings: {},
        form: {},
        activeGroup: 'company',
        groups: [],
        loading: true,
        saving: false,
        error: '',

        get currentSettings() {
            return this.settings[this.activeGroup] || {};
        },

        async load() {
            this.loading = true;
            try {
                const res = await Admin.fetch(`${Admin.apiBase}/settings`);
                this.settings = res.settings || {};
                this.groups = Object.keys(this.settings);
                if (this.groups.length && !this.groups.includes(this.activeGroup)) {
                    this.activeGroup = this.groups[0];
                }
                this.syncForm();
            } catch (err) {
                Admin.toast(err.message, 'error');
            } finally {
                this.loading = false;
            }
        },

        syncForm() {
            const group = this.settings[this.activeGroup] || {};
            this.form = {};
            Object.entries(group).forEach(([key, val]) => {
                this.form[key] = val ?? '';
            });
        },

        init() {
            this.$watch('activeGroup', () => this.syncForm());
        },

        async save() {
            this.saving = true;
            this.error = '';
            try {
                await Admin.fetch(`${Admin.apiBase}/settings`, {
                    method: 'PUT',
                    body: { settings: this.form, group: this.activeGroup },
                });
                Admin.toast('Settings saved');
                await this.load();
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
