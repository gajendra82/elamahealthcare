@extends('layouts.app')

@section('content')
{{-- Hero --}}
<section class="relative overflow-hidden bg-gradient-to-br from-dark via-[#0a4a5c] to-primary pt-32 pb-24">
    <div class="pointer-events-none absolute -right-32 top-0 h-96 w-96 rounded-full bg-accent/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 bottom-0 h-80 w-80 rounded-full bg-secondary/15 blur-3xl"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'About Us']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !border-white/20 !bg-white/10 !text-accent-mint">About Elama Healthcare</span>
            <h1 class="font-heading text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">Global Healthcare Solutions Built on Trust</h1>
            <p class="mt-6 text-lg leading-relaxed text-white/85 sm:text-xl">
                We supply affordable and quality medicines across the globe, regardless of geographic and socio-economic barriers.
            </p>
        </div>
    </div>
</section>
<x-wave-divider />

{{-- 1. About Elama Healthcare --}}
<section class="relative section-padding overflow-hidden bg-background">
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-dark/5 via-transparent to-primary/5"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-16 lg:grid-cols-2 lg:gap-20">
            <div data-aos="fade-right">
                <span class="section-label mb-4 inline-block">Company Overview</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">About Elama Healthcare</h2>
                <div class="mt-8 space-y-5 text-base leading-relaxed text-muted">
                    <p>
                        Through our strong manufacturing services supported with a highly qualified technical team, we build the foundation of an organization that manufactures therapeutics for a range of diseases.
                    </p>
                    <p>
                        Consistent growth and sustainability is a multidimensional aspiration for all at Elama Healthcare. We remain focused on providing quality and affordable medicines to billions of ailing patients across geographies and bridging the gap of unmet needs of the medical fraternity through continuous innovation.
                    </p>
                    <p>
                        Our basic business philosophy, by its very nature, serves a social responsibility — we have a far better reason than profits alone to drive our performance. Sustainability is intrinsic to how we operate as a responsible global healthcare organization.
                    </p>
                    <p>
                        Elama Healthcare is focused on increasing momentum through organic growth routes, well spread across geographies with focus on key therapeutic segments. We have forayed into high growth potential segments like Cardiovascular, Diabetes, Orthopedics, Gynecology, Respiratory and Oncology — adding significant depth to our existing product pipeline.
                    </p>
                </div>
            </div>
            <div class="relative" data-aos="fade-left">
                <div class="absolute -inset-4 rounded-[2rem] bg-gradient-to-br from-dark/20 via-primary/20 to-accent/20 blur-2xl"></div>
                <x-image
                    :src="config('assets.about_hero')"
                    placeholder="about"
                    alt="Elama Healthcare — professional pharmaceutical operations"
                    class="relative w-full rounded-3xl object-cover shadow-card ring-1 ring-white/60"
                />
            </div>
        </div>
    </div>
</section>

{{-- 2. Our Mission --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl" data-aos="fade-up">
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-dark to-primary p-10 shadow-card sm:p-14">
                <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-white/10"></div>
                <div class="relative flex flex-col gap-8 sm:flex-row sm:items-start">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-white backdrop-blur-sm">
                        <i class="fas fa-bullseye text-3xl"></i>
                    </div>
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-widest text-accent-mint">Our Mission</span>
                        <p class="mt-4 text-xl leading-relaxed text-white/95 sm:text-2xl">
                            Serve Global Healthcare needs through Empathy, Innovation and Technology. We believe that to ensure sustained growth, we need to clearly understand our customer's needs and use cutting edge technology to present innovative solutions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Our Vision --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl" data-aos="fade-up">
            <div class="relative overflow-hidden rounded-3xl border border-border bg-white p-10 shadow-soft sm:p-14">
                <div class="absolute left-0 top-0 h-1.5 w-full bg-gradient-to-r from-primary via-accent to-secondary"></div>
                <div class="flex flex-col gap-8 sm:flex-row sm:items-start">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-accent text-white shadow-glow">
                        <i class="fas fa-eye text-3xl"></i>
                    </div>
                    <div>
                        <span class="section-label mb-3 inline-block">Our Vision</span>
                        <p class="text-lg leading-relaxed text-muted sm:text-xl">
                            Lead the way to bring Wellness and Healthcare to the world. Evolving into a vertically integrated, globally active business, leading and developing special and effective wellness and healthcare products with a special emphasis on consumer safety to suit unique needs in today's exciting world. Evolve as an organization setting leadership benchmarks for innovation, excellence, growth, employee satisfaction, product safety and value creation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 4. Our Philosophy --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-16 lg:grid-cols-2 lg:gap-24">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="relative flex aspect-square max-w-lg items-center justify-center rounded-3xl bg-gradient-to-br from-dark/5 via-primary/10 to-accent/10 p-12">
                    <div class="absolute inset-8 rounded-3xl border border-primary/10"></div>
                    <div class="relative text-center">
                        <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-dark to-primary text-white shadow-card">
                            <i class="fas fa-lightbulb text-4xl"></i>
                        </div>
                        <div class="grid grid-cols-3 gap-4 opacity-80">
                            <div class="rounded-xl bg-white p-4 shadow-soft"><i class="fas fa-flask text-2xl text-primary"></i></div>
                            <div class="rounded-xl bg-white p-4 shadow-soft"><i class="fas fa-globe text-2xl text-accent"></i></div>
                            <div class="rounded-xl bg-white p-4 shadow-soft"><i class="fas fa-handshake text-2xl text-secondary"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <span class="section-label mb-4 inline-block">Our Philosophy</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Creating Opportunities, Optimizing Impact</h2>
                <p class="mt-8 text-lg leading-relaxed text-muted">
                    At Elama Healthcare, we believe in the art of first creating opportunities and then optimizing them to the fullest. In this manner, we identify the unmet medical needs across therapies in different markets and capitalize on them to optimum levels ahead of competition.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- 5. Core Values --}}
