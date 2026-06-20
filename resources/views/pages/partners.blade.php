@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Understanding Partners']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Partnerships</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Understanding Partners</h1>
            <p class="mt-4 text-lg text-white/80">Building long-standing relationships through flexible, dynamic, and mutually beneficial partnerships.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <h2 class="font-heading text-2xl font-bold text-dark">Flexible Approach</h2>
                <p class="mt-4 leading-relaxed text-muted">
                    We adopt a flexible approach with our customers and create a healthy environment for a successful business relationship. Our flexible approach has turned many of our customers into our long standing partners.
                </p>
                <h2 class="font-heading text-2xl font-bold text-dark mt-8">Dynamic Partnership</h2>
                <p class="mt-4 leading-relaxed text-muted">
                    We share our insights and experiences with our customers to assure mutual success. In summary, our speedy, flexible, high quality, time efficient end-to-end services and competitive pricing make us a compelling value proposition.
                </p>
            </div>
            <div data-aos="fade-left">
                <div class="glass-card rounded-2xl p-8">
                    <h3 class="font-heading text-xl font-semibold text-dark">Why Partner With Elama?</h3>
                    <ul class="mt-6 space-y-4">
                        @foreach([
                            'Competitive pricing with cost efficiency focus',
                            'Time management and prompt response time',
                            'Safety, health and environment at every step',
                            'End-to-end services from R&D to logistics',
                            'Trustworthy handling of confidential information',
                            'Professional sales and marketing expertise',
                        ] as $point)
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary/10 text-secondary"><i class="fas fa-check text-xs"></i></span>
                                <span class="text-sm text-dark-muted">{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Our Partners" title="Trusted Global Partners" subtitle="Collaborating with leading pharmaceutical companies worldwide." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['name' => 'GlobalMed Partners', 'region' => 'Europe', 'type' => 'Contract Manufacturing', 'desc' => 'Long-standing CM partner for oral solid dosage forms across EU markets.'],
                ['name' => 'AfriPharma Ltd.', 'region' => 'East Africa', 'type' => 'Distribution', 'desc' => 'Exclusive distribution partner for Kenya and Tanzania markets.'],
                ['name' => 'AsiaPharm Co.', 'region' => 'Southeast Asia', 'type' => 'Licensing', 'desc' => 'Dossier licensing partner for Vietnam and Cambodia registrations.'],
                ['name' => 'MedSupply International', 'region' => 'Global', 'type' => 'Tender Supply', 'desc' => 'WHO prequalified product supply for institutional tenders.'],
                ['name' => 'HealthFirst Distribution', 'region' => 'South Asia', 'type' => 'Private Label', 'desc' => 'Private label partnership for Nepal and Myanmar markets.'],
                ['name' => 'PharmaTech Solutions', 'region' => 'Middle East', 'type' => 'Technology Transfer', 'desc' => 'Technology transfer and joint development for injectable products.'],
            ] as $partner)
                <div class="glass-card hover-lift rounded-2xl p-6 lg:p-8" data-aos="fade-up">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 font-heading text-lg font-bold text-primary">
                            {{ strtoupper(substr($partner['name'], 0, 1)) }}
                        </div>
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold text-accent-dark">{{ $partner['type'] }}</span>
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-dark">{{ $partner['name'] }}</h3>
                    <p class="mt-1 text-sm text-secondary font-medium">{{ $partner['region'] }}</p>
                    <p class="mt-3 text-sm text-muted">{{ $partner['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-section title="Become a Partner" subtitle="Join our global network of partners and grow your pharmaceutical business with Elama Healthcare." primaryLabel="Partner With Us" />
@endsection
