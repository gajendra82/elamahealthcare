@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Careers', 'url' => route('careers.index')],
            ['label' => $job->title],
        ]" />
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <h1 class="font-heading text-3xl font-bold text-dark">{{ $job->title }}</h1>
        <p class="mt-2 text-muted">{{ $job->department }} · {{ $job->location }} · {{ ucfirst(str_replace('-', ' ', $job->type)) }}</p>

        @if($job->description)
            <div class="prose mt-8 max-w-none text-muted">{!! nl2br(e($job->description)) !!}</div>
        @endif

        @if($job->requirements)
            <h2 class="mt-8 font-heading text-xl font-semibold">Requirements</h2>
            <div class="prose mt-4 max-w-none text-muted">{!! nl2br(e($job->requirements)) !!}</div>
        @endif

        <div class="glass-card mt-12 rounded-2xl p-8">
            <h2 class="font-heading text-xl font-semibold">Apply for this position</h2>
            <form method="POST" action="{{ route('careers.apply', $job->slug) }}" enctype="multipart/form-data" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-medium">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
                    @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
                    @error('email')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Cover Letter</label>
                    <textarea name="cover_letter" rows="4" class="form-input">{{ old('cover_letter') }}</textarea>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium">Resume (PDF, max 5MB)</label>
                    <input type="file" name="resume" accept=".pdf" required class="form-input">
                    @error('resume')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary">Submit Application</button>
            </form>
        </div>
    </div>
</section>
@endsection
