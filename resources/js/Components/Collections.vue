<template>
    <section class="collections py-24 bg-cream">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Our Collections</span>
                <h2 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Three Silk Traditions</h2>
                <p class="text-text-body max-w-xl mx-auto mb-4">Each silk type carries its own heritage, texture, and story unique to the lush valleys of Assam.</p>
                <div class="w-[60px] h-1 bg-gradient-to-r from-primary to-accent mx-auto rounded"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="collection-card relative aspect-[3/4] rounded-lg overflow-hidden cursor-pointer group reveal">
                    <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&q=80" alt="Muga Silk" class="w-full h-full object-cover transition-transform duration-600 group-hover:scale-108">
                    <div class="absolute inset-0 bg-gradient-to-t from-text-dark/85 to-transparent flex flex-col justify-end p-8">
                        <h3 class="font-serif text-2xl text-white mb-2">Muga Silk</h3>
                        <p class="text-white/80 text-sm mb-4">The golden silk of Assam, known for its natural luster and durability.</p>
                        <span class="text-accent text-sm font-semibold tracking-wider uppercase flex items-center gap-2 group-hover:gap-4 transition-all">
                            Explore <i class="ph ph-arrow-right"></i>
                        </span>
                    </div>
                </div>

                <div class="collection-card relative aspect-[3/4] rounded-lg overflow-hidden cursor-pointer group reveal">
                    <img src="https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=600&q=80" alt="Pat Silk" class="w-full h-full object-cover transition-transform duration-600 group-hover:scale-108">
                    <div class="absolute inset-0 bg-gradient-to-t from-text-dark/85 to-transparent flex flex-col justify-end p-8">
                        <h3 class="font-serif text-2xl text-white mb-2">Pat Silk</h3>
                        <p class="text-white/80 text-sm mb-4">White silk prized for its delicate texture and elegant drape.</p>
                        <span class="text-accent text-sm font-semibold tracking-wider uppercase flex items-center gap-2 group-hover:gap-4 transition-all">
                            Explore <i class="ph ph-arrow-right"></i>
                        </span>
                    </div>
                </div>

                <div class="collection-card relative aspect-[3/4] rounded-lg overflow-hidden cursor-pointer group reveal">
                    <img src="https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600&q=80" alt="Eri Silk" class="w-full h-full object-cover transition-transform duration-600 group-hover:scale-108">
                    <div class="absolute inset-0 bg-gradient-to-t from-text-dark/85 to-transparent flex flex-col justify-end p-8">
                        <h3 class="font-serif text-2xl text-white mb-2">Eri Silk</h3>
                        <p class="text-white/80 text-sm mb-4">The peace silk, soft and warm, perfect for everyday elegance.</p>
                        <span class="text-accent text-sm font-semibold tracking-wider uppercase flex items-center gap-2 group-hover:gap-4 transition-all">
                            Explore <i class="ph ph-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
</script>
