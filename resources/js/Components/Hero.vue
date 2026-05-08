<template>
    <section class="hero min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="hero-bg absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=1920&q=80')"></div>
        <div class="hero-overlay absolute inset-0 bg-gradient-to-br from-text-dark/75 via-primary/60 to-secondary/50"></div>
        
        <div class="hero-content relative z-10 text-center text-white max-w-4xl px-6">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-5 py-2 rounded-full text-sm tracking-widest uppercase mb-6 border border-white/20">
                <i class="ph ph-sparkle"></i>
                Handwoven Heritage
            </div>
            <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl font-bold leading-tight mb-5">
                Timeless <span class="text-accent">Muga</span> Elegance
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl opacity-90 mb-10 max-w-2xl mx-auto">
                Discover the artistry of traditional Assamese Mekhela Chadors, woven with centuries of heritage and passion by master craftspeople from the Brahmaputra valley.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="#shop" class="btn btn-primary">
                    <i class="ph ph-shopping-bag"></i>
                    Shop Collection
                </a>
                <a href="#story" class="btn btn-secondary">
                    <i class="ph ph-play"></i>
                    Our Story
                </a>
            </div>
        </div>

        <div class="hero-scroll absolute bottom-10 left-1/2 -translate-x-1/2 text-center animate-bounce">
            <i class="ph ph-caret-down text-3xl opacity-80"></i>
            <span class="block text-xs tracking-widest uppercase opacity-70 mt-2">Scroll</span>
        </div>
    </section>
</template>

<script setup>
</script>
