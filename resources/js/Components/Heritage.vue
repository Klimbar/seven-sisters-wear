<template>
    <section class="heritage bg-cream-light relative overflow-hidden py-24">
        <div class="absolute top-0 left-0 right-0 h-[200px] bg-gradient-to-b from-cream to-cream-light"></div>
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <div class="relative reveal">
                    <img :src="heritageImage" alt="Traditional North East Indian textiles" class="w-full aspect-[4/5] object-cover rounded-lg shadow-xl">
                    <img :src="artisanImage" alt="Artisan handloom work" class="absolute w-1/2 aspect-square object-cover -bottom-10 -right-10 rounded-lg shadow-lg border-4 border-cream">
                </div>
                <div class="reveal">
                    <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Seven Sister States</span>
                    <h3 class="font-serif text-4xl text-text-dark mb-5">Where Regional Traditions Meet Timeless Artistry</h3>
                    <p class="text-text-body mb-5">From Assam and Nagaland to Manipur, Mizoram, Tripura, Meghalaya, and Arunachal Pradesh, every community carries its own textile language, ceremonial dress, and handloom identity.</p>
                    <p class="text-text-body mb-10">Each piece reflects more than fabric and pattern. It carries local heritage, careful craftsmanship, and the cultural pride of North East India's diverse traditional wear.</p>
                    
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const heritageImage = '/images/placeholders/heritage-main.webp';
const artisanImage = '/images/placeholders/heritage-artisan.webp';
</script>
