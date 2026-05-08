<template>
    <div class="tribe-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <button class="flex items-center gap-2 text-text-body hover:text-primary mb-8" @click="$inertia.visit('/tribes')">
                <i class="pi pi-arrow-left"></i>
                Back to Tribes
            </button>

            <div class="grid md:grid-cols-2 gap-12 mb-16">
                <div class="aspect-[4/3] rounded-lg overflow-hidden">
                    <img :src="tribe.image || 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=600&q=80'" 
                         :alt="tribe.name" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="text-sm text-accent uppercase tracking-wider">{{ tribe.state?.name || 'North-East India' }}</span>
                    <h1 class="font-serif text-4xl mb-4">{{ tribe.name }}</h1>
                    <p class="text-text-body leading-relaxed mb-8">{{ tribe.description || 'Explore the rich cultural heritage of this tribe.' }}</p>
                    
                    <div class="bg-cream p-6 rounded-lg">
                        <h3 class="font-serif text-xl mb-4">Quick Facts</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-text-body">State</span>
                                <span class="font-medium">{{ tribe.state?.name || 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-text-body">Products</span>
                                <span class="font-medium">{{ tribe.products?.length || 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products from this tribe -->
            <div>
                <h2 class="font-serif text-3xl mb-8">Products by {{ tribe.name }}</h2>
                <div v-if="tribe.products && tribe.products.length > 0" class="grid md:grid-cols-4 gap-6">
                    <div v-for="product in tribe.products" :key="product.id" 
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
                <p v-else class="text-text-body text-center py-8">No products available from this tribe yet.</p>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    tribe: Object
});
</script>
