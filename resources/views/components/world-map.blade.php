@props(['compact' => false, 'showList' => true])

<div x-data="worldMap" {{ $attributes->merge(['class' => 'relative']) }}>
    <div @class([
        'grid gap-8',
        'lg:grid-cols-3' => $showList && !$compact,
        'grid-cols-1' => $compact || !$showList,
    ])>
        <div @class(['relative', 'lg:col-span-2' => $showList && !$compact])>
            <div class="glass-card overflow-hidden rounded-2xl p-4 lg:p-6">
                <svg viewBox="0 0 1000 500" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                    {{-- Simplified world map background --}}
                    <rect width="1000" height="500" fill="#E2E8F0" rx="8"/>

                    {{-- Africa --}}
                    <path class="map-country" :class="{ 'active': activeCountry === 'AO' }" @click="select('AO')" @mouseenter="activeCountry = 'AO'" @mouseleave="activeCountry = null" data-country="AO" d="M480,280 L500,260 L520,270 L530,300 L510,330 L490,320 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'MZ' }" @click="select('MZ')" @mouseenter="activeCountry = 'MZ'" @mouseleave="activeCountry = null" d="M510,340 L540,330 L550,360 L530,380 L510,370 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'KE' }" @click="select('KE')" @mouseenter="activeCountry = 'KE'" @mouseleave="activeCountry = null" d="M530,290 L550,280 L560,300 L545,315 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'SD' }" @click="select('SD')" @mouseenter="activeCountry = 'SD'" @mouseleave="activeCountry = null" d="M490,240 L520,230 L530,260 L500,270 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'CM' }" @click="select('CM')" @mouseenter="activeCountry = 'CM'" @mouseleave="activeCountry = null" d="M460,280 L480,270 L490,295 L470,305 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'CI' }" @click="select('CI')" @mouseenter="activeCountry = 'CI'" @mouseleave="activeCountry = null" d="M420,280 L440,270 L450,295 L430,305 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'GN' }" @click="select('GN')" @mouseenter="activeCountry = 'GN'" @mouseleave="activeCountry = null" d="M400,265 L420,255 L430,280 L410,290 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'CG' }" @click="select('CG')" @mouseenter="activeCountry = 'CG'" @mouseleave="activeCountry = null" d="M470,300 L500,290 L510,320 L480,330 Z" fill="#94a3b8"/>

                    {{-- Asia --}}
                    <path class="map-country" :class="{ 'active': activeCountry === 'IN' }" @click="select('IN')" @mouseenter="activeCountry = 'IN'" @mouseleave="activeCountry = null" d="M620,220 L660,200 L680,240 L650,280 L620,260 Z" fill="#0056A6" opacity="0.6"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'MM' }" @click="select('MM')" @mouseenter="activeCountry = 'MM'" @mouseleave="activeCountry = null" d="M700,230 L730,220 L740,250 L715,265 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'KH' }" @click="select('KH')" @mouseenter="activeCountry = 'KH'" @mouseleave="activeCountry = null" d="M730,260 L750,250 L760,275 L740,285 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'VN' }" @click="select('VN')" @mouseenter="activeCountry = 'VN'" @mouseleave="activeCountry = null" d="M750,240 L770,220 L780,270 L760,290 L750,260 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'PH' }" @click="select('PH')" @mouseenter="activeCountry = 'PH'" @mouseleave="activeCountry = null" d="M790,260 L810,240 L820,280 L800,300 L790,270 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'NP' }" @click="select('NP')" @mouseenter="activeCountry = 'NP'" @mouseleave="activeCountry = null" d="M660,210 L675,200 L685,225 L670,235 Z" fill="#94a3b8"/>
                    <path class="map-country" :class="{ 'active': activeCountry === 'AF' }" @click="select('AF')" @mouseenter="activeCountry = 'AF'" @mouseleave="activeCountry = null" d="M620,180 L660,170 L670,200 L630,210 Z" fill="#94a3b8"/>

                    {{-- Decorative dots for presence --}}
                    <circle cx="715" cy="245" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="755" cy="265" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="770" cy="255" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="800" cy="270" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="670" cy="218" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="545" cy="300" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="510" cy="310" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="505" cy="255" r="4" fill="#00A884" class="animate-pulse-soft"/>
                    <circle cx="645" cy="190" r="4" fill="#00A884" class="animate-pulse-soft"/>
                </svg>

                <div x-show="activeCountry" x-transition class="absolute bottom-6 left-6 glass-card rounded-xl px-4 py-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-secondary">Active Market</p>
                    <p class="font-heading text-lg font-bold text-dark" x-text="getCountryName(activeCountry)"></p>
                </div>
            </div>
        </div>

        @if($showList)
            <div @class(['space-y-3', 'max-h-80 overflow-y-auto lg:max-h-none' => $compact])>
                <h3 class="font-heading text-lg font-semibold text-dark mb-4">Our Global Footprint</h3>
                @foreach(['Myanmar', 'Cambodia', 'Vietnam', 'Philippines', 'Nepal', 'Kenya', 'Afghanistan', 'Sudan', 'Angola', 'Mozambique', 'Cameroon', 'Ivory Coast', 'Guinea', 'Congo'] as $country)
                    <div class="flex items-center gap-3 rounded-xl border border-border bg-white px-4 py-3 transition-colors hover:border-secondary hover:bg-secondary/5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                            <i data-lucide="map-pin" class="h-4 w-4"></i>
                        </span>
                        <span class="font-medium text-dark">{{ $country }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
