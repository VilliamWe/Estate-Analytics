@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'inline-flex items-center rounded-xl bg-[#E8F3F3] px-3 py-2 text-sm font-semibold text-[#0F3D3E] shadow-sm transition'
        : 'inline-flex items-center rounded-xl px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-50 hover:text-slate-800 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
