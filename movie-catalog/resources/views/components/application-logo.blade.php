<div class="flex items-center gap-2">
    <!-- Иконка кинохлопушки -->
    <span class="text-2xl">🎬</span> 
    
    <!-- Стилизованный текст логотипа с поддержкой внешних классов Tailwind -->
    <span {{ $attributes->merge(['class' => 'font-black text-xl tracking-wider bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent uppercase']) }}>
        Movie<span class="text-white">Catalog</span>
    </span>
</div>
