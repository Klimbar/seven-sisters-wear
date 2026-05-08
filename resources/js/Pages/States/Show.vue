<template>
    <div class="state-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <button class="flex items-center gap-2 text-text-body hover:text-primary mb-8" @click="$inertia.visit('/states')">
                <i class="pi pi-arrow-left"></i>
                Back to States
            </button>

            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div class="aspect-[4/3] rounded-lg overflow-hidden">
                    <img :src="state.image || 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=600&q=80'" 
                         :alt="state.name" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="font-serif text-4xl mb-4">{{ state.name }}</h1>
                    <p class="text-text-body leading-relaxed mb-8">{{ state.description || 'Explore the rich cultural heritage of this state.' }}</p>
                    
                    <div class="bg-cream p-6 rounded-lg">
                        <h3 class="font-serif text-xl mb-4">Quick Facts</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-text-body">Tribes</span>
                                <span class="font-medium">{{ state.tribes?.length || 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-text-body">Products</span>
                                <span class="font-medium">{{ state.products?.length || 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tribes in this state -->
            <div class="mb-12">
                <h2 class="font-serif text-3xl mb-8">Tribes of {{ state.name }}</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <div v-for="tribe in state.tribes" :key="tribe.id" 
                         class="tribe-card bg-white p-6 rounded-lg hover:shadow-lg transition-all cursor-pointer"
                         @click="$inertia.visit(`/tribes/${tribe.slug}`)">
                        <h3 class="font-serif text-lg mb-2">{{ tribe.name }}</h3>
                        <p class="text-sm text-text-body">{{ tribe.products?.length || 0 }} Products</p>
                    </div>
                </div>
            </div>

            <!-- Products from this state -->
            <div>
                <h2 class="font-serif text-3xl mb-8">Products from {{ state.name }}</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <div v-for="product in state.products" :key="product.id" 
                         class="product-card bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all cursor-pointer"
                         @click="$inertia.visit(`/products/${product.id}`)">
                        <div class="aspect-[3/4] overflow-hidden">
                            <img :src="product.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80'" 
                                 :alt="product.name" class="w-full h-full object-cover hover:scale-105 transition-transform">
                        </div>
                        <div class="p-4">
                            <h4 class="font-serif text-lg mb-1">{{ product.name }}</h4>
                            <span class="font-semibold text-primary">₹{{ product.price.toLocaleString() }}</span>
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
    state: Object
});
</script>
