@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-[#1F6F78] focus:ring-2 focus:ring-[#1F6F78]/20 focus:outline-none disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500',
    ]) }}
>
