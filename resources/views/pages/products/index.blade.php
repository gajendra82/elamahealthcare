@extends('layouts.app')

@section('content')
@php
    $products = [
        ['id' => 1, 'name' => 'Amoxicillin Capsules', 'category' => 'Capsules', 'strength' => '250mg, 500mg', 'description' => 'Broad-spectrum antibiotic for bacterial infections.', 'image' => asset('images/products/amoxicillin.jpg'), 'url' => url('/products/amoxicillin-capsules')],
        ['id' => 2, 'name' => 'Metformin Tablets', 'category' => 'Tablets', 'strength' => '500mg, 850mg, 1000mg', 'description' => 'First-line oral antidiabetic agent for type 2 diabetes management.', 'image' => asset('images/products/metformin.jpg'), 'url' => url('/products/metformin-tablets')],
        ['id' => 3, 'name' => 'Atorvastatin Tablets', 'category' => 'Tablets', 'strength' => '10mg, 20mg, 40mg, 80mg', 'description' => 'HMG-CoA reductase inhibitor for hyperlipidemia and cardiovascular protection.', 'image' => asset('images/products/atorvastatin.jpg'), 'url' => url('/products/atorvastatin-tablets')],
        ['id' => 4, 'name' => 'Ceftriaxone Injection', 'category' => 'Injectables', 'strength' => '250mg, 500mg, 1g', 'description' => 'Third-generation cephalosporin antibiotic for severe bacterial infections.', 'image' => asset('images/products/ceftriaxone.jpg'), 'url' => url('/products/ceftriaxone-injection')],
        ['id' => 5, 'name' => 'Omeprazole Capsules', 'category' => 'Capsules', 'strength' => '20mg, 40mg', 'description' => 'Proton pump inhibitor for GERD and peptic ulcer disease.', 'image' => asset('images/products/omeprazole.jpg'), 'url' => url('/products/omeprazole-capsules')],
        ['id' => 6, 'name' => 'Ciprofloxacin Tablets', 'category' => 'Tablets', 'strength' => '250mg, 500mg, 750mg', 'description' => 'Fluoroquinolone antibiotic for urinary tract and respiratory infections.', 'image' => asset('images/products/ciprofloxacin.jpg'), 'url' => url('/products/ciprofloxacin-tablets')],
        ['id' => 7, 'name' => 'Doxorubicin Injection', 'category' => 'Oncology', 'strength' => '10mg, 50mg', 'description' => 'Anthracycline chemotherapy agent for various malignancies.', 'image' => asset('images/products/doxorubicin.jpg'), 'url' => url('/products/doxorubicin-injection')],
        ['id' => 8, 'name' => 'Timolol Eye Drops', 'category' => 'Ophthalmic', 'strength' => '0.25%, 0.5%', 'description' => 'Beta-blocker ophthalmic solution for glaucoma and ocular hypertension.', 'image' => asset('images/products/timolol.jpg'), 'url' => url('/products/timolol-eye-drops')],
        ['id' => 9, 'name' => 'Paracetamol Syrup', 'category' => 'Liquids', 'strength' => '120mg/5ml, 250mg/5ml', 'description' => 'Analgesic and antipyretic oral suspension for pain and fever relief.', 'image' => asset('images/products/paracetamol-syrup.jpg'), 'url' => url('/products/paracetamol-syrup')],
        ['id' => 10, 'name' => 'Azithromycin Tablets', 'category' => 'Tablets', 'strength' => '250mg, 500mg', 'description' => 'Macrolide antibiotic with extended tissue penetration.', 'image' => asset('images/products/azithromycin.jpg'), 'url' => url('/products/azithromycin-tablets')],
        ['id' => 11, 'name' => 'Losartan Tablets', 'category' => 'Tablets', 'strength' => '25mg, 50mg, 100mg', 'description' => 'Angiotensin II receptor blocker for hypertension management.', 'image' => asset('images/products/losartan.jpg'), 'url' => url('/products/losartan-tablets')],
        ['id' => 12, 'name' => 'Vitamin D3 Soft Gel', 'category' => 'Capsules', 'strength' => '1000 IU, 60000 IU', 'description' => 'Cholecalciferol supplement for bone health and calcium absorption.', 'image' => asset('images/products/vitamin-d3.jpg'), 'url' => url('/products/vitamin-d3-soft-gel')],
    ];
