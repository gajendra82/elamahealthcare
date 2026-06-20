@extends('layouts.app')

@section('content')
{{-- Page Hero --}}
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'About Us']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">About Elama</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">About Elama Healthcare</h1>
            <p class="mt-4 text-lg text-white/80">Global Healthcare Solutions Built on Trust, Quality & Innovation since 1986.</p>
        </div>
    </div>
</section>
<x-wave-divider />

{{-- Company Overview --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <h2 class="font-heading text-3xl font-bold text-dark">Our Story</h2>
                <p class="mt-6 leading-relaxed text-muted">
                    Consistent growth and sustainability is a multidimensional aspiration for all at Elama Healthcare. We remain focused on providing quality and affordable medicines to billions of ailing patients across geographies and bridging the gap of unmet needs of the medical fraternity through continuous innovation.
                </p>
                <p class="mt-4 leading-relaxed text-muted">
                    Sustainability is not a trend we blindly follow — it is intrinsic to how we have operated since the genesis of the organization in the year 1986. Elama Healthcare is focused on increasing momentum in the business through organic growth routes, well spread across geographies with focus on key therapeutic segments.
                </p>
                <p class="mt-4 leading-relaxed text-muted">
                    We have forayed into high growth potential segments like Cardiovascular, Diabetes, Orthopedics, Gynecology, Respiratory and Oncology. These new growth areas add significant depth to the existing product pipeline.
                </p>
            </div>
            <div data-aos="fade-left">
                <x-image :src="config('assets.about_full')" placeholder="about" alt="Elama Healthcare" class="rounded-3xl shadow-card w-full" />
            </div>
        </div>
    </div>
</section>

{{-- Timeline --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Our Journey" title="Timeline: 1986 to Today" subtitle="Four decades of growth, innovation, and global healthcare impact." />
        <div class="relative mx-auto max-w-3xl">
            <div class="absolute left-4 top-0 h-full w-0.5 bg-border lg:left-1/2 lg:-translate-x-px"></div>
            @foreach([
                ['year' => '1986', 'title' => 'Foundation', 'desc' => 'Elama Healthcare Solutions Pvt. Ltd. established with a vision to serve global healthcare needs.'],
                ['year' => '1995', 'title' => 'Indian Market Leadership', 'desc' => 'Gained leadership in various therapeutic segments with a diversified product portfolio.'],
                ['year' => '2005', 'title' => 'International Expansion', 'desc' => 'Began operations in overseas markets through private markets, tenders, and licensing.'],
                ['year' => '2015', 'title' => 'R&D Investment', 'desc' => 'Built dedicated scientific pool with 15% workforce focused on generic drug development.'],
                ['year' => '2020', 'title' => 'Therapeutic Diversification', 'desc' => 'Expanded into Cardiovascular, Diabetes, Orthopedics, Gynecology, Respiratory, and Oncology.'],
                ['year' => 'Today', 'title' => 'Global Presence', 'desc' => 'Operating across 14+ countries with WHO GMP, UKMHRA, EU GMP, and USFDA approved facilities.'],
            ] as $event)
                <div @class(['relative mb-12 flex items-center', 'lg:flex-row-reverse' => $loop->iteration % 2 === 0]) data-aos="fade-up">
                    <div class="timeline-dot absolute left-4 z-10 lg:left-1/2 lg:-translate-x-1/2"></div>
                    <div @class(['ml-12 w-full lg:ml-0 lg:w-5/12', 'lg:pl-12' => $loop->iteration % 2 === 0, 'lg:pr-12 lg:text-right' => $loop->iteration % 2 !== 0])>
                        <span class="font-heading text-2xl font-bold text-primary">{{ $event['year'] }}</span>
                        <h3 class="mt-1 font-heading text-lg font-semibold text-dark">{{ $event['title'] }}</h3>
                        <p class="mt-2 text-sm text-muted">{{ $event['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Mission, Vision, Philosophy --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="glass-card hover-lift rounded-2xl p-8" data-aos="fade-up">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary">
                    <i class="fas fa-bullseye text-xl"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-dark">Our Mission</h3>
                <p class="mt-4 leading-relaxed text-muted">
                    Serve Global Healthcare needs through Empathy, Innovation and Technology. We believe that to ensure sustained growth, we need to clearly understand our customer's needs and use cutting edge technology to present innovative solutions.
                </p>
            </div>
            <div class="glass-card hover-lift rounded-2xl p-8" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-secondary/10 text-secondary">
                    <i class="fas fa-eye text-xl"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-dark">Our Vision</h3>
                <p class="mt-4 leading-relaxed text-muted">
                    Lead the way to bring Wellness and Healthcare to the world. Evolving into a vertically integrated, globally active business, leading and developing special and effective wellness and healthcare products with special emphasis on consumer safety.
                </p>
            </div>
            <div class="glass-card hover-lift rounded-2xl p-8" data-aos="fade-up" data-aos-delay="200">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-accent/10 text-accent-dark">
                    <i class="fas fa-lightbulb text-xl"></i>
                </div>
                <h3 class="font-heading text-xl font-bold text-dark">Our Philosophy</h3>
                <p class="mt-4 leading-relaxed text-muted">
                    At Elama Healthcare, we believe in the art of first creating opportunities and then optimizing them to the fullest. We identify unmet medical needs across therapies in different markets and capitalize on them ahead of competition.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Values" title="Core Values" subtitle="The principles that guide every decision we make." />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach([
                ['name' => 'Respect', 'icon' => 'fas fa-heart', 'desc' => 'Treating every stakeholder — patients, partners, and employees — with dignity and consideration.'],
                ['name' => 'Honesty', 'icon' => 'fas fa-handshake', 'desc' => 'Transparent dealings and ethical practices in all our business relationships worldwide.'],
                ['name' => 'Affordability', 'icon' => 'fas fa-hand-holding-usd', 'desc' => 'Making quality medicines accessible and affordable to patients across all geographies.'],
                ['name' => 'Partnership', 'icon' => 'fas fa-users', 'desc' => 'Building long-standing relationships through flexible, dynamic, and mutually beneficial partnerships.'],
                ['name' => 'Customer Emphasis', 'icon' => 'fas fa-user-md', 'desc' => 'Understanding customer needs and delivering innovative solutions that exceed expectations.'],
                ['name' => 'Passion', 'icon' => 'fas fa-fire', 'desc' => 'Deep commitment to healthcare excellence that drives our team every single day.'],
            ] as $value)
                <div class="glass-card hover-lift rounded-2xl p-6 text-center lg:p-8" data-aos="fade-up">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-secondary text-white">
                        <i class="{{ $value['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-dark">{{ $value['name'] }}</h3>
                    <p class="mt-3 text-sm text-muted">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Strengths --}}
<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Strengths" title="Our Competitive Strengths" />
        <div class="grid gap-8 lg:grid-cols-2">
            <div class="glass-card rounded-2xl p-8" data-aos="fade-right">
                <h3 class="font-heading text-xl font-semibold text-dark">Making Medicine Obtainable & Affordable</h3>
                <p class="mt-4 text-muted leading-relaxed">
                    Elama Healthcare is aware of our obligation that patients across the globe are trusting our medicines and we take that responsibility with great care. The Elama team is dedicated to ensuring our medicines are readily available for healthcare professionals and in turn the ultimate patients.
                </p>
            </div>
            <div class="glass-card rounded-2xl p-8" data-aos="fade-left">
                <h3 class="font-heading text-xl font-semibold text-dark">GMP-Compliant Manufacturing</h3>
                <p class="mt-4 text-muted leading-relaxed">
                    All of our associated sites follow Good Manufacturing Practice ensuring the highest quality and safety for the end user. We select the best suited manufacturing facility and take responsibility to supply products as well as documentation as required by various authorities.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Quality & Trust --}}
<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <span class="section-label mb-4 inline-block">Quality</span>
                <h2 class="font-heading text-3xl font-bold text-dark">Quality Excellence</h2>
                <p class="mt-6 text-muted leading-relaxed">
                    In our constant endeavour to deliver highest quality products, we have put in place strong and effective Quality Control and Quality Assurance Systems which consist of modern, sophisticated and advanced instrumentation and equipment, highly experienced personnel, and quality risk management systems.
                </p>
            </div>
            <div data-aos="fade-left">
                <span class="section-label mb-4 inline-block">Trust</span>
                <h2 class="font-heading text-3xl font-bold text-dark">Trust & Confidentiality</h2>
                <p class="mt-6 text-muted leading-relaxed">
                    We manage proprietary and sensitive customer specific information professionally to maintain mutual trust and confidence. We assure our customers of a totally trustworthy partner who can be relied upon to professionally manage and safeguard confidential matters like Product Development, Processes, R&D, and more.
                </p>
            </div>
        </div>
    </div>
</section>

<x-cta-section />
@endsection
