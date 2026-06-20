<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('components.seo', ['seo' => $seo ?? []])

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <x-vite-assets />
    @stack('styles')
</head>
<body class="font-body bg-background text-dark antialiased">
    {{-- Flash Toast --}}
    @if(session('success') || session('error') || session('message'))
        <div
            x-data="flashToast"
            data-message="{{ session('success') ?? session('error') ?? session('message') }}"
            data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : 'info') }}"
            x-show="show"
            x-transition
            class="fixed right-4 top-24 z-[100] max-w-sm"
        >
            <div :class="type === 'success' ? 'border-secondary bg-white' : (type === 'error' ? 'border-red-500 bg-white' : 'border-primary bg-white')" class="glass-card flex items-center gap-3 rounded-xl border-l-4 p-4 shadow-card">
                <i :class="type === 'success' ? 'fas fa-check-circle text-secondary' : (type === 'error' ? 'fas fa-exclamation-circle text-red-500' : 'fas fa-info-circle text-primary')"></i>
                <p class="text-sm font-medium text-dark" x-text="message"></p>
                <button @click="show = false" class="ml-auto text-muted hover:text-dark">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Header --}}
    <header
        x-data="{ ...headerScroll(), ...mobileMenu() }"
        :class="scrolled ? 'bg-white/95 shadow-soft backdrop-blur-md py-3' : 'bg-transparent py-5'"
        class="fixed left-0 right-0 top-0 z-50 transition-all duration-300"
    >
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <x-logo class="sm:h-12" />
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden items-center gap-1 xl:flex">
                {{-- About Mega Menu --}}
                <div class="group relative">
                    <button :class="scrolled ? 'text-dark' : 'text-white'" class="nav-link flex items-center gap-1 px-4 py-2">
                        About <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </button>
                    <div class="invisible absolute left-0 top-full z-50 w-64 pt-2 opacity-0 transition-all group-hover:visible group-hover:opacity-100">
                        <div class="glass-card rounded-2xl p-4 shadow-card">
                            <a href="{{ url('/about') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">About Us</a>
                            <a href="{{ url('/leadership') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">Leadership</a>
                            <a href="{{ url('/global-presence') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">Global Presence</a>
                            <a href="{{ url('/csr') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">CSR Activities</a>
                        </div>
                    </div>
                </div>

                {{-- Services Mega Menu --}}
                <div class="group relative">
                    <button :class="scrolled ? 'text-dark' : 'text-white'" class="nav-link flex items-center gap-1 px-4 py-2">
                        Services <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </button>
                    <div class="invisible absolute left-0 top-full z-50 w-80 pt-2 opacity-0 transition-all group-hover:visible group-hover:opacity-100">
                        <div class="glass-card rounded-2xl p-4 shadow-card">
                            <div class="grid grid-cols-1 gap-1">
                                <a href="{{ url('/services') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">All Services</a>
                                <a href="{{ url('/manufacturing') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">Manufacturing</a>
                                <a href="{{ url('/partners') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">Understanding Partners</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products Mega Menu --}}
                <div class="group relative">
                    <button :class="scrolled ? 'text-dark' : 'text-white'" class="nav-link flex items-center gap-1 px-4 py-2">
                        Products <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </button>
                    <div class="invisible absolute left-0 top-full z-50 w-80 pt-2 opacity-0 transition-all group-hover:visible group-hover:opacity-100">
                        <div class="glass-card rounded-2xl p-4 shadow-card">
                            <a href="{{ url('/products') }}" class="block rounded-xl px-4 py-3 text-sm font-medium text-dark hover:bg-primary/5">All Products</a>
                            <div class="my-2 border-t border-border"></div>
                            @foreach(['Tablets', 'Capsules', 'Injectables', 'Oncology', 'Ophthalmic', 'Liquids'] as $cat)
                                <a href="{{ url('/products?category=' . strtolower($cat)) }}" class="block rounded-xl px-4 py-2 text-sm text-muted hover:bg-primary/5 hover:text-primary">{{ $cat }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="{{ url('/careers') }}" :class="scrolled ? 'text-dark' : 'text-white'" class="nav-link px-4 py-2">Careers</a>
                <a href="{{ url('/contact') }}" :class="scrolled ? 'text-dark' : 'text-white'" class="nav-link px-4 py-2">Contact</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ url('/products') }}" :class="scrolled ? 'text-dark hover:text-primary' : 'text-white hover:text-accent'" class="hidden p-2 transition-colors sm:block" aria-label="Search Products">
                    <i data-lucide="search" class="h-5 w-5"></i>
                </a>
                <a href="{{ url('/contact') }}" class="btn-primary hidden text-sm !py-2.5 !px-5 sm:inline-flex">
                    Contact Us
                </a>
                <button
                    @click="toggle()"
                    :class="scrolled ? 'text-dark' : 'text-white'"
                    class="rounded-lg p-2 xl:hidden"
                    aria-label="Toggle menu"
                >
                    <i data-lucide="menu" class="h-6 w-6" x-show="!open"></i>
                    <i data-lucide="x" class="h-6 w-6" x-show="open" x-cloak></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-transition @click.outside="close()" class="xl:hidden" x-cloak>
            <div class="border-t border-white/10 bg-white shadow-card">
                <div class="mx-auto max-w-7xl space-y-1 px-4 py-4">
                    <button @click="toggleDropdown('about')" class="flex w-full items-center justify-between rounded-xl px-4 py-3 font-medium text-dark hover:bg-primary/5">
                        About <i data-lucide="chevron-down" class="h-4 w-4" :class="activeDropdown === 'about' && 'rotate-180'"></i>
                    </button>
                    <div x-show="activeDropdown === 'about'" x-collapse class="ml-4 space-y-1">
                        <a href="{{ url('/about') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">About Us</a>
                        <a href="{{ url('/leadership') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">Leadership</a>
                        <a href="{{ url('/global-presence') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">Global Presence</a>
                        <a href="{{ url('/csr') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">CSR</a>
                    </div>

                    <button @click="toggleDropdown('services')" class="flex w-full items-center justify-between rounded-xl px-4 py-3 font-medium text-dark hover:bg-primary/5">
                        Services <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </button>
                    <div x-show="activeDropdown === 'services'" class="ml-4 space-y-1">
                        <a href="{{ url('/services') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">All Services</a>
                        <a href="{{ url('/manufacturing') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">Manufacturing</a>
                        <a href="{{ url('/partners') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">Partners</a>
                    </div>

                    <button @click="toggleDropdown('products')" class="flex w-full items-center justify-between rounded-xl px-4 py-3 font-medium text-dark hover:bg-primary/5">
                        Products <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </button>
                    <div x-show="activeDropdown === 'products'" class="ml-4 space-y-1">
                        <a href="{{ url('/products') }}" class="block rounded-lg px-4 py-2 text-sm text-muted hover:text-primary">All Products</a>
                    </div>

                    <a href="{{ url('/careers') }}" class="block rounded-xl px-4 py-3 font-medium text-dark hover:bg-primary/5">Careers</a>
                    <a href="{{ url('/contact') }}" class="block rounded-xl px-4 py-3 font-medium text-dark hover:bg-primary/5">Contact</a>
                    <a href="{{ url('/contact') }}" class="btn-primary mt-4 w-full text-center">Contact Us</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-4">
                <div class="lg:col-span-1">
                    <a href="{{ url('/') }}">
                        <x-logo class="h-14 bg-white p-1.5" />
                    </a>
                    <p class="mt-4 text-sm leading-relaxed text-white/70">
                        Global Healthcare Solutions Built on Trust, Quality & Innovation. Delivering affordable quality pharmaceutical products across the globe since 1986.
                    </p>
                    <div class="mt-6 flex gap-3">
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-secondary"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-secondary"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-secondary"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/919820351123" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-secondary"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-heading font-semibold">Quick Links</h4>
                    <ul class="mt-4 space-y-3 text-sm text-white/70">
                        <li><a href="{{ url('/about') }}" class="transition-colors hover:text-accent">About Us</a></li>
                        <li><a href="{{ url('/services') }}" class="transition-colors hover:text-accent">Services</a></li>
                        <li><a href="{{ url('/products') }}" class="transition-colors hover:text-accent">Products</a></li>
                        <li><a href="{{ url('/manufacturing') }}" class="transition-colors hover:text-accent">Manufacturing</a></li>
                        <li><a href="{{ url('/careers') }}" class="transition-colors hover:text-accent">Careers</a></li>
                        <li><a href="{{ url('/contact') }}" class="transition-colors hover:text-accent">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-heading font-semibold">Our Services</h4>
                    <ul class="mt-4 space-y-3 text-sm text-white/70">
                        <li>Product Development</li>
                        <li>Contract Manufacturing</li>
                        <li>Private Label</li>
                        <li>Regulatory Support</li>
                        <li>R&D & Technology Transfer</li>
                        <li>Quality Assurance</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-heading font-semibold">Newsletter</h4>
                    <p class="mt-4 text-sm text-white/70">Stay updated with our latest products and industry insights.</p>
                    <form action="#" method="POST" class="mt-4 space-y-3">
                        @csrf
                        <input type="email" name="email" placeholder="Your email address" class="form-input !bg-white/10 !border-white/20 !text-white placeholder:!text-white/50" required>
                        <button type="submit" class="btn-secondary w-full">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 sm:flex-row">
                <p class="text-sm text-white/60">&copy; {{ date('Y') }} Elama Healthcare Solutions Pvt. Ltd. All rights reserved.</p>
                <div class="flex gap-6 text-sm text-white/60">
                    <a href="{{ url('/privacy') }}" class="transition-colors hover:text-accent">Privacy Policy</a>
                    <a href="{{ url('/terms') }}" class="transition-colors hover:text-accent">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <style>[x-cloak]{display:none!important}</style>
</body>
</html>
