@props(['compact' => false, 'showList' => true])

@php
    $countries = \App\Support\GlobalPresence::countriesByCode();
@endphp

<div
    x-data="worldMapPanel"
    data-world-map
    data-countries='@json($countries)'
    {{ $attributes->merge(['class' => 'relative']) }}
>
    <div @class([
        'grid gap-8',
        'lg:grid-cols-3' => $showList && !$compact,
        'grid-cols-1' => $compact || !$showList,
    ])>
        <div @class(['relative', 'lg:col-span-2' => $showList && !$compact])>
            <div class="glass-card world-map-shell overflow-hidden rounded-2xl p-3 lg:p-4">
                <div class="world-map-canvas w-full" style="min-height: {{ $compact ? '280px' : '420px' }};"></div>

                <div
                    x-show="activeCode"
                    x-transition
                    class="absolute bottom-5 left-5 glass-card rounded-xl px-4 py-3"
                >
                    <p class="text-xs font-semibold uppercase tracking-wider text-secondary">Selected Market</p>
                    <p class="font-heading text-lg font-bold text-dark" x-text="countryName(activeCode)"></p>
                    <p class="text-xs text-muted" x-text="countryRegion(activeCode)"></p>
                </div>

                <div class="mt-3 flex flex-wrap gap-4 px-1 text-xs text-muted">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-[#062F54]"></span> Headquarters
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full bg-[#0B4F8C]"></span> Active Markets
                    </span>
                </div>
            </div>
        </div>

        @if($showList)
            <div @class(['space-y-3', 'max-h-80 overflow-y-auto lg:max-h-[460px]' => $compact])>
                <h3 class="font-heading mb-4 text-lg font-semibold text-dark">Our Global Footprint</h3>
                @foreach($countries as $code => $country)
                    <button
                        type="button"
                        @click="selectCountry('{{ $code }}')"
                        :class="activeCode === '{{ $code }}' ? 'border-secondary bg-secondary/5 shadow-soft' : 'border-border bg-white hover:border-secondary hover:bg-secondary/5'"
                        class="flex w-full items-center gap-3 rounded-xl border px-4 py-3 text-left transition-all"
                    >
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                            <i data-lucide="map-pin" class="h-4 w-4"></i>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block font-medium text-dark">{{ $country['name'] }}</span>
                            <span class="block text-xs text-muted">{{ $country['region'] }}@if($country['type'] === 'hq') · HQ @endif</span>
                        </span>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</div>
