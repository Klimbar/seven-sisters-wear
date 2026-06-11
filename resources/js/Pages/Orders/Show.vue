<template>
    <div class="order-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <button class="flex items-center gap-2 text-text-body hover:text-primary mb-8" @click="$inertia.visit('/orders')">
                <i class="pi pi-arrow-left"></i>
                Back to Orders
            </button>

            <!-- Flash Messages -->
            <div v-if="$page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash?.info" class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.info }}
            </div>
            <div v-if="$page.props.flash?.error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.error }}
            </div>
            <div v-if="$page.props.flash?.warning" class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.warning }}
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="font-serif text-3xl mb-1">Order {{ order.order_number }}</h1>
                                <p class="text-text-body">{{ new Date(order.created_at).toLocaleString() }}</p>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold" :class="getStatusClass(order.status)">
                                {{ getOrderStatusLabel(order.status) }}
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div v-for="item in order.items" :key="item.id" class="pb-6 border-b last:border-0">
                                <div class="flex gap-4">
                                    <img v-if="item.product?.images?.[0]?.url" :src="item.product.images[0].url" :alt="item.product?.name" class="w-20 h-20 object-cover rounded flex-shrink-0">
                                    <div v-else class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded bg-gray-100 text-xs text-gray-500">No image</div>
                                    <div class="flex-1">
                                        <h3 class="font-medium mb-1">{{ item.product?.name || 'Product' }}</h3>
                                        <p v-if="variantLabel(item)" class="text-sm text-text-body">Variant: {{ variantLabel(item) }}</p>
                                        <p class="text-sm text-text-body">Qty: {{ item.quantity }}</p>
                                    </div>
                                    <span class="font-semibold">₹{{ (item.price * item.quantity).toLocaleString() }}</span>
                                </div>

                                <div v-if="canReviewOrder && item.product" class="mt-5 rounded-lg border border-gray-200 bg-gray-50 p-4">
                                    <h4 class="font-medium mb-3">
                                        {{ existingReview(item) ? 'Edit Your Review' : 'Write a Review' }}
                                    </h4>

                                    <form @submit.prevent="submitReview(item)" class="space-y-4">
                                        <p v-if="reviewForms[item.id]?.errors.review" class="rounded-md bg-red-50 px-3 py-2 text-sm text-red-700">
                                            {{ reviewForms[item.id].errors.review }}
                                        </p>

                                        <div>
                                            <label class="block text-sm font-medium mb-2">Rating</label>
                                            <Rating v-model="reviewForms[item.id].rating" :cancel="false" />
                                            <p v-if="reviewForms[item.id]?.errors.rating" class="mt-1 text-sm text-red-600">
                                                {{ reviewForms[item.id].errors.rating }}
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-2">Review</label>
                                            <Textarea
                                                v-model="reviewForms[item.id].comment"
                                                rows="3"
                                                class="w-full"
                                                placeholder="Share your experience with this product..."
                                            />
                                            <p v-if="reviewForms[item.id]?.errors.comment" class="mt-1 text-sm text-red-600">
                                                {{ reviewForms[item.id].errors.comment }}
                                            </p>
                                        </div>

                                        <div v-if="existingReview(item)?.images?.length">
                                            <label class="block text-sm font-medium mb-2">Current Images</label>
                                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                                <div
                                                    v-for="image in existingReview(item).images"
                                                    :key="image.id"
                                                    class="relative overflow-hidden rounded border bg-white"
                                                    :class="isMarkedForRemoval(item, image.id) ? 'opacity-50' : ''"
                                                >
                                                    <img :src="image.url" :alt="`Review image for ${item.product.name}`" class="h-24 w-full bg-gray-100 object-contain">
                                                    <button
                                                        type="button"
                                                        class="absolute right-1 top-1 rounded bg-white/90 px-2 py-1 text-xs font-medium shadow hover:bg-white"
                                                        :class="isMarkedForRemoval(item, image.id) ? 'text-gray-700' : 'text-red-600'"
                                                        @click="toggleExistingImageRemoval(item, image.id)"
                                                    >
                                                        {{ isMarkedForRemoval(item, image.id) ? 'Undo' : 'Delete' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium mb-2">Add Images</label>
                                            <input
                                                type="file"
                                                multiple
                                                accept="image/*"
                                                class="block w-full text-sm text-text-body file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-primary/90"
                                                @change="setReviewImages(item, $event)"
                                            >
                                            <p class="mt-1 text-xs text-text-body">A review can have up to 5 images.</p>
                                            <p v-if="reviewForms[item.id]?.errors.images" class="mt-1 text-sm text-red-600">
                                                {{ reviewForms[item.id].errors.images }}
                                            </p>
                                            <div v-if="reviewImagePreviews[item.id]?.length" class="mt-3 grid grid-cols-2 gap-3 sm:grid-cols-4">
                                                <div
                                                    v-for="(preview, index) in reviewImagePreviews[item.id]"
                                                    :key="preview.url"
                                                    class="relative overflow-hidden rounded border bg-white"
                                                >
                                                    <img :src="preview.url" :alt="`Selected review image ${index + 1}`" class="h-24 w-full bg-gray-100 object-contain">
                                                    <button
                                                        type="button"
                                                        class="absolute right-1 top-1 rounded bg-white/90 px-2 py-1 text-xs font-medium text-red-600 shadow hover:bg-white"
                                                        @click="removeSelectedImage(item, index)"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-3">
                                            <Button
                                                type="submit"
                                                :label="existingReview(item) ? 'Update Review' : 'Submit Review'"
                                                icon="pi pi-star"
                                                :loading="reviewForms[item.id].processing"
                                            />
                                            <Button
                                                v-if="existingReview(item)"
                                                type="button"
                                                label="Delete Review"
                                                icon="pi pi-trash"
                                                severity="danger"
                                                outlined
                                                :loading="deletingReviewId === existingReview(item).id"
                                                @click="deleteReview(item)"
                                            />
                                        </div>
                                    </form>
                                </div>

                                <p v-else-if="item.product" class="mt-4 rounded-lg bg-gray-50 p-3 text-sm text-text-body">
                                    Reviews can be added after payment is completed.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="font-serif text-xl mb-4">Shipping Address</h3>
                        <p class="text-text-body whitespace-pre-line">{{ order.shipping_address }}</p>
                    </div>

                    <div v-if="order.return_request" class="bg-white p-6 rounded-lg shadow-sm mt-6">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div>
                                <h3 class="font-serif text-xl">Return Details</h3>
                                <p class="text-sm text-text-body">Return ID: {{ getReturnReference(order.return_request) }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold" :class="getReturnStatusClass(order.return_request.status)">
                                {{ getReturnStatusLabel(order.return_request.status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-text-body">Reason</p>
                                <p class="font-medium">{{ order.return_request.reason }}</p>
                            </div>
                            <div>
                                <p class="text-text-body">Refund Amount</p>
                                <p class="font-medium">
                                    {{ order.return_request.refund_amount ? `₹${Number(order.return_request.refund_amount).toLocaleString()}` : 'Not set' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-text-body">Pickup Date</p>
                                <p class="font-medium">{{ formatDate(order.return_request.pickup_date) }}</p>
                            </div>
                            <div>
                                <p class="text-text-body">Tracking Number</p>
                                <p class="font-medium">{{ order.return_request.tracking_number || 'Not available' }}</p>
                            </div>
                        </div>

                        <div v-if="order.return_request.pickup_address" class="mt-4">
                            <p class="text-sm text-text-body mb-1">Pickup Address</p>
                            <p class="text-sm whitespace-pre-line">{{ order.return_request.pickup_address }}</p>
                        </div>

                        <div v-if="order.return_request.admin_notes" class="mt-4 rounded-lg bg-gray-50 p-3 text-sm">
                            <p class="font-medium mb-1">Admin Notes</p>
                            <p class="text-text-body whitespace-pre-line">{{ order.return_request.admin_notes }}</p>
                        </div>

                        <Button
                            label="View Full Return"
                            icon="pi pi-replay"
                            text
                            class="mt-4"
                            @click="$inertia.visit(`/returns/${order.return_request.id}`)"
                        />
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="font-serif text-xl mb-6">Order Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-text-body">Subtotal</span>
                            <span>₹{{ (order.total_amount - 100 + (order.discount_amount || 0)).toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Shipping</span>
                            <span>₹100</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="text-primary">₹{{ order.total_amount.toLocaleString() }}</span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-medium mb-2">Payment Method</h4>
                        <p class="text-text-body capitalize">{{ order.payment_method }}</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs"
                              :class="paymentStatusClass">
                            {{ paymentStatusLabel }}
                        </span>
                    </div>
                    
                    <div v-if="order.status === 'delivered' && !order.return_request" class="border-t pt-4 mt-4">
                        <Button label="Request Return" icon="pi pi-replay" class="w-full" 
                                @click="$inertia.visit(`/returns/create?order_id=${order.id}`)" />
                    </div>
                    <div v-else-if="order.return_request" class="border-t pt-4 mt-4">
                        <Button
                            label="View Return Status"
                            icon="pi pi-replay"
                            class="w-full"
                            outlined
                            @click="$inertia.visit(`/returns/${order.return_request.id}`)"
                        />
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { computed, onUnmounted, ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import Rating from 'primevue/rating';
import Textarea from 'primevue/textarea';

const props = defineProps({
    order: Object
});

const canReviewOrder = computed(() => props.order.payment_status === 'completed');

const existingReview = (item) => item.product?.reviews?.[0] || null;

const reviewForms = {};
const reviewImagePreviews = ref({});
const deletingReviewId = ref(null);
props.order.items.forEach((item) => {
    const review = existingReview(item);

    reviewForms[item.id] = useForm({
        rating: review?.rating || 0,
        comment: review?.comment || '',
        images: [],
        remove_image_ids: [],
        _method: review ? 'patch' : undefined,
    });
    reviewImagePreviews.value[item.id] = [];
});

const setReviewImages = (item, event) => {
    const form = reviewForms[item.id];
    const remainingSlots = Math.max(0, 5 - form.images.length);
    const selectedFiles = Array.from(event.target.files || []).slice(0, remainingSlots);

    form.images = [...form.images, ...selectedFiles];
    reviewImagePreviews.value[item.id] = [
        ...reviewImagePreviews.value[item.id],
        ...selectedFiles.map((file) => ({
        name: file.name,
        url: URL.createObjectURL(file)
        }))
    ];
    event.target.value = '';
};

const clearSelectedImagePreviews = (item) => {
    reviewImagePreviews.value[item.id]?.forEach((preview) => URL.revokeObjectURL(preview.url));
    reviewImagePreviews.value[item.id] = [];
};

const removeSelectedImage = (item, index) => {
    URL.revokeObjectURL(reviewImagePreviews.value[item.id][index].url);
    reviewImagePreviews.value[item.id].splice(index, 1);
    reviewForms[item.id].images.splice(index, 1);
};

const isMarkedForRemoval = (item, imageId) => reviewForms[item.id].remove_image_ids.includes(imageId);

const toggleExistingImageRemoval = (item, imageId) => {
    const removeIds = reviewForms[item.id].remove_image_ids;
    const index = removeIds.indexOf(imageId);

    if (index === -1) {
        removeIds.push(imageId);
        return;
    }

    removeIds.splice(index, 1);
};

const submitReview = (item) => {
    const review = existingReview(item);
    const form = reviewForms[item.id];

    if (review) {
        form._method = 'patch';
        form.post(`/reviews/${review.id}`, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.images = [];
                clearSelectedImagePreviews(item);
                form.remove_image_ids = [];
            },
        });
        return;
    }

    form.post(`/products/${item.product.id}/review`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.images = [];
            clearSelectedImagePreviews(item);
        },
    });
};

const deleteReview = (item) => {
    const review = existingReview(item);

    if (!review || !window.confirm('Delete this review?')) {
        return;
    }

    deletingReviewId.value = review.id;
    router.delete(`/reviews/${review.id}`, {
        preserveState: true,
        preserveScroll: true,
        onFinish: () => {
            deletingReviewId.value = null;
        },
    });
};

onUnmounted(() => {
    props.order.items.forEach((item) => clearSelectedImagePreviews(item));
});

const paymentStatusClass = computed(() => {
    const classes = {
        'completed': 'bg-green-100 text-green-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'failed': 'bg-red-100 text-red-800',
        'refunded': 'bg-purple-100 text-purple-800',
    };
    return classes[props.order.payment_status] || 'bg-gray-100 text-gray-800';
});

const paymentStatusLabel = computed(() => {
    const labels = {
        'completed': 'Paid',
        'pending': 'Payment Pending',
        'failed': 'Payment Failed',
        'refunded': 'Refunded',
    };
    return labels[props.order.payment_status] || props.order.payment_status;
});

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'processing': 'bg-blue-100 text-blue-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
        'returned': 'bg-purple-100 text-purple-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getOrderStatusLabel = (status) => {
    const labels = {
        'pending': 'Pending',
        'processing': 'Processing',
        'shipped': 'Shipped',
        'delivered': 'Delivered',
        'cancelled': 'Cancelled',
        'returned': 'Returned'
    };
    return labels[status] || status;
};

const getReturnStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'approved': 'bg-blue-100 text-blue-800',
        'picked_up': 'bg-indigo-100 text-indigo-800',
        'in_transit': 'bg-purple-100 text-purple-800',
        'received': 'bg-teal-100 text-teal-800',
        'rejected': 'bg-red-100 text-red-800',
        'refunded': 'bg-green-100 text-green-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getReturnStatusLabel = (status) => {
    const labels = {
        'pending': 'Pending',
        'approved': 'Approved',
        'picked_up': 'Picked Up',
        'in_transit': 'In Transit',
        'received': 'Received',
        'rejected': 'Rejected',
        'refunded': 'Refunded'
    };
    return labels[status] || status;
};

const getReturnReference = (returnRequest) => {
    return returnRequest.return_number || `RET-${String(returnRequest.id).padStart(6, '0')}`;
};

const variantLabel = (item) => {
    if (!item.variant) {
        return '';
    }

    return [item.variant.size, item.variant.color].filter(Boolean).join(' / ');
};

const formatDate = (value) => {
    if (!value) return 'Not set';
    return new Date(value).toLocaleDateString();
};
</script>
