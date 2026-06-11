<template>
    <section class="hero min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="hero-bg absolute inset-0 bg-cover bg-center" :style="{ backgroundImage: `url('${heroImage}')` }"></div>
        <div class="hero-overlay absolute inset-0 bg-gradient-to-br from-text-dark/75 via-primary/60 to-secondary/50"></div>
        
        <div class="hero-content relative z-10 text-center text-white max-w-4xl px-6">
            <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl font-bold leading-tight mb-5">
                Traditional <span class="text-accent">North East</span> Wear
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl opacity-90 mb-10 max-w-2xl mx-auto">
                Discover authentic traditional dresses from the seven sister states, crafted with regional textiles, indigenous patterns, and generations of handloom heritage.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="/shop" class="btn btn-primary inline-flex items-center gap-3 text-lg px-10 py-4 leading-none">
                    <i class="ph ph-shopping-bag text-xl leading-none"></i>
                    Shop Products
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
const heroImage = '/images/placeholders/home-hero.webp';
</script>
