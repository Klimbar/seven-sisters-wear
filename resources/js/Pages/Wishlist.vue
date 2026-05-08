<template>
    <div class="wishlist-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">Your Wishlist</h1>
            
            <div v-if="wishlistItems.length === 0" class="text-center py-16">
                <i class="pi pi-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-text-body text-lg mb-6">Your wishlist is empty</p>
                <Button label="Discover Products" icon="pi pi-arrow-left" @click="$inertia.visit('/shop')" />
            </div>

            <div v-else class="grid md:grid-cols-4 gap-6">
                <div v-for="item in wishlistItems" :key="item.id" class="product-card bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img :src="item.product.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80'" 
                             :alt="item.product.name" class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer"
                             @click="$inertia.visit(`/products/${item.product.id}`)">
                        <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 transition-all shadow-lg" @click="toggleWishlist(item.product)">
                            <i class="pi pi-heart-fill"></i>
                        </button>
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif text-lg text-text-dark mb-1">{{ item.product.name }}</h3>
                        <p class="text-sm text-text-body opacity-70 mb-3">{{ item.product.fabric }}</p>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-xl text-primary">₹{{ item.product.price.toLocaleString() }}</span>
                            <Button label="Add to Cart" size="small" @click="addToCart(item.product)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';

const props = defineProps({
    wishlistItems: Array
});

const toggleWishlist = (product) => {
    router.post(`/wishlist/toggle/${product.id}`, {}, {
        preserveState: true
    });
};

const addToCart = (product) => {
    router.post(`/cart/add/${product.id}`, { quantity: 1 }, {
        preserveState: true
    });
};
</script>
