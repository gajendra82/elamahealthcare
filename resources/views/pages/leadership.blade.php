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
            <x-leadership-card :leader="[
                'name' => 'Dr. Rahul Kulkarni',
                'title' => 'Director',
                'qualification' => 'MBBS, MS ENT – Mumbai',
                'photo' => asset('images/leadership/dr-rahul-kulkarni.jpg'),
                'bio' => 'Dr. Rahul Kulkarni brings more than 25 years of experience in the Medical Field. He serves as Hon. Consultant at Sir J J Group of Hospitals and is Head of the ENT department at St George Hospital.',
                'highlights' => [
                    'President, ENT Association of India, Mumbai Branch',
                    'Heading Kalwa ENT Centre, Kalwa, Thane, Mumbai',
                    'Chief ENT Consultant, Currae Hospital, Thane',
                    'Hon. Consultant, Sir J J Group of Hospitals',
                ],
            ]" />
            <x-leadership-card :leader="[
                'name' => 'Dr. Ashwini Kulkarni',
                'title' => 'Director',
                'qualification' => 'MBBS, DMRD',
                'photo' => asset('images/leadership/dr-ashwini-kulkarni.svg'),
                'bio' => 'Dr. Ashwini Kulkarni has 20 years of experience in medical practice. She serves as Director at Kalwa Diagnostic Centre, Thane and is Chief Sonologist at Currae Hospital and IVF Birthing Center, Thane.',
                'highlights' => [
                    'Director, Kalwa Diagnostic Centre, Thane',
                    'Chief Sonologist, Currae Hospital and IVF Birthing Center, Thane',
                    'Organizing member, Asia (AOCR) Radiology Conference',
                ],
            ]" />
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
