@props([
    'type' => 'success',
    'message' => null,
])

@php
    $styles = [
        'success' => ['#ecfdf5', '#10b981', '#065f46', '✓'],
        'error'   => ['#fef2f2', '#ef4444', '#991b1b', '!'],
        'warning' => ['#fffbeb', '#f59e0b', '#92400e', '!'],
        'info'    => ['#eff6ff', '#3b82f6', '#1e40af', 'i'],
    ];
    [$bg, $border, $text, $icon] = $styles[$type] ?? $styles['info'];
@endphp

<div {{ $attributes->merge(['class' => 'alert-box']) }} style="background: {{ $bg }}; border: 1px solid {{ $border }}; color: {{ $text }};">
    <span class="alert-icon" style="border-color: {{ $border }};">{{ $icon }}</span>
    <div>
        <strong>{{ ucfirst($type) }}</strong>
        <div>{{ $message ?? $slot }}</div>
    </div>
</div>
