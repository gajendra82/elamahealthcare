@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Leadership']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Our Team</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Leadership</h1>
            <p class="mt-4 text-lg text-white/80">Experienced medical professionals guiding Elama Healthcare's global vision.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Directors" title="Executive Leadership" subtitle="Our directors bring decades of medical expertise and industry leadership." />
        <div class="grid gap-8 lg:grid-cols-2">
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
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Our People" title="Our Team" subtitle="We have an excellent team of senior and experienced professionals to manage our business professionally." />
        <div class="glass-card rounded-2xl p-8 lg:p-12" data-aos="fade-up">
            <p class="text-lg leading-relaxed text-muted text-center max-w-3xl mx-auto">
                We firmly believe that our team will be a key differentiator in this competitive business environment. From R&D scientists and quality assurance specialists to regulatory affairs experts and logistics professionals — every member of the Elama family contributes to our mission of serving global healthcare needs.
            </p>
            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                @foreach([
                    ['icon' => 'fas fa-flask', 'title' => 'R&D Team', 'desc' => '15% dedicated scientific workforce'],
                    ['icon' => 'fas fa-shield-alt', 'title' => 'Quality Team', 'desc' => 'QC/QA with advanced instrumentation'],
                    ['icon' => 'fas fa-globe', 'title' => 'Sales & Marketing', 'desc' => 'Professional global sales force'],
                ] as $team)
                    <div class="text-center">
                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary">
                            <i class="{{ $team['icon'] }} text-xl"></i>
                        </div>
                        <h4 class="font-heading font-semibold text-dark">{{ $team['title'] }}</h4>
                        <p class="mt-1 text-sm text-muted">{{ $team['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<x-cta-section />
@endsection
