<template>
    <section class="products py-24 bg-cream-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Handpicked For You</span>
                <h2 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Featured Mekhela Chadors</h2>
                <p class="text-text-body max-w-xl mx-auto mb-4">Each piece is a labor of love, taking weeks to craft using traditional handloom techniques.</p>
                <div class="w-[60px] h-1 bg-gradient-to-r from-primary to-accent mx-auto rounded"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="product in products" :key="product.id" class="product-card bg-white rounded-lg overflow-hidden transition-all duration-400 hover:-translate-y-2 hover:shadow-xl reveal">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        <div class="product-actions absolute inset-0 bg-text-dark/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <button class="add-to-cart-btn bg-white text-text-dark px-7 py-3 rounded font-semibold flex items-center gap-2 hover:bg-primary hover:text-white transition-colors">
                                <i class="pi pi-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                        <button class="product-wishlist absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 hover:bg-primary hover:text-white transition-all shadow-lg" :class="{ 'opacity-100': product.wishlisted }" @click="toggleWishlist(product)">
                            <i :class="product.wishlisted ? 'pi-heart-fill' : 'pi-heart'"></i>
                        </button>
                        <span v-if="product.badge" class="product-badge absolute top-3 left-3 bg-accent-coral text-white text-xs font-semibold px-3 py-1 rounded uppercase tracking-wider">{{ product.badge }}</span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif text-lg text-text-dark mb-1">{{ product.name }}</h3>
                        <p class="text-sm text-text-body opacity-70 mb-3">{{ product.category }}</p>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-xl text-primary">₹{{ product.price.toLocaleString() }}</span>
                            <span v-if="product.originalPrice" class="text-sm text-text-body opacity-50 line-through">₹{{ product.originalPrice.toLocaleString() }}</span>
                        </div>
                        <div class="flex items-center gap-2 mt-3">
                            <Rating :modelValue="product.rating" :cancel="false" class="text-accent" />
                            <span class="text-xs text-text-body opacity-70">({{ product.reviews }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <Button label="View All Products" severity="danger" outlined class="font-semibold" />
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import Rating from 'primevue/rating';
import Button from 'primevue/button';

const products = ref([
    {
        id: 1,
        name: 'Golden Harvest Mekhela Chador',
        category: 'Muga Silk • Traditional',
        price: 18500,
        originalPrice: null,
        badge: 'Bestseller',
        rating: 5,
        reviews: 48,
        wishlisted: false,
        image: 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80'
    },
    {
        id: 2,
        name: 'Bihu Dance Mekhela Chador',
        category: 'Pat Silk • Contemporary',
        price: 22000,
        originalPrice: null,
        badge: null,
        rating: 5,
        reviews: 32,
        wishlisted: false,
        image: 'https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?w=500&q=80'
    },
    {
        id: 3,
        name: 'Peacock Bloom Eri Dress',
        category: 'Eri Silk • Handwoven',
        price: 14200,
        originalPrice: null,
        badge: 'New',
        rating: 4,
        reviews: 15,
        wishlisted: false,
        image: 'https://images.unsplash.com/photo-1558171813-4c088753af8f?w=500&q=80'
    },
    {
        id: 4,
        name: 'Jonbiri Pattern Chador',
        category: 'Muga Silk • Premium',
        price: 28500,
        originalPrice: 32000,
        badge: null,
        rating: 5,
        reviews: 28,
        wishlisted: false,
        image: 'https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=500&q=80'
    }
]);

const toggleWishlist = (product) => {
    product.wishlisted = !product.wishlisted;
};
</script>

<style scoped>
.product-wishlist {
    opacity: 0;
    transform: translateY(-10px);
}

.product-card:hover .product-wishlist {
    opacity: 1;
    transform: translateY(0);
}
</style>
