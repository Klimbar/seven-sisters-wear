<template>
    <div class="tribes-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="text-center mb-16">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Cultural Heritage</span>
                <h1 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Tribes of North-East</h1>
                <p class="text-text-body max-w-xl mx-auto">Discover the diverse tribal communities and their unique craftsmanship.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="tribe in tribes" :key="tribe.id" 
                     class="tribe-card bg-white rounded-lg p-6 hover:shadow-xl transition-all cursor-pointer"
                     @click="$inertia.visit(`/tribes/${tribe.slug}`)">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                            <i class="pi pi-users text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-serif text-xl">{{ tribe.name }}</h3>
                            <p class="text-sm text-text-body">{{ tribe.state?.name || 'N/A' }}</p>
                        </div>
                    </div>
                    <p class="text-text-body text-sm mb-4">{{ tribe.description || 'Explore the rich cultural heritage.' }}</p>
                    <div class="flex justify-between text-sm">
                        <span class="text-text-body">{{ tribe.products?.length || 0 }} Products</span>
                        <span class="text-primary">Learn More →</span>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    tribes: Array
});
</script>
