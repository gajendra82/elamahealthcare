@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Contact Us']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Get In Touch</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Contact Us</h1>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                @if(!empty($contact['address']))
                    <p class="mb-4 text-muted"><strong>Address:</strong> {{ $contact['address'] }}</p>
                @endif
                @if(!empty($contact['phone']))
                    <p class="mb-4 text-muted"><strong>Phone:</strong> {{ $contact['phone'] }}</p>
                @endif
                @if(!empty($contact['email']))
                    <p class="mb-4 text-muted"><strong>Email:</strong> {{ $contact['email'] }}</p>
                @endif
            </div>
            <div class="glass-card rounded-2xl p-8">
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
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
