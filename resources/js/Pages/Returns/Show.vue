<template>
    <div class="return-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="mb-8">
                <Link :href="route('returns.index')" class="text-gray-500 hover:text-gray-700 inline-flex items-center gap-2 mb-4">
                    <i class="pi pi-arrow-left"></i>
                    Back to Returns
                </Link>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="font-serif text-3xl text-gray-900">Return {{ getReturnReference(returnRequest) }}</h1>
                        <p class="text-gray-500 mt-1">Order {{ getOrderReference(returnRequest) }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-medium" :class="getStatusClass(returnRequest.status)">
                        {{ getStatusLabel(returnRequest.status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="font-semibold text-lg mb-4">Return Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Reason</p>
                                <p class="font-medium">{{ returnRequest.reason }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Requested On</p>
                                <p class="font-medium">{{ formatDate(returnRequest.created_at) }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-1">Description</p>
                            <p class="text-gray-700 whitespace-pre-line">{{ returnRequest.description }}</p>
                        </div>
                    </section>

                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="font-semibold text-lg mb-4">Order Items</h2>
                        <div class="space-y-4">
                            <div v-for="item in returnRequest.order?.items" :key="item.id" class="flex gap-4 pb-4 border-b last:border-0">
                                <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    <img v-if="item.product?.images?.[0]?.url" :src="item.product.images[0].url" class="w-full h-full object-cover">
                                    <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">{{ item.product?.name }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ item.quantity }} × ₹{{ Number(item.price).toLocaleString() }}</p>
                                </div>
                                <div class="font-semibold">₹{{ Number(item.quantity * item.price).toLocaleString() }}</div>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="space-y-6">
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="font-semibold text-lg mb-4">Status</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">Pickup Date</span>
                                <span class="font-medium text-right">{{ formatDate(returnRequest.pickup_date) }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">Tracking</span>
                                <span class="font-medium text-right">{{ returnRequest.tracking_number || 'Not available' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">Refund Amount</span>
                                <span class="font-medium text-right">{{ returnRequest.refund_amount ? `₹${Number(returnRequest.refund_amount).toLocaleString()}` : 'Not set' }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500">Refund Date</span>
                                <span class="font-medium text-right">{{ formatDate(returnRequest.refund_date) }}</span>
                            </div>
                        </div>
                    </section>

                    <section v-if="returnRequest.pickup_address" class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="font-semibold text-lg mb-4">Pickup Address</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ returnRequest.pickup_address }}</p>
                    </section>

                    <section v-if="returnRequest.admin_notes" class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="font-semibold text-lg mb-4">Admin Notes</h2>
                        <p class="text-gray-700 whitespace-pre-line">{{ returnRequest.admin_notes }}</p>
                    </section>
                </aside>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
    returnRequest: Object
});

const getStatusClass = (status) => {
    const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        approved: 'bg-blue-100 text-blue-800',
        picked_up: 'bg-indigo-100 text-indigo-800',
        in_transit: 'bg-purple-100 text-purple-800',
        received: 'bg-teal-100 text-teal-800',
        rejected: 'bg-red-100 text-red-800',
        refunded: 'bg-green-100 text-green-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
    const labels = {
        pending: 'Pending',
        approved: 'Approved',
        picked_up: 'Picked Up',
        in_transit: 'In Transit',
        received: 'Received',
        rejected: 'Rejected',
        refunded: 'Refunded'
    };
    return labels[status] || status;
};

const getOrderReference = (returnRequest) => {
    return returnRequest.order?.order_number || `#${returnRequest.order_id}`;
};

const getReturnReference = (returnRequest) => {
    return returnRequest.return_number || `RET-${String(returnRequest.id).padStart(6, '0')}`;
};

const formatDate = (value) => {
    if (!value) return 'Not set';
    return new Date(value).toLocaleDateString();
};
</script>
