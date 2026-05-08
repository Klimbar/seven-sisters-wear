<template>
    <div class="product-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="product-images">
                    <div class="main-image aspect-[3/4] rounded-lg overflow-hidden mb-4">
                        <img :src="selectedImage || product.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&q=80'" 
                             :alt="product.name" class="w-full h-full object-cover">
                    </div>
                    <div class="thumbnail-grid grid grid-cols-4 gap-2">
                        <div v-for="(image, index) in product.images" :key="index" 
                             class="aspect-square rounded cursor-pointer overflow-hidden border-2"
                             :class="selectedImage === image.url ? 'border-primary' : 'border-transparent'"
                             @click="selectedImage = image.url">
                            <img :src="image.url" :alt="product.name" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <span class="text-sm text-accent uppercase tracking-wider">{{ product.fabric }} • {{ product.category?.name }}</span>
                    <h1 class="font-serif text-4xl text-text-dark mt-2 mb-4">{{ product.name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <span class="font-bold text-3xl text-primary">₹{{ product.price.toLocaleString() }}</span>
                        <span v-if="product.discount_price" class="text-xl text-text-body line-through">₹{{ product.discount_price.toLocaleString() }}</span>
                    </div>

                    <p class="text-text-body mb-8 leading-relaxed">{{ product.description }}</p>

                    <div class="product-details mb-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm text-text-body">Fabric</span>
                                <p class="font-medium">{{ product.fabric }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-text-body">Tribe</span>
                                <p class="font-medium">{{ product.tribe?.name || 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-text-body">Stock</span>
                                <p class="font-medium" :class="product.stock > 0 ? 'text-green-600' : 'text-red-600'">
                                    {{ product.stock > 0 ? `${product.stock} in stock` : 'Out of stock' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-sm text-text-body">Status</span>
                                <p class="font-medium capitalize">{{ product.status }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="actions flex gap-4 mb-8">
                        <InputNumber v-model="quantity" :min="1" :max="Math.min(10, product.stock)" showButtons class="w-32" />
                        <Button label="Add to Cart" icon="pi pi-shopping-cart" class="flex-1" @click="addToCart" :disabled="product.stock === 0" />
                    </div>

                    <button class="wishlist-btn flex items-center gap-2 text-sm" @click="toggleWishlist">
                        <i :class="product.is_wishlisted ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'" class="text-lg"></i>
                        {{ product.is_wishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                    </button>

                    <!-- Reviews Summary -->
                    <div class="reviews-section mt-12 pt-8 border-t">
                        <h3 class="font-serif text-2xl mb-6">Customer Reviews</h3>
                        <div v-if="product.reviews && product.reviews.length > 0">
                            <div v-for="review in product.reviews" :key="review.id" class="review-item mb-6 pb-6 border-b">
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="font-medium">{{ review.user?.name || 'Anonymous' }}</span>
                                    <Rating :modelValue="review.rating" :cancel="false" readonly class="text-sm" />
                                </div>
                                <p class="text-text-body">{{ review.comment }}</p>
                            </div>
                        </div>
                        <p v-else class="text-text-body">No reviews yet. Be the first to review!</p>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="related-products mt-16 pt-12 border-t">
                <h2 class="font-serif text-3xl text-center mb-10">Related Products</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    <div v-for="related in relatedProducts" :key="related.id" 
                         class="product-card bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all cursor-pointer"
                         @click="$inertia.visit(`/products/${related.id}`)">
                        <div class="aspect-[3/4] overflow-hidden">
                            <img :src="related.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80'" 
                                 :alt="related.name" class="w-full h-full object-cover hover:scale-105 transition-transform">
                        </div>
                        <div class="p-4">
                            <h4 class="font-serif text-lg mb-1">{{ related.name }}</h4>
                            <span class="font-semibold text-primary">₹{{ related.price.toLocaleString() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';
import Rating from 'primevue/rating';

const props = defineProps({
    product: Object,
    relatedProducts: Array
});

const selectedImage = ref(null);
const quantity = ref(1);

const addToCart = () => {
    router.post(`/cart/add/${props.product.id}`, { quantity: quantity.value }, {
        preserveState: true,
        onSuccess: () => {
            quantity.value = 1;
        }
    });
};

const toggleWishlist = () => {
    router.post(`/wishlist/toggle/${props.product.id}`, {}, {
        preserveState: true,
        onSuccess: () => {
            props.product.is_wishlisted = !props.product.is_wishlisted;
        }
    });
};
</script>