@endphp

<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Products']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Portfolio</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Our Products</h1>
            <p class="mt-4 text-lg text-white/80">Diversified pharmaceutical portfolio across key therapeutic segments.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background" x-data="productFilter" data-products='@json($products)'>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Search & Filters --}}
        <div class="glass-card mb-10 rounded-2xl p-6" data-aos="fade-up">
            <div class="grid gap-4 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-5">
                    <label class="mb-2 block text-sm font-medium text-dark">Search Products</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted"></i>
                        <input type="text" x-model="search" placeholder="Search by name or category..." class="form-input !pl-11">
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <label class="mb-2 block text-sm font-medium text-dark">Category</label>
                    <select x-model="category" class="form-input">
                        <option value="all">All Categories</option>
                        <template x-for="cat in categories" :key="cat">
                            <option :value="cat" x-text="cat"></option>
                        </template>
                    </select>
                </div>
                <div class="lg:col-span-4">
                    <label class="mb-2 block text-sm font-medium text-dark">Filter A-Z</label>
                    <div class="flex flex-wrap gap-1">
                        <button @click="letter = 'all'" :class="letter === 'all' ? 'bg-primary text-white' : 'bg-white text-dark hover:bg-primary/10'" class="rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors">All</button>
                        <template x-for="l in letters" :key="l">
                            <button @click="letter = l" :class="letter === l ? 'bg-primary text-white' : 'bg-white text-dark hover:bg-primary/10'" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold transition-colors" x-text="l"></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Results Count --}}
        <p class="mb-6 text-sm text-muted">
            Showing <span class="font-semibold text-dark" x-text="filtered.length"></span> products
        </p>

        {{-- Product Grid --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <template x-for="product in filtered" :key="product.id">
                <div data-aos="fade-up">
                    <a :href="product.url" class="group glass-card hover-lift block overflow-hidden rounded-2xl">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-primary/5 to-accent/10">
                            <img :src="product.image" :alt="product.name" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                            <span class="absolute left-4 top-4 rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-white" x-text="product.category"></span>
                        </div>
                        <div class="p-5">
                            <h3 class="font-heading text-lg font-semibold text-dark group-hover:text-primary" x-text="product.name"></h3>
                            <p class="mt-2 line-clamp-2 text-sm text-muted" x-text="product.description"></p>
                            <p class="mt-3 text-sm font-medium text-primary" x-text="product.strength"></p>
                        </div>
                    </a>
                </div>
            </template>
        </div>

        <div x-show="filtered.length === 0" class="py-16 text-center">
            <i data-lucide="search-x" class="mx-auto h-12 w-12 text-muted"></i>
            <p class="mt-4 text-lg font-medium text-dark">No products found</p>
            <p class="text-sm text-muted">Try adjusting your search or filters.</p>
        </div>

        {{-- Pagination placeholder --}}
        <div class="mt-12 flex items-center justify-center gap-2">
            <button class="rounded-lg border border-border px-4 py-2 text-sm font-medium text-muted hover:bg-primary hover:text-white transition-colors">Previous</button>
            <button class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white">1</button>
            <button class="rounded-lg border border-border px-4 py-2 text-sm font-medium text-muted hover:bg-primary hover:text-white transition-colors">2</button>
            <button class="rounded-lg border border-border px-4 py-2 text-sm font-medium text-muted hover:bg-primary hover:text-white transition-colors">Next</button>
        </div>
    </div>
</section>

<x-cta-section primaryLabel="Request Product Information" primaryUrl="/contact" />
@endsection
