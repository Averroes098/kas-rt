@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#2F5D34] focus:ring-[#2F5D34] rounded-xl shadow-sm text-xs md:text-sm']) }}>

