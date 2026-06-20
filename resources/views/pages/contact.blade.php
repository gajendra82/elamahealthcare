@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Contact Us']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Get In Touch</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Contact Us</h1>
            <p class="mt-4 text-lg text-white/80">Reach our corporate office for product enquiries, partnerships, and general support.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div class="space-y-6" data-aos="fade-right">
                <x-section-heading label="Contact Details" title="Corporate Office" />

                @if(!empty($contact['address']))
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <i data-lucide="map-pin" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-semibold text-dark">Address</h3>
                                <p class="mt-2 leading-relaxed text-muted">{!! nl2br(e($contact['address'])) !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($contact['phone']))
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <i data-lucide="phone" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-semibold text-dark">Phone</h3>
                                <p class="mt-2 text-muted">
                                    <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="transition-colors hover:text-primary">{{ $contact['phone'] }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!empty($contact['email']))
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                <i data-lucide="mail" class="h-5 w-5"></i>
                            </div>
                            <div>
                                <h3 class="font-heading text-lg font-semibold text-dark">Email</h3>
                                <p class="mt-2 text-muted">
                                    <a href="mailto:{{ $contact['email'] }}" class="transition-colors hover:text-primary">{{ $contact['email'] }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="glass-card rounded-2xl p-8" data-aos="fade-left">
                <h2 class="font-heading text-2xl font-bold text-dark">Send Us a Message</h2>
                <p class="mt-2 text-sm text-muted">Fill out the form and our team will respond shortly.</p>

                <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium">Name</label>
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
                        <label class="mb-2 block text-sm font-medium">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-input">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium">Message</label>
                        <textarea name="message" rows="5" required class="form-input">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
