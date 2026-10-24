@props([
    'category' => null,
    'height'   => '176px',
    'showLabel' => false,
])

@php
    $catSlug = $category?->slug ?? '';

    $gradients = [
        'national'      => 'linear-gradient(135deg, #2563eb, #1d4ed8)',
        'international' => 'linear-gradient(135deg, #7c3aed, #5b21b6)',
        'technology'    => 'linear-gradient(135deg, #0284c7, #2563eb)',
        'education'     => 'linear-gradient(135deg, #059669, #0f766e)',
        'economy'       => 'linear-gradient(135deg, #d97706, #b45309)',
        'sports'        => 'linear-gradient(135deg, #16a34a, #15803d)',
        'entertainment' => 'linear-gradient(135deg, #db2777, #be185d)',
        'health'        => 'linear-gradient(135deg, #e11d48, #be123c)',
    ];
    $faIcons = [
        'national'      => 'fa-solid fa-landmark',
        'international' => 'fa-solid fa-globe',
        'technology'    => 'fa-solid fa-laptop-code',
        'education'     => 'fa-solid fa-graduation-cap',
        'economy'       => 'fa-solid fa-chart-line',
        'sports'        => 'fa-solid fa-trophy',
        'entertainment' => 'fa-solid fa-film',
        'health'        => 'fa-solid fa-heart-pulse',
    ];
    $grad   = $gradients[$catSlug] ?? 'linear-gradient(135deg, #2563eb, #7c3aed)';
    $faIcon = $faIcons[$catSlug]   ?? 'fa-solid fa-newspaper';
@endphp

<div style="background: {{ $grad }}; height: {{ $height }}; width: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 10px;" class="text-white">
    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-xs flex items-center justify-center shadow-inner">
        <i class="{{ $faIcon }} text-2xl text-white"></i>
    </div>
    @if($showLabel && $category)
        <span style="color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase;">
            {{ $category->getName() }}
        </span>
    @endif
</div>