<section class="section-padding bg-gradient-to-b from-background to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="What We Stand For" title="Core Values" subtitle="The principles that guide every decision we make." />
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['name' => 'Respect', 'icon' => 'fas fa-heart', 'desc' => 'Treating every stakeholder — patients, partners, and employees — with dignity and consideration.'],
                ['name' => 'Honesty', 'icon' => 'fas fa-shield-alt', 'desc' => 'Transparent dealings and ethical practices in all our business relationships worldwide.'],
                ['name' => 'Affordability', 'icon' => 'fas fa-hand-holding-medical', 'desc' => 'Making quality medicines accessible and affordable to patients across all geographies.'],
                ['name' => 'Partnership', 'icon' => 'fas fa-users', 'desc' => 'Building long-standing relationships through flexible, dynamic, and mutually beneficial partnerships.'],
                ['name' => 'Customer Emphasis', 'icon' => 'fas fa-user-md', 'desc' => 'Understanding customer needs and delivering innovative solutions that exceed expectations.'],
                ['name' => 'Passion', 'icon' => 'fas fa-fire', 'desc' => 'Deep commitment to healthcare excellence that drives our team every single day.'],
            ] as $index => $value)
                <div class="group glass-card hover-lift rounded-2xl p-8 transition-all duration-300 hover:shadow-card" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 80 }}">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-dark to-primary text-white transition-transform duration-300 group-hover:scale-110">
                        <i class="{{ $value['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-dark">{{ $value['name'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 6. Our Strengths --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Competitive Edge" title="Our Strengths" subtitle="Delivering excellence across quality, affordability, and global reach." />
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['title' => 'Quality Medicines', 'icon' => 'fas fa-certificate', 'desc' => 'All associated sites follow Good Manufacturing Practice, ensuring the highest quality and safety for the end user.'],
                ['title' => 'Affordable Healthcare', 'icon' => 'fas fa-hand-holding-heart', 'desc' => 'Patients across the globe trust our medicines — we take that responsibility with great care, ensuring medicines are readily available for healthcare professionals and patients.'],
                ['title' => 'Global Presence', 'icon' => 'fas fa-globe-americas', 'desc' => 'Operating across international markets through private markets, tenders, licensing, contract manufacturing and joint ventures.'],
                ['title' => 'WHO GMP Manufacturing Network', 'icon' => 'fas fa-industry', 'desc' => 'Products manufactured at WHO GMP, UKMHRA, EU GMP and USFDA approved facilities across diverse therapeutic categories.'],
                ['title' => 'Experienced Team', 'icon' => 'fas fa-user-tie', 'desc' => 'A dedicated scientific pool and senior professionals with deep expertise in pharmaceutical development and commercialization.'],
                ['title' => 'Customer Commitment', 'icon' => 'fas fa-headset', 'desc' => 'Time-conscious, flexible, and responsive — we create healthy environments for successful long-term business relationships.'],
            ] as $index => $strength)
                <div class="rounded-2xl border border-border/80 bg-background p-8 transition-all duration-300 hover:border-primary/30 hover:shadow-soft" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 80 }}">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="{{ $strength['icon'] }} text-lg"></i>
                    </div>
                    <h3 class="font-heading text-lg font-semibold text-dark">{{ $strength['title'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $strength['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 7. Quality & Compliance --}}
<section class="relative section-padding overflow-hidden bg-gradient-to-br from-dark via-[#0a4a5c] to-primary">
    <div class="pointer-events-none absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.04\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !border-white/20 !bg-white/10 !text-accent-mint">Excellence</span>
            <h2 class="font-heading text-3xl font-bold text-white sm:text-4xl">Quality & Compliance</h2>
            <p class="mx-auto mt-4 max-w-2xl text-white/80">
                In our constant endeavour to deliver highest quality products, we have put in place strong and effective quality systems.
            </p>
        </div>
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach([
                ['title' => 'Quality Assurance', 'icon' => 'fas fa-check-double'],
                ['title' => 'Quality Control', 'icon' => 'fas fa-microscope'],
                ['title' => 'Quality Risk Management', 'icon' => 'fas fa-exclamation-triangle'],
                ['title' => 'Advanced Instrumentation', 'icon' => 'fas fa-cogs'],
                ['title' => 'Experienced Personnel', 'icon' => 'fas fa-user-graduate'],
            ] as $index => $item)
                <div class="glass-card-dark rounded-2xl p-6 text-center transition-transform duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ $index * 60 }}">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-white/10 text-accent-mint">
                        <i class="{{ $item['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading text-sm font-semibold leading-snug text-white">{{ $item['title'] }}</h3>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 8. Trust & Confidentiality --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-br from-dark to-[#0c5a6e] p-10 shadow-card sm:p-14 lg:p-16" data-aos="fade-up">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <span class="text-sm font-semibold uppercase tracking-widest text-accent-mint">Trust & Confidentiality</span>
                    <h2 class="mt-4 font-heading text-3xl font-bold text-white sm:text-4xl">Your Partner in Confidence</h2>
                    <p class="mt-6 leading-relaxed text-white/85">
                        We manage proprietary and sensitive customer specific information professionally to maintain mutual trust and confidence. We assure our customers of a totally trustworthy partner who can be relied upon to professionally manage and safeguard confidential matters.
                    </p>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach([
                        ['title' => 'Confidential Product Development', 'icon' => 'fas fa-lock'],
                        ['title' => 'R&D Protection', 'icon' => 'fas fa-flask'],
                        ['title' => 'Customer Trust', 'icon' => 'fas fa-handshake'],
                        ['title' => 'Long-term Partnerships', 'icon' => 'fas fa-link'],
                    ] as $item)
                        <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-sm transition-colors hover:bg-white/15">
                            <i class="{{ $item['icon'] }} text-2xl text-secondary"></i>
                            <h3 class="mt-4 font-heading text-sm font-semibold text-white">{{ $item['title'] }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 9. Our People --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-16 lg:grid-cols-2">
            <div data-aos="fade-right">
                <span class="section-label mb-4 inline-block">Our People</span>
                <h2 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Experienced Professionals Driving Excellence</h2>
                <p class="mt-6 text-lg leading-relaxed text-muted">
                    We have an excellent team of senior and experienced professionals to manage our business professionally. We firmly believe that our team will be a key differentiator in this competitive business environment.
                </p>
                <p class="mt-4 leading-relaxed text-muted">
                    From our dedicated scientific pool working on generic drug development to our highly professional sales and marketing teams across global markets — our people are the core power of our competitiveness and guarantee of our success.
                </p>
                <a href="{{ route('leadership') }}" class="btn-primary mt-8 inline-flex">
                    Meet Our Leadership
                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4" data-aos="fade-left">
                <div class="space-y-4">
                    <div class="glass-card rounded-2xl p-6">
                        <p class="font-heading text-4xl font-bold text-primary">15%</p>
                        <p class="mt-2 text-sm text-muted">Workforce dedicated to R&D and scientific development</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6">
                        <i class="fas fa-award text-2xl text-secondary"></i>
                        <p class="mt-3 font-heading font-semibold text-dark">Senior Leadership</p>
                        <p class="mt-1 text-sm text-muted">Decades of medical and pharmaceutical expertise</p>
                    </div>
                </div>
                <div class="space-y-4 pt-8">
                    <div class="glass-card rounded-2xl bg-gradient-to-br from-primary/5 to-accent/10 p-6">
                        <i class="fas fa-users text-2xl text-primary"></i>
                        <p class="mt-3 font-heading font-semibold text-dark">Global Teams</p>
                        <p class="mt-1 text-sm text-muted">Professional sales and marketing across international markets</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6">
                        <i class="fas fa-graduation-cap text-2xl text-accent"></i>
                        <p class="mt-3 font-heading font-semibold text-dark">Technical Excellence</p>
                        <p class="mt-1 text-sm text-muted">Qualified experts in formulation, quality, and compliance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<x-cta-section />
@endsection
