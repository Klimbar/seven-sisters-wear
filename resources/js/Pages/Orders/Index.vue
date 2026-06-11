<template>
    <div class="orders-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">My Orders</h1>
            
            <div v-if="orders.data.length === 0" class="text-center py-16">
                <i class="pi pi-box text-6xl text-gray-300 mb-4"></i>
                <p class="text-text-body text-lg mb-6">No orders yet</p>
                <Button label="Start Shopping" @click="$inertia.visit('/shop')" />
            </div>

            <div v-else class="space-y-6">
                <div v-for="order in orders.data" :key="order.id" 
                     class="order-card bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-all cursor-pointer"
                     @click="$inertia.visit(`/orders/${order.id}`)">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-serif text-lg mb-1">Order {{ order.order_number }}</h3>
                            <p class="text-sm text-text-body">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold" 
                                  :class="getStatusClass(order.status)">
                                {{ getOrderStatusLabel(order.status) }}
                            </span>
                            <span
                                v-if="order.return_request"
                                class="mt-2 block px-3 py-1 rounded-full text-xs font-semibold"
                                :class="getReturnStatusClass(order.return_request.status)"
                            >
                                Return: {{ getReturnStatusLabel(order.return_request.status) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div v-for="item in order.items.slice(0, 3)" :key="item.id" class="w-16 h-16 flex-shrink-0">
                            <img v-if="item.product?.images?.[0]?.url" :src="item.product.images[0].url" :alt="item.product?.name" class="w-full h-full object-cover rounded">
                            <div v-else class="flex h-full w-full items-center justify-center rounded bg-gray-100 text-xs text-gray-500">No image</div>
                        </div>
                        <div v-if="order.items.length > 3" class="w-16 h-16 flex items-center justify-center bg-gray-100 rounded text-sm text-text-body">
                            +{{ order.items.length - 3 }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-sm text-text-body">{{ order.items.length }} item(s)</span>
                        <span class="font-bold text-lg text-primary">₹{{ order.total_amount.toLocaleString() }}</span>
                    </div>

                    <div v-if="order.return_request" class="mt-4 rounded-lg bg-gray-50 p-3 text-sm text-text-body">
                        <div class="flex flex-wrap justify-between gap-2">
                            <span>Return ID: {{ getReturnReference(order.return_request) }}</span>
                            <span v-if="order.return_request.refund_amount">
                                Refund: ₹{{ Number(order.return_request.refund_amount).toLocaleString() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <Paginator :rows="orders.per_page" :totalRecords="orders.total" @page="onPageChange" />
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
import Paginator from 'primevue/paginator';

const props = defineProps({
    orders: Object
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

const onPageChange = (event) => {
    router.get('/orders', { page: event.page + 1 }, { preserveState: true });
};
</script>
