<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#2F5D34] hover:bg-[#4F7A3F] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest active:bg-[#2F5D34] focus:outline-none focus:ring-2 focus:ring-[#2F5D34] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm cursor-pointer']) }}>
    {{ $slot }}
</button>

