@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'block w-full rounded-xl border border-[#D8EAEA] bg-[#E8F3F3] px-4 py-3 text-start text-sm font-semibold text-[#0F3D3E] transition'
        : 'block w-full rounded-xl px-4 py-3 text-start text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-800 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
