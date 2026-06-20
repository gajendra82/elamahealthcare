@extends('layouts.app')

@section('content')
{{-- Hero Banner --}}
<x-hero-banner-carousel :banners="$banners" />

{{-- Feature Stats --}}
<section class="relative z-10 -mt-10 pb-4 lg:-mt-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <x-feature-stat-card icon="fas fa-globe" title="38+ Years of Excellence" description="Trusted pharmaceutical legacy" />
            <x-feature-stat-card icon="fas fa-pills" title="338+ Quality Products" description="Diversified portfolio" />
            <x-feature-stat-card icon="fas fa-map-marked-alt" title="15+ Countries Worldwide" description="Global market presence" />
            <x-feature-stat-card icon="fas fa-industry" title="WHO-GMP Approved Facilities" description="Quality manufacturing standards" />
            <x-feature-stat-card icon="fas fa-users" title="Dedicated Team of Professionals" description="Expert pharmaceutical workforce" class="sm:col-span-2 xl:col-span-1" />
        </div>
    </div>
</section>

{{-- About Preview --}}
<section id="about-preview" class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div data-aos="fade-right">
                <span class="section-label mb-4 inline-block">About Elama</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Global Healthcare Solutions</h2>
                <p class="mt-6 leading-relaxed text-muted">
                    We supply affordable and quality medicines across the globe, regardless of geographic and socio-economic barriers. Through our strong manufacturing services supported with a highly qualified technical team, we build blocks to produce an organization that manufactures therapeutics for a range of diseases.
                </p>
                <p class="mt-4 leading-relaxed text-muted">
                    Consistent growth and sustainability is a multidimensional aspiration for all at Elama Healthcare. We remain focused on providing quality and affordable medicines to billions of ailing patients across geographies and bridging the gap of unmet needs of the medical fraternity through continuous innovation.
                </p>
                <a href="{{ url('/about') }}" class="btn-primary mt-8 inline-flex">
                    Learn More About Us
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
            <div class="relative" data-aos="fade-left">
                <div class="overflow-hidden rounded-3xl shadow-card">
                    <x-image :src="config('assets.about_preview')" placeholder="about" alt="Elama Healthcare Facility" class="h-full w-full object-cover" />
                </div>
                <div class="absolute -bottom-6 -left-6 glass-card rounded-2xl p-6 shadow-card lg:-left-8">
                    <p class="font-heading text-4xl font-bold text-primary">14+</p>
                    <p class="text-sm font-medium text-muted">Countries Served</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Why Elama" title="Why Choose Us" subtitle="Our competitive advantages that make us a trusted global pharmaceutical partner." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['icon' => 'fas fa-hand-holding-medical', 'title' => 'Affordable Medicines', 'desc' => 'Making medicine obtainable and affordable for patients across the globe who trust our products.'],
                ['icon' => 'fas fa-industry', 'title' => 'GMP Manufacturing', 'desc' => 'All associated sites follow Good Manufacturing Practice ensuring the highest quality and safety for end users.'],
                ['icon' => 'fas fa-microscope', 'title' => 'Advanced R&D', 'desc' => 'Dedicated scientific pool with 15% workforce focused on generic drug development and value-added generics.'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Quality Assurance', 'desc' => 'Modern instrumentation, experienced personnel, and quality risk management systems in place.'],
                ['icon' => 'fas fa-handshake', 'title' => 'Trusted Partnership', 'desc' => 'We manage proprietary information professionally to maintain mutual trust and confidence with partners.'],
                ['icon' => 'fas fa-users', 'title' => 'Expert Team', 'desc' => 'Excellent team of senior and experienced professionals — a key differentiator in this competitive environment.'],
            ] as $item)
                <div class="glass-card hover-lift rounded-2xl p-6 lg:p-8" data-aos="fade-up">
                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-secondary/10 text-secondary">
                        <i class="{{ $item['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-dark">{{ $item['title'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $item['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Product Categories --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Portfolio" title="Product Categories" subtitle="Browse our pharma ready dossiers by dosage form." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $categoryIcons = [
                    'Tablet' => 'fas fa-tablets',
                    'Capsule' => 'fas fa-capsules',
                    'Injection' => 'fas fa-syringe',
                    'Drops' => 'fas fa-eye',
                    'Topical' => 'fas fa-hand-holding-medical',
                    'Liquid' => 'fas fa-flask',
                    'Inhalation' => 'fas fa-wind',
                    'Syrup' => 'fas fa-wine-bottle',
                ];
            @endphp
            @forelse($categories->take(8) as $category)
                <a href="{{ url('/products?category=' . $category->slug) }}" class="group glass-card hover-lift rounded-2xl p-6 text-center" data-aos="fade-up">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary/10 to-accent/10 text-primary transition-transform group-hover:scale-110">
                        <i class="{{ $categoryIcons[$category->name] ?? 'fas fa-pills' }} text-2xl"></i>
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-dark">{{ $category->name }}</h3>
                    <p class="mt-1 text-sm text-secondary font-medium">{{ $category->products_count }} Products</p>
                </a>
            @empty
                <p class="col-span-full text-center text-muted">Product categories will appear after the dossier list is imported.</p>
            @endforelse
        </div>
        <div class="mt-10 text-center">
            <a href="{{ url('/products') }}" class="btn-primary">View All Products</a>
        </div>
    </div>
</section>

{{-- Manufacturing Preview --}}
<section class="section-padding relative overflow-hidden bg-dark">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute right-0 top-0 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
    </div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Manufacturing" title="World-Class Production Capabilities" subtitle="WHO GMP, UKMHRA, EU GMP, and USFDA approved facilities across multiple dosage forms." :light="true" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach(['Tablets', 'Capsules', 'Soft Gel', 'Injectables', 'Creams', 'Liquids', 'Ophthalmic', 'Hormonal', 'Oncology', 'Parenteral'] as $form)
                <div class="glass-card-dark rounded-xl px-4 py-5 text-center text-white transition-transform hover:scale-105" data-aos="zoom-in">
                    <i class="fas fa-industry mb-2 text-accent"></i>
                    <p class="text-sm font-medium">{{ $form }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <a href="{{ url('/manufacturing') }}" class="btn-secondary">Explore Manufacturing</a>
        </div>
    </div>
</section>

{{-- Global Presence --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Worldwide" title="Global Presence" subtitle="Operating across private markets, tenders, licensing, contract manufacturing, and joint ventures." />
        <x-world-map :compact="true" />
        <div class="mt-8 text-center">
            <a href="{{ url('/global-presence') }}" class="btn-outline">View Global Operations</a>
        </div>
    </div>
</section>

{{-- Services Preview --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Services" title="End-to-End Pharmaceutical Services" subtitle="From product development to logistics — comprehensive solutions for global partners." />
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach(array_slice([
                ['title' => 'Product Development', 'description' => 'Conceiving product profiles, pre-formulation studies, lab formula development, and dossier preparation.', 'icon' => 'fas fa-lightbulb'],
                ['title' => 'Contract Manufacturing', 'description' => 'Finest quality yet cost effective solutions with integrated R&D, technology and engineering capabilities.', 'icon' => 'fas fa-industry'],
                ['title' => 'Private Label', 'description' => 'Custom formulation activities including IR, MR, dispersible, chewable, and effervescent tablets.', 'icon' => 'fas fa-tag'],
                ['title' => 'Regulatory Support', 'description' => 'Dossier preparation, eCTD submission, and technical assistance for contract manufacturing.', 'icon' => 'fas fa-file-medical'],
                ['title' => 'R&D', 'description' => 'Dedicated scientific pool working on generic drug development and value-added generics.', 'icon' => 'fas fa-flask'],
                ['title' => 'Logistics', 'description' => 'Ensuring products reach customers in shortest time, safe storage conditions, and competitive cost.', 'icon' => 'fas fa-truck'],
            ], 0, 6) as $service)
                <x-service-card :service="$service" />
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <a href="{{ url('/services') }}" class="btn-primary">All Services</a>
        </div>
    </div>
</section>

{{-- Quality Section --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <span class="section-label mb-4 inline-block">Quality</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Uncompromising Quality Standards</h2>
                <p class="mt-6 leading-relaxed text-muted">
                    In our constant endeavour to deliver highest quality products, we have put in place strong and effective Quality Control and Quality Assurance Systems consisting of modern, sophisticated instrumentation, highly experienced personnel, and quality risk management systems.
                </p>
                <ul class="mt-6 space-y-4">
                    @foreach(['Modern, sophisticated and advanced instrumentation', 'Highly experienced personnel', 'Quality risk management systems', 'WHO GMP, UKMHRA, EU GMP, USFDA compliance'] as $point)
                        <li class="flex items-start gap-3">
                            <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary/10 text-secondary"><i class="fas fa-check text-xs"></i></span>
                            <span class="text-dark-muted">{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                @foreach(['WHO GMP', 'UKMHRA', 'EU GMP', 'USFDA'] as $cert)
                    <div class="glass-card hover-lift flex flex-col items-center justify-center rounded-2xl p-8 text-center">
                        <i class="fas fa-certificate mb-3 text-3xl text-primary"></i>
                        <p class="font-heading font-semibold text-dark">{{ $cert }}</p>
                        <p class="mt-1 text-xs text-muted">Certified</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Certificates --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Certifications" title="Regulatory Approvals & Certifications" subtitle="Our manufacturing partners maintain the highest international standards." />
        <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-12">
            @foreach(config('assets.certificates', []) as $cert)
                <div class="glass-card hover-lift rounded-2xl p-6" data-aos="fade-up">
                    <x-image :src="$cert" placeholder="certificate" alt="Certification" class="h-16 w-auto object-contain grayscale transition-all hover:grayscale-0" />
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Leadership Preview --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Leadership" title="Meet Our Directors" subtitle="Experienced medical professionals leading Elama Healthcare's vision." />
        <div class="grid gap-8 md:grid-cols-2">
            @foreach($leadership as $member)
                <x-leadership-card :leader="[
                    'name' => $member->name,
                    'title' => $member->designation,
                    'qualification' => $member->qualification,
                    'photo_path' => $member->photo,
                    'bio' => $member->experience,
                    'highlights' => array_values(array_filter(preg_split('/\r\n|\r|\n/', (string) $member->achievements))),
                ]" />
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <a href="{{ url('/leadership') }}" class="btn-outline">View Full Leadership</a>
        </div>
    </div>
</section>

{{-- CSR Preview --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="grid grid-cols-2 gap-4" data-aos="fade-right">
                @forelse($csrGalleries as $gallery)
                    <div class="overflow-hidden rounded-2xl {{ $loop->index % 2 === 0 ? 'mt-8' : '' }}">
                        <x-image :src="$gallery->image" placeholder="csr" :alt="$gallery->title" class="h-48 w-full object-cover transition-transform hover:scale-105" />
                    </div>
                @empty
                    @foreach(config('assets.csr', []) as $csrImage)
                        <div class="overflow-hidden rounded-2xl {{ $loop->index % 2 === 0 ? 'mt-8' : '' }}">
                            <x-image :src="$csrImage" placeholder="csr" alt="CSR Activity" class="h-48 w-full object-cover transition-transform hover:scale-105" />
                        </div>
                    @endforeach
                @endforelse
            </div>
            <div data-aos="fade-left">
                <span class="section-label mb-4 inline-block">CSR</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Corporate Social Responsibility</h2>
                <p class="mt-6 leading-relaxed text-muted">
                    Our basic business philosophy, by its very nature, serves a social responsibility — we have a far better reason than profits alone to drive our performance. Sustainability is intrinsic to how we operate as a responsible global healthcare organization.
                </p>
                <a href="{{ url('/csr') }}" class="btn-primary mt-8 inline-flex">
                    View CSR Activities
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Testimonials" title="What Our Partners Say" subtitle="Trusted by healthcare professionals and business partners worldwide." />
        <div class="testimonial-swiper swiper relative pb-12">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <x-testimonial-card :testimonial="[
                            'name' => $testimonial->name,
                            'quote' => $testimonial->content,
                            'role' => $testimonial->designation,
                            'company' => $testimonial->company,
                        ]" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>

{{-- Latest News --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="News" title="Latest Updates" subtitle="Stay informed about our latest developments and industry insights." />
        <div class="grid gap-8 md:grid-cols-3">
            @foreach($news as $article)
                <article class="glass-card hover-lift group overflow-hidden rounded-2xl" data-aos="fade-up">
                    <div class="aspect-video overflow-hidden">
                        <x-image :src="$article->image" placeholder="news" :alt="$article->title" class="h-full w-full object-cover transition-transform group-hover:scale-105" />
                    </div>
                    <div class="p-6">
                        <time class="text-xs font-semibold uppercase tracking-wider text-secondary">{{ optional($article->published_at)->format('F Y') ?? $article->created_at->format('F Y') }}</time>
                        <h3 class="mt-2 font-heading text-lg font-semibold text-dark">{{ $article->title }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $article->excerpt }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact CTA --}}
<x-cta-section
    title="Partner With Elama Healthcare"
    subtitle="Join our global network of partners delivering affordable, quality pharmaceutical products to patients worldwide."
    primaryLabel="Get In Touch"
    primaryUrl="/contact"
    secondaryLabel="View Products"
    secondaryUrl="/products"
/>
@endsection
