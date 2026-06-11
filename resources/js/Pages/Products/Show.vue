<template>
    <div class="product-show-page bg-cream-light">
        <Navbar />
        <div class="container mx-auto px-4 py-20 sm:px-6 lg:py-24">
            <div class="grid items-start gap-10 lg:grid-cols-[minmax(0,1.05fr)_minmax(360px,0.95fr)] lg:gap-14">
                <!-- Product Images with Swiper -->
                <div class="product-images lg:sticky lg:top-24">
                    <!-- Main Swiper -->
                    <div class="main-swiper-container relative overflow-hidden rounded-lg border border-cream-pattern bg-white shadow-sm">
                        <Swiper
                            v-if="productImages.length"
                            :modules="modules"
                            :thumbs="{ swiper: thumbsSwiper }"
                            :navigation="true"
                            :pagination="{ clickable: true }"
                            :loop="productImages.length > 1"
                            class="main-swiper"
                            @swiper="setMainSwiper"
                        >
                            <SwiperSlide v-for="(image, index) in productImages" :key="image.id || index">
                                <div class="relative aspect-[4/5] cursor-zoom-in bg-cream" @click="openLightbox(productImages, index)">
                                    <img 
                                        :src="image.url"
                                        :alt="product.name" 
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            </SwiperSlide>
                        </Swiper>
                        <div v-else class="flex aspect-[4/5] items-center justify-center bg-cream text-text-body">No image</div>
                    </div>

                    <!-- Thumbnail Swiper -->
                    <div class="thumbs-container mt-4" v-if="productImages.length > 1">
                        <Swiper
                            :modules="modules"
                            :spaceBetween="10"
                            :slidesPerView="4"
                            :loop="false"
                            :watchSlidesProgress="true"
                            class="thumbs-swiper"
                            @swiper="setThumbsSwiper"
                        >
                            <SwiperSlide v-for="(image, index) in productImages" :key="image.id || index">
                                <div 
                                    class="relative aspect-square cursor-pointer overflow-hidden rounded-lg border-2 bg-white transition-all"
                                    :class="activeIndex === index ? 'border-primary opacity-100 shadow-sm ring-2 ring-primary/25' : 'border-transparent opacity-60 hover:border-cream-pattern hover:opacity-95'"
                                    :aria-current="activeIndex === index ? 'true' : 'false'"
                                    @click="goToImage(index)"
                                >
                                    <img :src="image.url" :alt="product.name" class="w-full h-full object-cover" />
                                </div>
                            </SwiperSlide>
                        </Swiper>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="product-info rounded-lg border border-cream-pattern bg-white p-5 shadow-sm sm:p-7 lg:p-8">
                    <div class="mb-5 flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-accent">{{ product.fabric }}</span>
                        <span v-if="product.category?.name" class="rounded-full bg-secondary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-secondary">{{ product.category.name }}</span>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wider" :class="product.stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'">
                            {{ product.stock > 0 ? 'In stock' : 'Out of stock' }}
                        </span>
                    </div>

                    <h1 class="font-serif text-3xl leading-tight text-text-dark sm:text-4xl lg:text-5xl">{{ product.name }}</h1>
                    
                    <div class="mt-5 flex flex-wrap items-end gap-3 border-b border-cream-pattern pb-6">
                        <span class="text-3xl font-bold text-primary sm:text-4xl">₹{{ effectivePrice.toLocaleString() }}</span>
                        <span v-if="product.discount_price" class="pb-1 text-lg text-text-body line-through">₹{{ product.price.toLocaleString() }}</span>
                        <span v-if="product.discount_price" class="mb-1 rounded bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                            {{ discountPercentage }}% OFF
                        </span>
                    </div>

                    <p class="my-6 leading-7 text-text-body">{{ product.description }}</p>

                    <div class="product-details mb-7 rounded-lg bg-cream p-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="min-w-0">
                                <span class="text-xs uppercase tracking-wide text-text-body/70">Fabric</span>
                                <p class="truncate font-medium text-text-dark">{{ product.fabric || '-' }}</p>
                            </div>
                            <div class="min-w-0">
                                <span class="text-xs uppercase tracking-wide text-text-body/70">Tribe</span>
                                <p class="truncate font-medium text-text-dark">{{ product.tribe?.name || 'N/A' }}</p>
                            </div>
                            <div class="min-w-0">
                                <span class="text-xs uppercase tracking-wide text-text-body/70">Stock</span>
                                <p class="truncate font-medium" :class="product.stock > 0 ? 'text-green-700' : 'text-red-700'">
                                    {{ product.stock > 0 ? `${product.stock} in stock` : 'Out of stock' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Variant Selection -->
                    <div v-if="product.variants && product.variants.length > 0" class="variants mb-7">
                        <div>
                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-sm font-semibold text-text-dark">Select Variant</span>
                                <button 
                                    v-if="selectedVariant" 
                                    type="button" 
                                    class="text-xs font-semibold text-primary hover:underline"
                                    @click="selectedVariant = null"
                                >
                                    Clear Selection
                                </button>
                            </div>
                            <div class="flex gap-2 flex-wrap">
                                <button 
                                    v-for="variant in product.variants" 
                                    :key="variant.id"
                                    class="rounded-lg border px-4 py-2.5 text-sm font-medium transition-all disabled:cursor-not-allowed disabled:opacity-45"
                                    :class="selectedVariant?.id === variant.id ? 'border-primary bg-primary text-white shadow-sm' : 'border-cream-pattern bg-white text-text-dark hover:border-primary hover:bg-primary/5'"
                                    :disabled="variant.stock === 0"
                                    @click="selectedVariant = selectedVariant?.id === variant.id ? null : variant"
                                >
                                    {{ variant.size }} {{ variant.color ? `• ${variant.color}` : '' }}
                                    <span v-if="variant.stock === 0" class="text-xs ml-1 opacity-50">(Out of stock)</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="actions mb-5 grid gap-3 sm:grid-cols-[8rem_1fr]">
                        <InputNumber v-model="quantity" :min="1" :max="maxQuantity" showButtons class="w-full" />
                        <Button label="Add to Cart" icon="pi pi-shopping-cart" class="w-full !border-primary !bg-primary !py-3 hover:!bg-primary/90" @click="addToCart" :disabled="maxQuantity === 0" />
                    </div>

                    <button
                        class="wishlist-btn mb-6 flex w-full items-center justify-center gap-2 rounded-lg border border-cream-pattern px-4 py-3 text-sm font-medium text-text-dark transition-colors hover:border-primary hover:text-primary disabled:cursor-not-allowed disabled:opacity-60"
                        :disabled="wishlistProcessing"
                        @click="toggleWishlist"
                    >
                        <i :class="isWishlisted ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'" class="text-lg"></i>
                        {{ isWishlisted ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                    </button>

                    <div class="grid gap-3 border-t border-cream-pattern pt-5 text-sm text-text-body sm:grid-cols-3">
                        <div class="flex items-center gap-2">
                            <i class="pi pi-truck text-primary"></i>
                            <span>Secure delivery</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-refresh text-primary"></i>
                            <span>Easy returns</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-shield text-primary"></i>
                            <span>Authentic craft</span>
                        </div>
                    </div>

                    <!-- Reviews Summary -->
                    <div class="reviews-section mt-8 border-t border-cream-pattern pt-8">
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                            <h3 class="font-serif text-2xl text-text-dark">Customer Reviews</h3>
                            <div class="flex items-center gap-2 rounded-full bg-cream px-3 py-2">
                                <Rating :modelValue="averageRating" :cancel="false" readonly />
                                <span class="text-sm text-text-body">({{ product.reviews?.length || 0 }} reviews)</span>
                            </div>
                        </div>

                        <div class="mb-8 rounded-lg border border-cream-pattern bg-cream/60 p-5">
                            <form v-if="canReview" @submit.prevent="submitReview" class="space-y-4">
                                <p v-if="reviewForm.errors.review" class="rounded-md bg-red-50 px-3 py-2 text-sm text-red-700">
                                    {{ reviewForm.errors.review }}
                                </p>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Your Rating</label>
                                    <Rating v-model="reviewForm.rating" :cancel="false" />
                                    <p v-if="reviewForm.errors.rating" class="mt-1 text-sm text-red-600">{{ reviewForm.errors.rating }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Your Review</label>
                                    <Textarea
                                        v-model="reviewForm.comment"
                                        rows="4"
                                        class="w-full"
                                        placeholder="Share your experience with this product..."
                                    />
                                    <p v-if="reviewForm.errors.comment" class="mt-1 text-sm text-red-600">{{ reviewForm.errors.comment }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Review Images</label>
                                    <input
                                        type="file"
                                        multiple
                                        accept="image/*"
                                        class="block w-full text-sm text-text-body file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-primary/90"
                                        @change="setReviewImages"
                                    >
                                    <p class="mt-1 text-xs text-text-body">Upload up to 5 images.</p>
                                    <p v-if="reviewForm.errors.images" class="mt-1 text-sm text-red-600">{{ reviewForm.errors.images }}</p>
                                    <div v-if="reviewImagePreviews.length" class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-5">
                                        <div
                                            v-for="(preview, index) in reviewImagePreviews"
                                            :key="preview.url"
                                            class="relative overflow-hidden rounded border border-cream-pattern bg-white"
                                        >
                                            <img :src="preview.url" :alt="`Selected review image ${index + 1}`" class="h-24 w-full bg-cream object-contain">
                                            <button
                                                type="button"
                                                class="absolute right-1 top-1 rounded bg-white/90 px-2 py-1 text-xs font-medium text-red-600 shadow hover:bg-white"
                                                @click="removeReviewImage(index)"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <Button type="submit" label="Submit Review" icon="pi pi-star" :loading="reviewForm.processing" />
                            </form>

                            <div v-else-if="!authUser" class="text-sm text-text-body">
                                Please
                                <button type="button" class="text-primary font-medium hover:underline" @click="$inertia.visit('/login')">
                                    log in
                                </button>
                                after purchasing this product to leave a review.
                            </div>

                            <p v-else-if="hasReviewedProduct" class="text-sm text-text-body">
                                You have already reviewed this product.
                            </p>

                            <p v-else class="text-sm text-text-body">
                                You can review this product after completing a purchase.
                            </p>
                        </div>

                        <div v-if="product.reviews && product.reviews.length > 0" class="space-y-4">
                            <div v-for="review in product.reviews" :key="review.id" class="review-item rounded-lg border border-cream-pattern bg-white p-4">
                                <div class="flex items-center gap-4 mb-2">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-medium">{{ review.user?.name?.charAt(0) || 'A' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">{{ review.user?.name || 'Anonymous' }}</span>
                                        <div class="flex items-center gap-2">
                                            <Rating :modelValue="review.rating" :cancel="false" readonly class="text-sm" />
                                            <span class="text-xs text-text-body">{{ formatReviewDate(review.created_at) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-text-body mt-2">{{ review.comment }}</p>
                                <div v-if="review.images && review.images.length" class="mt-3 grid grid-cols-3 gap-2">
                                    <button
                                        v-for="(image, index) in review.images"
                                        :key="image.id"
                                        type="button"
                                        class="block rounded bg-cream"
                                        @click="openLightbox(review.images, index)"
                                    >
                                        <img
                                            :src="image.url"
                                            :alt="`Review image for ${product.name}`"
                                            class="w-full max-h-36 cursor-zoom-in object-contain"
                                        >
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p v-else class="rounded-lg border border-dashed border-cream-pattern bg-white p-4 text-text-body">No reviews yet. Be the first to review!</p>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="related-products mt-16 border-t border-cream-pattern pt-12">
                <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-widest text-accent">More to explore</span>
                        <h2 class="font-serif text-3xl text-text-dark">Related Products</h2>
                    </div>
                    <button class="text-sm font-medium text-primary hover:underline" @click="$inertia.visit('/shop')">View all products</button>
                </div>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="related in relatedProducts" :key="related.id" 
                         class="product-card cursor-pointer overflow-hidden rounded-lg border border-cream-pattern bg-white shadow-sm transition-all hover:-translate-y-1 hover:shadow-lg"
                         @click="$inertia.visit(`/products/${related.id}`)">
                        <div class="aspect-[3/4] overflow-hidden bg-cream">
                            <img v-if="related.images?.[0]?.url" :src="related.images[0].url" :alt="related.name" class="w-full h-full object-cover hover:scale-105 transition-transform">
                            <div v-else class="flex h-full w-full items-center justify-center text-sm text-text-body">No image</div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-serif text-lg mb-1">{{ related.name }}</h4>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-primary">₹{{ (related.discount_price || related.price).toLocaleString() }}</span>
                                <span v-if="related.discount_price" class="text-sm text-text-body/60 line-through">₹{{ related.price.toLocaleString() }}</span>
                            </div>
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
                <SwiperSlide v-for="(image, index) in lightboxImages" :key="image.id || index">
                    <img :src="image.url" :alt="image.alt || product.name" class="w-full h-[80vh] object-contain" />
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
import { useToast } from 'primevue/usetoast';
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
import Textarea from 'primevue/textarea';
import { useForm, usePage } from '@inertiajs/vue3';

const toast = useToast();

const modules = [Navigation, Pagination, Thumbs];

const props = defineProps({
    product: Object,
    relatedProducts: Array,
    canReview: Boolean,
    hasPurchasedProduct: Boolean,
    hasReviewedProduct: Boolean
});

const page = usePage();
const authUser = computed(() => page.props.auth?.user);
const reviewForm = useForm({
    rating: 0,
    comment: '',
    images: []
});
const reviewImagePreviews = ref([]);

const mainSwiper = ref(null);
const thumbsSwiper = ref(null);
const lightboxSwiper = ref(null);
const lightboxImages = ref([]);
const activeIndex = ref(0);
const quantity = ref(1);
const selectedVariant = ref(null);
const lightboxOpen = ref(false);
const lightboxIndex = ref(0);
const isWishlisted = ref(Boolean(props.product.is_wishlisted));
const wishlistProcessing = ref(false);

const setMainSwiper = (swiper) => {
    mainSwiper.value = swiper;
    swiper.on('slideChange', () => {
        activeIndex.value = swiper.realIndex;
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
        return [...props.product.images]
            .sort((a, b) => Number(b.is_primary) - Number(a.is_primary) || Number(a.id || 0) - Number(b.id || 0))
            .map((img, index) => ({
                id: img.id || index,
                url: img.url,
                isPrimary: img.is_primary
            }));
    }
    return [];
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

const formatReviewDate = (date) => {
    if (!date) {
        return '';
    }

    return new Intl.DateTimeFormat('en-IN', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date));
};

const normalizeLightboxImages = (images) => {
    return (images || []).map((image, index) => ({
        id: image.id ?? index,
        url: image.url ?? image,
        alt: image.alt || props.product.name
    }));
};

const openLightbox = (images, index = 0) => {
    lightboxImages.value = normalizeLightboxImages(images);
    lightboxIndex.value = index;
    lightboxOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const goToImage = (index) => {
    activeIndex.value = index;

    if (mainSwiper.value) {
        if (productImages.value.length > 1) {
            mainSwiper.value.slideToLoop(index);
        } else {
            mainSwiper.value.slideTo(index);
        }
    }
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
        preserveScroll: true,
        onSuccess: (page) => {
            const error = page.props.flash?.error;

            if (error) {
                toast.add({ severity: 'error', summary: 'Cart Error', detail: error, life: 3000 });
                return;
            }

            quantity.value = 1;
            toast.add({ severity: 'success', summary: 'Added to Cart', detail: `${props.product.name} has been added to your cart.`, life: 3000 });
        }
    });
};

const toggleWishlist = () => {
    if (!authUser.value) {
        router.visit(route('login'));
        return;
    }

    wishlistProcessing.value = true;

    router.post(route('wishlist.toggle', props.product.id), {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            isWishlisted.value = !isWishlisted.value;
            toast.add({
                severity: 'success',
                summary: isWishlisted.value ? 'Added to Wishlist' : 'Removed from Wishlist',
                detail: `${props.product.name} ${isWishlisted.value ? 'has been added to' : 'has been removed from'} your wishlist.`,
                life: 2500
            });
        },
        onFinish: () => {
            wishlistProcessing.value = false;
        }
    });
};

const setReviewImages = (event) => {
    const remainingSlots = Math.max(0, 5 - reviewForm.images.length);
    const selectedFiles = Array.from(event.target.files || []).slice(0, remainingSlots);

    reviewForm.images = [...reviewForm.images, ...selectedFiles];
    reviewImagePreviews.value = [
        ...reviewImagePreviews.value,
        ...selectedFiles.map((file) => ({
        name: file.name,
        url: URL.createObjectURL(file)
        }))
    ];
    event.target.value = '';
};

const clearReviewImagePreviews = () => {
    reviewImagePreviews.value.forEach((preview) => URL.revokeObjectURL(preview.url));
    reviewImagePreviews.value = [];
};

const removeReviewImage = (index) => {
    URL.revokeObjectURL(reviewImagePreviews.value[index].url);
    reviewImagePreviews.value.splice(index, 1);
    reviewForm.images.splice(index, 1);
};

const submitReview = () => {
    reviewForm.post(`/products/${props.product.id}/review`, {
        preserveScroll: true,
        onSuccess: () => {
            reviewForm.reset();
            reviewForm.rating = 0;
            reviewForm.images = [];
            clearReviewImagePreviews();
            toast.add({ severity: 'success', summary: 'Review Submitted', detail: 'Thank you for reviewing this product.', life: 3000 });
        },
        onError: () => {
            toast.add({ severity: 'error', summary: 'Review Not Submitted', detail: 'Please check the form and try again.', life: 3000 });
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
    document.body.style.overflow = '';
    clearReviewImagePreviews();
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
    width: 44px;
    height: 44px;
    padding: 12px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.main-swiper-container :deep(.swiper-button-prev)::after,
.main-swiper-container :deep(.swiper-button-next)::after {
    font-size: 13px;
    font-weight: bold;
}

.thumbs-container :deep(.swiper-slide-thumb-active) {
    opacity: 1;
}

.thumbs-container :deep(.swiper-slide) {
    opacity: 1;
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
