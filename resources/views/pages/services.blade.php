@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Services']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">What We Offer</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Our Services</h1>
            <p class="mt-4 text-lg text-white/80">Comprehensive pharmaceutical services from development to delivery.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach([
                [
                    'title' => 'Product Development',
                    'icon' => 'fas fa-lightbulb',
                    'description' => 'End-to-end product development from conceiving product profiles to dossier preparation for submission.',
                    'features' => ['Pre formulation studies', 'Lab formula development', 'Scale up & process optimization', 'Stability studies per ICH guidelines', 'Pilot scale mfg in cGMP facility'],
                ],
                [
                    'title' => 'Contract Manufacturing',
                    'icon' => 'fas fa-industry',
                    'description' => 'Finest quality yet cost effective solutions based on integrated R&D, technology and engineering capabilities.',
                    'features' => ['IR tablets & hard gelatine capsules', 'Enteric coated tablets & soft gel capsules', 'Suspensions, solutions & liquids', 'Parenteral (SVP, dry powder, lyophilized)', 'Creams & non-sterile products'],
                ],
                [
                    'title' => 'Private Label',
                    'icon' => 'fas fa-tag',
                    'description' => 'Generics and custom formulation activities across multiple dosage forms and technologies.',
                    'features' => ['IR & MR coated tablets', 'Dispersible & chewable tablets', 'Effervescent tablets', 'Enteric coated technology', 'Palletization technology'],
                ],
                [
                    'title' => 'Regulatory Support',
                    'icon' => 'fas fa-file-medical',
                    'description' => 'Comprehensive dossier preparation and regulatory submission support for global markets.',
                    'features' => ['Dossier preparation for submission', 'eCTD dossier submission', 'Technical assistance for CM', 'Data management for transfer', 'Regulatory affairs support'],
                ],
                [
                    'title' => 'Dossier Licensing',
                    'icon' => 'fas fa-file-contract',
                    'description' => 'Out-licensing of our own product dossiers to potential partners through supplying agreements.',
                    'features' => ['Ready dossier portfolio', 'Supplying agreements', 'Market-specific registrations', 'Technical documentation transfer'],
                ],
                [
                    'title' => 'R&D',
                    'icon' => 'fas fa-flask',
                    'description' => 'Dedicated scientific pool working on generic drug development including non-infringing generics and VAGs.',
                    'features' => ['15% dedicated R&D workforce', 'Technology innovation', 'Cost effective development', 'Non-infringing generic products', 'Value added generics (VAGs)'],
                ],
                [
                    'title' => 'Technology Transfer',
                    'icon' => 'fas fa-exchange-alt',
                    'description' => 'Seamless technology transfer from R&D lab to manufacturing with identical equipment and processes.',
                    'features' => ['Lab to plant scale transfer', 'Process validation support', 'Analytical method transfer', 'Documentation & training'],
                ],
                [
                    'title' => 'Quality Assurance',
                    'icon' => 'fas fa-shield-alt',
                    'description' => 'Strong QC/QA systems with modern instrumentation, experienced personnel, and quality risk management.',
                    'features' => ['Advanced instrumentation', 'Quality risk management', 'Batch traceability', 'WHO GMP compliance'],
                ],
                [
                    'title' => 'Logistics',
                    'icon' => 'fas fa-truck',
                    'description' => 'Logistics support ensuring products reach customers in shortest time, safe storage, and competitive cost.',
                    'features' => ['Global shipping network', 'Cold chain management', 'GDP compliance', 'Competitive pricing'],
                ],
            ] as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="IPMC" title="Intellectual Property Management" subtitle="Safeguarding innovation through expert patent analysis and filing." />
        <div class="glass-card rounded-2xl p-8 lg:p-12" data-aos="fade-up">
            <div class="grid gap-8 lg:grid-cols-2">
                <div>
                    <p class="text-muted leading-relaxed">
                        We have a well qualified and skilled team with technical expertise in generating patent landscape reports for various regions and evaluating non-infringing claims by performing infringing analysis on patent claims.
                    </p>
                    <ul class="mt-6 space-y-3">
                        @foreach(['Patent landscape reports', 'Non-infringing claim analysis', 'National & international patent filing', 'R&D pipeline elucidation', 'Co-development project support'] as $item)
                            <li class="flex items-start gap-2 text-sm text-dark-muted">
                                <i class="fas fa-check-circle mt-0.5 text-secondary"></i>{{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="flex items-center justify-center">
                    <div class="rounded-2xl bg-gradient-to-br from-primary/5 to-accent/10 p-12 text-center">
                        <i class="fas fa-balance-scale text-5xl text-primary mb-4"></i>
                        <p class="font-heading text-lg font-semibold text-dark">Indispensable IP Support</p>
                        <p class="mt-2 text-sm text-muted">For product filing strategies and pipeline development</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-cta-section />
@endsection
