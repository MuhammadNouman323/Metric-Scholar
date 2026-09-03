<div class="department-icon inline-flex items-center justify-center {{ $wrapperClass }} {{ $class ?? 'w-10 h-10' }} group/dept relative"
     data-department="{{ $department }}">
    <div class="absolute inset-0 bg-gradient-to-br from-[#0e48c1]/10 to-[#4f83f5]/10 rounded-xl opacity-0 group-hover/dept:opacity-100 transition-opacity duration-300"></div>
    <div class="w-full h-full flex items-center justify-center text-[#0e48c1] relative transition-transform duration-300 group-hover/dept:scale-110 group-hover/dept:-rotate-3">
        {!! $svg !!}
    </div>
</div>
