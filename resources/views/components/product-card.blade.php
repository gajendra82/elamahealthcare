@props(['product'])

<a href="{{ $product['url'] }}" class="group glass-card hover-lift block overflow-hidden rounded-2xl">
    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-primary/5 to-accent/10">
        <x-image
            :src="$product['image_path'] ?? null"
            placeholder="product"
            :alt="$product['name']"
            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
        />
        @if(!empty($product['category']))
            <span class="absolute left-4 top-4 rounded-full bg-secondary px-3 py-1 text-xs font-semibold text-white">{{ $product['category'] }}</span>
        @endif
    </div>
    <div class="p-5">
        <h3 class="font-heading text-lg font-semibold text-dark group-hover:text-primary">{{ $product['name'] }}</h3>
        @if(!empty($product['description']))
            <p class="mt-2 line-clamp-2 text-sm text-muted">{{ $product['description'] }}</p>
        @endif
        @if(!empty($product['strength']))
            <p class="mt-3 text-sm font-medium text-primary">{{ $product['strength'] }}</p>
        @endif
    </div>
</a>
