@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Global Presence']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Worldwide</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Global Presence</h1>
            <p class="mt-4 text-lg text-white/80">Delivering affordable quality pharmaceuticals across continents through diverse business models.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2 mb-16">
            <div data-aos="fade-right">
                <h2 class="font-heading text-2xl font-bold text-dark">India Operations</h2>
                <p class="mt-4 leading-relaxed text-muted">
                    With an experience of more than two decades, Elama Healthcare is an established name in the Indian Pharmaceutical Industry. With its diversified product portfolio, it has gained leadership in various therapeutic segments including Cardiovascular, Diabetes, Orthopedics, Gynecology, Respiratory, and Oncology.
                </p>
            </div>
            <div data-aos="fade-left">
                <h2 class="font-heading text-2xl font-bold text-dark">International Operations</h2>
                <p class="mt-4 leading-relaxed text-muted">
                    Elama Healthcare has its presence in many overseas countries, operating through various business models like Private Markets, Tenders, Licensing, Contract Manufacturing, and Joint Ventures. We have successfully leveraged our production and R&D competency for supplying affordable quality pharmaceuticals across the globe.
                </p>
            </div>
        </div>

        <x-world-map :showList="true" />
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Business Models" title="How We Operate Globally" />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['icon' => 'fas fa-store', 'title' => 'Private Markets', 'desc' => 'Direct market access through our professional sales and marketing team with deep local know-how.'],
                ['icon' => 'fas fa-gavel', 'title' => 'Tenders', 'desc' => 'Participation in government and institutional tenders across developing markets.'],
                ['icon' => 'fas fa-file-contract', 'title' => 'Licensing', 'desc' => 'Dossier out-licensing and in-licensing agreements with global partners.'],
                ['icon' => 'fas fa-industry', 'title' => 'Contract Manufacturing', 'desc' => 'Third-party manufacturing for partners with full documentation support.'],
                ['icon' => 'fas fa-handshake', 'title' => 'Joint Ventures', 'desc' => 'Strategic partnerships for market entry and local manufacturing.'],
                ['icon' => 'fas fa-truck', 'title' => 'Distribution', 'desc' => 'GDP-compliant logistics ensuring safe and timely product delivery.'],
            ] as $model)
                <div class="glass-card hover-lift rounded-2xl p-6" data-aos="fade-up">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="{{ $model['icon'] }}"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-dark">{{ $model['title'] }}</h3>
                    <p class="mt-2 text-sm text-muted">{{ $model['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Markets" title="Countries We Serve" />
        <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach(\App\Support\GlobalPresence::allCountries() as $country)
                <div class="flex items-center gap-3 rounded-xl border border-border bg-white px-4 py-4 transition-all hover:border-secondary hover:shadow-soft" data-aos="fade-up">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-secondary/10 text-secondary">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                    </span>
                    <div>
                        <p class="font-medium text-dark">{{ $country['name'] }}</p>
                        <p class="text-xs text-muted">{{ $country['region'] }}@if($country['type'] === 'hq') · HQ @endif</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-section title="Expand Your Market Reach" subtitle="Partner with Elama Healthcare to access our global distribution network and regulatory expertise." />
@endsection
