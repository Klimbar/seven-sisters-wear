<template>
    <section class="products py-24 bg-cream-light">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Handpicked For You</span>
                <h2 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Featured Traditional Wear</h2>
                <p class="text-text-body max-w-xl mx-auto mb-4">Explore selected traditional dresses and handwoven pieces from communities across North East India.</p>
                <div class="w-[60px] h-1 bg-gradient-to-r from-primary to-accent mx-auto rounded"></div>
            </div>

            <div v-if="products && products.length > 0" class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div v-for="product in products" :key="product.id" class="product-card bg-white rounded-lg overflow-hidden transition-all duration-400 hover:-translate-y-2 hover:shadow-xl reveal" @click="visitProduct(product)">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img v-if="getProductImage(product)" :src="getProductImage(product)" :alt="product.name" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                        <div v-else class="flex h-full w-full items-center justify-center bg-gray-100 text-sm text-gray-500">No image</div>
                        <div class="product-actions absolute inset-0 bg-text-dark/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <button class="add-to-cart-btn bg-white text-text-dark px-7 py-3 rounded font-semibold flex items-center gap-2 hover:bg-primary hover:text-white transition-colors" @click.stop="quickAddToCart(product)">
                                <i class="pi pi-shopping-cart"></i>
                                Add to Cart
                            </button>
                        </div>
                        <button class="product-wishlist absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 hover:bg-primary hover:text-white transition-all shadow-lg" :class="{ 'opacity-100': product.wishlists_count > 0 }" @click.stop="toggleWishlist(product)">
                            <i :class="product.wishlists_count > 0 ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'"></i>
                        </button>
                    </div>
                    <div class="p-5">
                        <h3 class="font-serif text-lg text-text-dark mb-1">{{ product.name }}</h3>
                        <p class="text-sm text-text-body opacity-70 mb-3">{{ product.category?.name }} • {{ product.fabric }}</p>
                        <div class="flex items-center gap-3">
                            <span class="font-semibold text-xl text-primary">₹{{ (product.discount_price || product.price).toLocaleString() }}</span>
                            <span v-if="product.discount_price" class="text-sm text-text-body opacity-50 line-through">₹{{ product.price.toLocaleString() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12">
                <p class="text-text-body">No products available yet.</p>
            </div>

            <div class="text-center mt-12">
                <a href="/shop" class="inline-block border border-red-500 text-red-500 px-8 py-3 rounded font-semibold hover:bg-red-500 hover:text-white transition-colors">
                    View All Products
                </a>
            </div>
        </div>
    </section>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    products: {
        type: Array,
        default: () => []
    }
});

const page = usePage();
const getProductImage = (product) => {
    return product.images?.[0]?.url || null;
};

const visitProduct = (product) => {
    router.visit(`/products/${product.id}`);
};

const toggleWishlist = (product) => {
    router.post(`/wishlist/toggle/${product.id}`, {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Full reload to update wishlist state
        }
    });
};

const quickAddToCart = (product) => {
    router.post(`/cart/add/${product.id}`, { quantity: 1 }, {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Added to Cart', detail: `${product.name} has been added to your cart.`, life: 3000 });
        }
    });
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

.product-card {
    cursor: pointer;
}

</style>
