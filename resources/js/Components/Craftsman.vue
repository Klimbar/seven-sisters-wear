<template>
    <section class="craftsman">
        <div class="pattern-overlay"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <div class="craftsman-images grid grid-cols-2 gap-5">
                    <div class="rounded-lg overflow-hidden">
                        <img :src="artisanImages[0]" alt="Artisan at work" class="w-full h-full min-h-48 object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden row-span-2">
                        <img :src="artisanImages[1]" alt="Traditional weaving workshop" class="w-full h-full min-h-96 object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden">
                        <img :src="artisanImages[2]" alt="Handwoven textile detail" class="w-full h-full min-h-48 object-cover">
                    </div>
                </div>

                <div class="text-cream">
                    <span class="text-xs tracking-widest uppercase text-accent mb-3 block">The Artisans</span>
                    <h3 class="font-serif text-4xl text-cream mb-6">Craftspeople Across North East India</h3>
                    <p class="opacity-85 mb-5">Our artisan network represents the textile traditions of the seven sister states, from ceremonial garments and shawls to everyday handwoven wear.</p>
                    <p class="opacity-85 mb-8">Every thread tells a story of place, community, and regional identity.</p>
                    
                    <ul class="space-y-4">
                        <li v-for="item in features" :key="item" class="flex items-center gap-4">
                            <i class="pi pi-check-circle text-2xl text-accent"></i>
                            <span>{{ item }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const artisanImages = [
    '/images/placeholders/artisan-1.webp',
    '/images/placeholders/artisan-2.webp',
    '/images/placeholders/artisan-3.webp'
];

const features = [
    '100% Handwoven Using Traditional Looms',
    'Regional Motifs and Community Textile Traditions',
    'Traditional Dresses from Across the Seven Sister States'
];
</script>

<style scoped>
.craftsman {
    background-color: var(--color-text-dark);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.pattern-overlay {
    position: absolute;
    inset: 0;
    opacity: 0.5;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a227' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

</style>
