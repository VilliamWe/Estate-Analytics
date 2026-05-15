<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl bg-[#0F3D3E] px-5 py-2.5 text-sm font-semibold uppercase tracking-widest text-white shadow-sm transition duration-150 hover:bg-[#14585A] hover:shadow-md focus:bg-[#14585A] focus:outline-none active:bg-[#0B2F30] active:shadow-sm']) }}>
    {{ $slot }}
</button>
