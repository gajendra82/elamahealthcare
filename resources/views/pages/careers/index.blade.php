@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Careers']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Join Us</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Careers at Elama</h1>
            <p class="mt-4 text-lg text-white/80">Build your career with a globally recognized pharmaceutical company committed to healthcare excellence.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center mb-12" data-aos="fade-up">
            <p class="text-lg text-muted leading-relaxed">
                We firmly believe that our team will be a key differentiator in this competitive business environment. Join our excellent team of senior and experienced professionals and contribute to serving global healthcare needs.
            </p>
        </div>

        @if($jobs->isNotEmpty())
            <div class="space-y-4">
                @foreach($jobs as $job)
                    <a href="{{ route('careers.show', $job->slug) }}" class="glass-card hover-lift group flex flex-col gap-4 rounded-2xl p-6 sm:flex-row sm:items-center sm:justify-between lg:p-8" data-aos="fade-up">
                        <div>
                            <h3 class="font-heading text-xl font-semibold text-dark transition-colors group-hover:text-primary">{{ $job->title }}</h3>
                            <div class="mt-2 flex flex-wrap gap-3 text-sm text-muted">
                                @if($job->department)
                                    <span class="flex items-center gap-1"><i data-lucide="building" class="h-4 w-4"></i>{{ $job->department }}</span>
                                @endif
                                @if($job->location)
                                    <span class="flex items-center gap-1"><i data-lucide="map-pin" class="h-4 w-4"></i>{{ $job->location }}</span>
                                @endif
                                @if($job->type)
                                    <span class="flex items-center gap-1"><i data-lucide="clock" class="h-4 w-4"></i>{{ ucfirst(str_replace('-', ' ', $job->type)) }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="btn-primary shrink-0 text-sm !py-2.5 !px-5">
                            View & Apply
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="glass-card mx-auto max-w-2xl rounded-2xl p-10 text-center" data-aos="fade-up">
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <i data-lucide="briefcase" class="h-8 w-8"></i>
                </div>
                <h2 class="font-heading text-2xl font-bold text-dark">No Current Openings</h2>
                <p class="mt-4 leading-relaxed text-muted">
                    We do not have any open positions at the moment. Please check back later, or share your resume with us and we will reach out when a suitable opportunity opens.
                </p>
                <a href="{{ url('/contact') }}" class="btn-primary mt-8 inline-flex">
                    Share Your Resume
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Benefits" title="Why Work With Us" />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['icon' => 'fas fa-chart-line', 'title' => 'Growth Opportunities', 'desc' => 'Career advancement in a fast-growing global pharma company'],
                ['icon' => 'fas fa-users', 'title' => 'Expert Team', 'desc' => 'Work alongside industry veterans and medical professionals'],
                ['icon' => 'fas fa-globe', 'title' => 'Global Exposure', 'desc' => 'International business experience across 14+ countries'],
                ['icon' => 'fas fa-heart', 'title' => 'Purpose-Driven', 'desc' => 'Make a real impact on global healthcare accessibility'],
            ] as $benefit)
                <div class="text-center" data-aos="fade-up">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="{{ $benefit['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-dark">{{ $benefit['title'] }}</h3>
                    <p class="mt-2 text-sm text-muted">{{ $benefit['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-section title="Interested in Joining Us?" subtitle="Send us your resume and we will reach out when a matching opportunity opens up." primaryLabel="Contact Us" primaryUrl="/contact" />
@endsection
