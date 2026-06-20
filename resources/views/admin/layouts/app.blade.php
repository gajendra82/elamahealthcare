<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name', 'Elama Healthcare') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#008641',
                        secondary: '#A6C724',
                        'primary-dark': '#006432',
                        'secondary-dark': '#8AA81E',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link.active { background-color: rgba(255,255,255,0.15); border-left: 3px solid #A6C724; }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }
        table.dataTable thead th { border-bottom: 2px solid #008641 !important; }
        .dt-layout-row { margin-bottom: 0.75rem; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transition-transform duration-200 lg:static lg:translate-x-0 flex flex-col">
            <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <x-logo class="h-10 bg-white p-1" />
                <div>
                    <p class="font-semibold text-sm leading-tight">Elama Healthcare</p>
                    <p class="text-xs text-white/70">Admin Panel</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @php
                    $links = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.products.index', 'label' => 'Products', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                        ['route' => 'admin.categories.index', 'label' => 'Categories', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
                        ['route' => 'admin.leadership.index', 'label' => 'Leadership', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['route' => 'admin.csr.index', 'label' => 'CSR Gallery', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['route' => 'admin.partners.index', 'label' => 'Partners', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['route' => 'admin.news.index', 'label' => 'News', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                        ['route' => 'admin.jobs.index', 'label' => 'Jobs', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-2 4h12'],
                        ['route' => 'admin.enquiries.index', 'label' => 'Enquiries', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['route' => 'admin.banners.index', 'label' => 'Banners', 'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],
                        ['route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                        ['route' => 'admin.media.index', 'label' => 'Media', 'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
                        ['route' => 'admin.settings.index', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ];
                @endphp

                @foreach ($links as $link)
                    <a href="{{ route($link['route']) }}"
                       class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-white/90 hover:bg-white/10 transition {{ request()->routeIs($link['route']) ? 'active' : '' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link['icon'] }}"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="p-4 border-t border-white/10">
                <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 text-xs text-white/70 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Website
                </a>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-200 px-4 lg:px-8 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Admin')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-dark rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                <div id="admin-toast" class="fixed top-4 right-4 z-[100] hidden">
                    <div class="px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium max-w-sm"></div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        window.Admin = {
            apiBase: '{{ url('/admin/api') }}',
            csrfToken: document.querySelector('meta[name="csrf-token"]').content,
            uploadUrlPrefix: @json($storageUrlPrefix),

            storageUrl(path) {
                if (!path) return null;
                if (path.startsWith('http') || path.startsWith('/')) return path;
                if (path.startsWith('images/')) return `/${path}`;
                if (path.startsWith('uploads/') || path.startsWith('storage/')) return `/${path}`;
                return `/${this.uploadUrlPrefix}/${path}`;
            },

            toast(message, type = 'success') {
                const el = document.getElementById('admin-toast');
                const inner = el.querySelector('div');
                inner.textContent = message;
                inner.className = `px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium max-w-sm ${
                    type === 'error' ? 'bg-red-600' : type === 'info' ? 'bg-primary' : 'bg-secondary'
                }`;
                el.classList.remove('hidden');
                setTimeout(() => el.classList.add('hidden'), 4000);
            },

            async fetch(url, options = {}) {
                const headers = {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(options.headers || {}),
                };

                if (options.body && !(options.body instanceof FormData)) {
                    headers['Content-Type'] = 'application/json';
                    options.body = JSON.stringify(options.body);
                }

                const response = await fetch(url, { ...options, headers });

                let data = null;
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    data = await response.json();
                }

                if (!response.ok) {
                    const message = data?.message || (data?.errors ? Object.values(data.errors).flat().join(' ') : 'Request failed');
                    throw new Error(message);
                }

                return data;
            },

            initDataTable(selector, endpoint, columns, options = {}) {
                return new DataTable(selector, {
                    processing: true,
                    serverSide: true,
                    ajax: (data, callback) => {
                        const page = Math.floor(data.start / data.length) + 1;
                        const params = new URLSearchParams({
                            page: page,
                            per_page: data.length,
                        });
                        if (data.search?.value) {
                            params.set('search', data.search.value);
                        }
                        if (options.extraParams) {
                            Object.entries(options.extraParams()).forEach(([k, v]) => {
                                if (v) params.set(k, v);
                            });
                        }

                        this.fetch(`${this.apiBase}/${endpoint}?${params}`)
                            .then(json => {
                                callback({
                                    draw: data.draw,
                                    recordsTotal: json.total ?? json.data?.length ?? 0,
                                    recordsFiltered: json.total ?? json.data?.length ?? 0,
                                    data: json.data ?? json,
                                });
                            })
                            .catch(err => {
                                this.toast(err.message, 'error');
                                callback({ draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: [] });
                            });
                    },
                    columns,
                    order: options.order ?? [[0, 'desc']],
                    pageLength: options.pageLength ?? 15,
                    language: { emptyTable: 'No records found', processing: 'Loading...' },
                    ...options.tableOptions,
                });
            },

            badge(status, map = {}) {
                const colors = {
                    active: 'bg-green-100 text-green-800',
                    inactive: 'bg-gray-100 text-gray-800',
                    new: 'bg-blue-100 text-blue-800',
                    read: 'bg-yellow-100 text-yellow-800',
                    replied: 'bg-green-100 text-green-800',
                    ...map,
                };
                const cls = colors[status] || 'bg-gray-100 text-gray-800';
                return `<span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${cls}">${status}</span>`;
            },

            boolBadge(val) {
                return val
                    ? '<span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Yes</span>'
                    : '<span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">No</span>';
            },

            escapeHtml(str) {
                if (str == null) return '';
                const div = document.createElement('div');
                div.textContent = str;
                return div.innerHTML;
            },

            truncate(str, len = 60) {
                if (!str) return '';
                return str.length > len ? str.substring(0, len) + '…' : str;
            },
        };
    </script>

    @stack('scripts')
</body>
</html>
