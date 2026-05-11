<template>
    <div class="product-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Product Images with Swiper -->
                <div class="product-images">
                    <!-- Main Swiper -->
                    <div class="main-swiper-container relative">
                        <Swiper
                            :modules="modules"
                            :thumbs="{ swiper: thumbsSwiper }"
                            :navigation="true"
                            :pagination="{ clickable: true }"
                            :loop="true"
                            class="main-swiper rounded-lg overflow-hidden"
                            @swiper="setMainSwiper"
                        >
                            <SwiperSlide v-for="(image, index) in productImages" :key="index">
                                <div class="aspect-[3/4] relative cursor-pointer" @click="openLightbox(index)">
                                    <img 
                                        :src="image" 
                                        :alt="product.name" 
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>

                    <!-- Thumbnail Swiper -->
                    <div class="thumbs-container mt-4" v-if="productImages.length > 1">
                        <Swiper
                            :modules="modules"
                            :spaceBetween="10"
                            :slidesPerView="4"
                            :loop="true"
                            :watchSlidesProgress="true"
                            class="thumbs-swiper"
                            @swiper="setThumbsSwiper"
                        >
                            <SwiperSlide v-for="(image, index) in productImages" :key="index">
                                <div 
                                    class="aspect-square rounded cursor-pointer overflow-hidden border-2 transition-all"
                                    :class="activeIndex === index ? 'border-primary' : 'border-transparent hover:border-gray-300'"
                                >
                                    <img :src="image" :alt="product.name" class="w-full h-full object-cover" />
                                </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info">
                    <span class="text-sm text-accent uppercase tracking-wider">{{ product.fabric }} • {{ product.category?.name }}</span>
                    <h1 class="font-serif text-4xl text-text-dark mt-2 mb-4">{{ product.name }}</h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        <span class="font-bold text-3xl text-primary">₹{{ effectivePrice.toLocaleString() }}</span>
                        <span v-if="product.discount_price" class="text-xl text-text-body line-through">₹{{ product.price.toLocaleString() }}</span>
                        <span v-if="product.discount_price" class="bg-red-500 text-white px-2 py-1 text-xs rounded">
                            {{ discountPercentage }}% OFF
                        </span>
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

                    <!-- Variant Selection -->
                    <div v-if="product.variants && product.variants.length > 0" class="variants mb-6">
                        <div class="mb-4">
                            <span class="text-sm font-medium mb-2 block">Select Variant</span>
                            <div class="flex gap-2 flex-wrap">
                                <button 
                                    v-for="variant in product.variants" 
                                    :key="variant.id"
                                    class="px-4 py-2 border rounded-lg transition-all"
                                    :class="selectedVariant?.id === variant.id ? 'border-primary bg-primary text-white' : 'border-gray-300 hover:border-primary'"
                                    :disabled="variant.stock === 0"
                                    @click="selectedVariant = variant"
                                >
                                    {{ variant.size }} {{ variant.color ? `• ${variant.color}` : '' }}
                                    <span v-if="variant.stock === 0" class="text-xs ml-1 opacity-50">(Out of stock)</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="actions flex gap-4 mb-8">
                        <InputNumber v-model="quantity" :min="1" :max="maxQuantity" showButtons class="w-32" />
                        <Button label="Add to Cart" icon="pi pi-shopping-cart" class="flex-1" @click="addToCart" :disabled="product.stock === 0" />
                    </div>

                    <button class="wishlist-btn flex items-center gap-2 text-sm" @click="toggleWishlist">
                        <i :class="product.is_wishlisted ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'" class="text-lg"></i>
                        {{ product.is_wishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                    </button>

                    <!-- Reviews Summary -->
                    <div class="reviews-section mt-12 pt-8 border-t">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-serif text-2xl">Customer Reviews</h3>
                            <div class="flex items-center gap-2">
                                <Rating :modelValue="averageRating" :cancel="false" readonly />
                                <span class="text-sm text-text-body">({{ product.reviews?.length || 0 }} reviews)</span>
                            </div>
                        </div>
                        <div v-if="product.reviews && product.reviews.length > 0">
                            <div v-for="review in product.reviews" :key="review.id" class="review-item mb-6 pb-6 border-b">
                                <div class="flex items-center gap-4 mb-2">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-medium">{{ review.user?.name?.charAt(0) || 'A' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">{{ review.user?.name || 'Anonymous' }}</span>
                                        <div class="flex items-center gap-2">
                                            <Rating :modelValue="review.rating" :cancel="false" readonly class="text-sm" />
                                            <span class="text-xs text-text-body">{{ review.created_at }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-text-body mt-2">{{ review.comment }}</p>
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

        <!-- Lightbox -->
        <Teleport to="body">
            <div v-if="lightboxOpen" class="lightbox-overlay fixed inset-0 z-50 bg-black/95 flex items-center justify-center" @click="closeLightbox">
                <button class="lightbox-close absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10" @click="closeLightbox">
                    <i class="pi pi-times"></i>
                </button>
                <button class="lightbox-nav prev absolute left-4 text-white text-3xl hover:text-gray-300 z-10" @click.stop="prevSlide">
                    <i class="pi pi-chevron-left"></i>
                </button>
                <Swiper
                    :modules="modules"
                    :navigation="false"
                    :pagination="false"
                    :loop="true"
                    :initialSlide="lightboxIndex"
                    class="lightbox-swiper w-full max-w-4xl"
                    @swiper="setLightboxSwiper"
                >
                    <SwiperSlide v-for="(image, index) in productImages" :key="index">
                        <img :src="image" :alt="product.name" class="w-full h-[80vh] object-contain" />
                    </SwiperSlide>
                </Swiper>
                <button class="lightbox-nav next absolute right-4 text-white text-3xl hover:text-gray-300 z-10" @click.stop="nextSlide">
                    <i class="pi pi-chevron-right"></i>
                </button>
            </div>
        </Teleport>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/thumbs';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';
import Rating from 'primevue/rating';

const modules = [Navigation, Pagination, Thumbs];

const props = defineProps({
    product: Object,
    relatedProducts: Array
});

const mainSwiper = ref(null);
const thumbsSwiper = ref(null);
const lightboxSwiper = ref(null);
const activeIndex = ref(0);
const quantity = ref(1);
const selectedVariant = ref(null);
const lightboxOpen = ref(false);
const lightboxIndex = ref(0);

const setMainSwiper = (swiper) => {
    mainSwiper.value = swiper;
    swiper.on('slideChange', () => {
        activeIndex.value = swiper.activeIndex;
    });
};

const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};

const setLightboxSwiper = (swiper) => {
    lightboxSwiper.value = swiper;
};

const productImages = computed(() => {
    if (props.product.images && props.product.images.length > 0) {
        return props.product.images.map(img => img.url);
    }
    return ['https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=600&q=80'];
});

const effectivePrice = computed(() => {
    if (selectedVariant.value?.price) {
        return selectedVariant.value.price;
    }
    return props.product.discount_price || props.product.price;
});

const maxQuantity = computed(() => {
    if (selectedVariant.value) {
        return Math.min(10, selectedVariant.value.stock);
    }
    return Math.min(10, props.product.stock);
});

const discountPercentage = computed(() => {
    if (props.product.discount_price && props.product.price) {
        return Math.round(((props.product.price - props.product.discount_price) / props.product.price) * 100);
    }
    return 0;
});

const averageRating = computed(() => {
    if (props.product.reviews && props.product.reviews.length > 0) {
        const sum = props.product.reviews.reduce((acc, r) => acc + r.rating, 0);
        return sum / props.product.reviews.length;
    }
    return 0;
});

const openLightbox = (index) => {
    lightboxIndex.value = index;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closeLightbox = () => {
    lightboxOpen.value = false;
    document.body.style.overflow = '';
};

const prevSlide = () => {
    if (lightboxSwiper.value) {
        lightboxSwiper.value.slidePrev();
    }
};

const nextSlide = () => {
    if (lightboxSwiper.value) {
        lightboxSwiper.value.slideNext();
    }
};

const addToCart = () => {
    router.post(`/cart/add/${props.product.id}`, { 
        quantity: quantity.value,
        variant_id: selectedVariant.value?.id || null
    }, {
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

// Keyboard navigation for lightbox
const handleKeydown = (e) => {
    if (!lightboxOpen.value) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') prevSlide();
    if (e.key === 'ArrowRight') nextSlide();
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<style scoped>
.main-swiper-container :deep(.swiper) {
    --swiper-navigation-color: #8B2323;
    --swiper-pagination-color: #8B2323;
    --swiper-pagination-bullet-inactive-color: #ccc;
    --swiper-pagination-bullet-inactive-opacity: 1;
}

.main-swiper-container :deep(.swiper-button-prev),
.main-swiper-container :deep(.swiper-button-next) {
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.main-swiper-container :deep(.swiper-button-prev)::after,
.main-swiper-container :deep(.swiper-button-next)::after {
    font-size: 14px;
    font-weight: bold;
}

.thumbs-container :deep(.swiper-slide-thumb-active) {
    opacity: 1;
}

.thumbs-container :deep(.swiper-slide) {
    opacity: 0.6;
    transition: opacity 0.3s;
}

.thumbs-container :deep(.swiper-slide:hover) {
    opacity: 0.9;
}

.lightbox-swiper :deep(.swiper-button-prev),
.lightbox-swiper :deep(.swiper-button-next) {
    display: none;
}

.lightbox-nav {
    background: rgba(255,255,255,0.1);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s;
}

.lightbox-nav:hover {
    background: rgba(255,255,255,0.2);
}
</style>