@props(['flip' => false, 'color' => '#F8FAFC'])

<div @class(['wave-divider', '-mt-px' => !$flip, '-mb-px' => $flip]) aria-hidden="true">
    <svg viewBox="0 0 1440 80" preserveAspectRatio="none" @if($flip) style="transform: rotate(180deg)" @endif>
        <path fill="{{ $color }}" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"></path>
    </svg>
</div>
