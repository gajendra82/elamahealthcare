@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Manufacturing']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Production</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Manufacturing Capabilities</h1>
            <p class="mt-4 text-lg text-white/80">WHO GMP, UKMHRA, EU GMP, and USFDA approved facilities across diverse dosage forms.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Dosage Forms" title="Product Forms We Manufacture" subtitle="Comprehensive manufacturing capabilities across oral, parenteral, topical, and specialty dosage forms." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach([
                ['name' => 'Tablets', 'icon' => 'fas fa-tablets', 'desc' => 'IR & MR cores, film, enteric & sugar coated', 'certs' => 'WHO GMP, UKMHRA, USFDA'],
                ['name' => 'Capsules', 'icon' => 'fas fa-capsules', 'desc' => 'Hard gelatine & hormone capsules', 'certs' => 'WHO GMP, UKMHRA, USFDA'],
                ['name' => 'Soft Gel', 'icon' => 'fas fa-circle', 'desc' => 'Soft gelatine capsules', 'certs' => 'WHO GMP, USFDA'],
                ['name' => 'Injectables', 'icon' => 'fas fa-syringe', 'desc' => 'SVP, dry powder & lyophilized', 'certs' => 'WHO GMP, EU GMP'],
                ['name' => 'Creams', 'icon' => 'fas fa-pump-soap', 'desc' => 'Non-sterile topical formulations', 'certs' => 'WHO GMP'],
                ['name' => 'Liquids', 'icon' => 'fas fa-flask', 'desc' => 'Suspensions, solutions & oral liquids', 'certs' => 'WHO GMP, UKMHRA'],
                ['name' => 'Ophthalmic', 'icon' => 'fas fa-eye', 'desc' => 'Ophthalmic solutions & liquid injectables', 'certs' => 'WHO GMP, UKMHRA, USFDA'],
                ['name' => 'Hormonal', 'icon' => 'fas fa-dna', 'desc' => 'Hormone capsules with dedicated lines', 'certs' => 'WHO GMP'],
                ['name' => 'Oncology', 'icon' => 'fas fa-ribbon', 'desc' => 'Tablets, capsules, injectables & lyophilized', 'certs' => 'WHO GMP'],
                ['name' => 'Parenteral', 'icon' => 'fas fa-vial', 'desc' => 'Cephalosporin injectables & specialty lines', 'certs' => 'WHO GMP, EU GMP'],
            ] as $form)
                <div class="glass-card hover-lift group rounded-2xl p-6 text-center" data-aos="fade-up">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-primary-light text-white transition-transform group-hover:scale-110 group-hover:rotate-3">
                        <i class="{{ $form['icon'] }} text-2xl"></i>
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-dark">{{ $form['name'] }}</h3>
                    <p class="mt-2 text-xs text-muted">{{ $form['desc'] }}</p>
                    <div class="mt-3 flex flex-wrap justify-center gap-1">
                        @foreach(explode(', ', $form['certs']) as $cert)
                            <span class="rounded-full bg-secondary/10 px-2 py-0.5 text-[10px] font-semibold text-secondary">{{ $cert }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Approvals" title="Regulatory Approvals by Category" />
        <div class="overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead>
                    <tr class="border-b border-border">
                        <th class="px-6 py-4 text-left font-heading text-sm font-semibold text-dark">Product Category</th>
                        <th class="px-6 py-4 text-left font-heading text-sm font-semibold text-dark">Approvals</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['Beta lactam: Tablets, Capsules, Powder for Suspension/Syrup', 'WHO GMP, UKMHRA, EU GMP, USFDA'],
                        ['Cephalosporin Injectable', 'WHO GMP, EU GMP'],
                        ['Tablets, Capsules, Oral Solution, Soft Gel Capsules', 'WHO GMP, UKMHRA, USFDA'],
                        ['Pallets', 'WHO GMP, EU GMP'],
                        ['Ophthalmic Solutions, Liquid Injectable', 'WHO GMP, UKMHRA, USFDA'],
                        ['Oncology: Tablets, Capsules, Injectable, Lyophilized', 'WHO GMP'],
                        ['Capsules (Hormones)', 'WHO GMP'],
                    ] as $row)
                        <tr class="border-b border-border/50 transition-colors hover:bg-primary/5">
                            <td class="px-6 py-4 text-sm text-dark-muted">{{ $row[0] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(', ', $row[1]) as $cert)
                                        <span class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">{{ $cert }}</span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="glass-card rounded-2xl p-8 lg:p-12" data-aos="fade-up">
            <div class="grid items-center gap-8 lg:grid-cols-2">
                <div>
                    <h3 class="font-heading text-2xl font-bold text-dark">Special Manufacturing Lines</h3>
                    <p class="mt-4 text-muted leading-relaxed">
                        We are in position to manufacture special products where special lines are required for manufacturing due to colour or any other factor influencing the product. Our selection process for plants is systematic with major stress on capacities and vertical integration.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach(['Beta Lactam', 'Cephalosporin', 'Oncology', 'Hormonal'] as $line)
                        <div class="rounded-xl border border-border bg-white p-4 text-center">
                            <i class="fas fa-cogs mb-2 text-primary"></i>
                            <p class="text-sm font-semibold text-dark">{{ $line }} Line</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<x-cta-section />
@endsection
