<template>
    <div class="states-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="text-center mb-16">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">North-East India</span>
                <h1 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">States of North-East</h1>
                <p class="text-text-body max-w-xl mx-auto">Explore the rich cultural heritage of North-East India through its states.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="state in states" :key="state.id" 
                     class="state-card bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all cursor-pointer"
                     @click="$inertia.visit(`/states/${state.slug}`)">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img :src="state.image || 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=600&q=80'" 
                             :alt="state.name" class="w-full h-full object-cover hover:scale-105 transition-transform">
                    </div>
                    <div class="p-6">
                        <h3 class="font-serif text-xl mb-2">{{ state.name }}</h3>
                        <p class="text-sm text-text-body mb-4">{{ state.description || 'Explore the rich culture and traditions.' }}</p>
                        <div class="flex justify-between text-sm">
                            <span class="text-text-body">{{ state.tribes?.length || 0 }} Tribes</span>
                            <span class="text-primary">{{ state.products?.length || 0 }} Products</span>
                        </div>
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
    states: Array
});
</script>
