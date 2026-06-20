@props(['items' => []])

<nav aria-label="Breadcrumb" {{ $attributes->merge(['class' => 'mb-8']) }} data-aos="fade-down">
    <ol class="flex flex-wrap items-center gap-2 text-sm">
        <li>
            <a href="{{ url('/') }}" class="text-muted transition-colors hover:text-primary">
                <i class="fas fa-home mr-1"></i> Home
            </a>
        </li>
        @foreach($items as $item)
            <li class="flex items-center gap-2">
                <i data-lucide="chevron-right" class="h-4 w-4 text-border"></i>
                @if(!empty($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-muted transition-colors hover:text-primary">{{ $item['label'] }}</a>
                @else
                    <span class="font-medium text-primary">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
