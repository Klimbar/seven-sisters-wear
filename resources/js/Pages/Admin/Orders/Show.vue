<template>
    <AdminLayout>
        <div class="mb-8">
            <Link :href="route('admin.orders.index')" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
                <i class="pi pi-arrow-left"></i>
                Back to Orders
            </Link>
            <h1 class="font-serif text-3xl text-gray-900">Order {{ order.order_number }}</h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Items</h3>
                    <div class="space-y-4">
                        <div v-for="item in order.items" :key="item.id" class="flex gap-4 pb-4 border-b last:border-0">
                            <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                <img v-if="item.product?.images?.[0]?.url" :src="item.product.images[0].url" class="w-full h-full object-cover">
                                <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ item.product?.name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ item.quantity }} × ₹{{ item.price?.toLocaleString() }}</p>
                            </div>
                            <div class="font-semibold">₹{{ (item.quantity * item.price)?.toLocaleString() }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Shipping Address</h3>
                    <p class="text-gray-600 whitespace-pre-line">{{ order.shipping_address }}</p>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Payment Status</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-medium uppercase">{{ order.payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium capitalize"
                                  :class="getPaymentStatusClass(order.payment_status)">
                                {{ getPaymentStatusLabel(order.payment_status) }}
                            </span>
                        </div>
                        <div class="space-y-3 pt-3">
                            <label class="block text-sm font-medium text-gray-700">Update Payment Status</label>
                            <Select v-model="newPaymentStatus" :options="paymentStatusOptions" optionLabel="name" optionValue="value" class="w-full" />
                            <Button label="Update Payment" class="w-full" @click="updatePaymentStatus" :loading="updatingPayment" />
                        </div>
                        <div class="border-t pt-2 flex justify-between font-semibold">
                            <span>Total</span>
                            <span>₹{{ order.total_amount?.toLocaleString() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Status</h3>
                    <div class="mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium" :class="getStatusClass(order.status)">
                            {{ order.status }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Update Status</label>
                        <Select v-model="newStatus" :options="statusOptions" optionLabel="name" optionValue="value" class="w-full" />
                        <Button label="Update Status" class="w-full" @click="updateStatus" :loading="updatingStatus" />
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Customer</h3>
                    <p class="font-medium">{{ order.user?.name || 'Guest' }}</p>
                    <p class="text-gray-500">{{ order.user?.email }}</p>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Select from 'primevue/select';
import Button from 'primevue/button';

const props = defineProps({
    order: Object
});

const updatingStatus = ref(false);
const updatingPayment = ref(false);
const newStatus = ref(props.order.status);
const newPaymentStatus = ref(props.order.payment_status);

const statusOptions = [
    { name: 'Pending', value: 'pending' },
    { name: 'Processing', value: 'processing' },
    { name: 'Shipped', value: 'shipped' },
    { name: 'Delivered', value: 'delivered' },
    { name: 'Cancelled', value: 'cancelled' },
    { name: 'Returned', value: 'returned' }
];

const paymentStatusOptions = [
    { name: 'Pending', value: 'pending' },
    { name: 'Paid', value: 'completed' },
    { name: 'Failed', value: 'failed' },
    { name: 'Refunded', value: 'refunded' }
];

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

const getPaymentStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'completed': 'bg-green-100 text-green-800',
        'failed': 'bg-red-100 text-red-800',
        'refunded': 'bg-purple-100 text-purple-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getPaymentStatusLabel = (status) => {
    const labels = {
        'pending': 'Pending',
        'completed': 'Paid',
        'failed': 'Failed',
        'refunded': 'Refunded'
    };
    return labels[status] || status;
};

const updateStatus = () => {
    updatingStatus.value = true;
    router.patch(route('admin.orders.updateStatus', props.order.id), {
        status: newStatus.value
    }, {
        onFinish: () => {
            updatingStatus.value = false;
        }
    });
};

const updatePaymentStatus = () => {
    updatingPayment.value = true;
    router.patch(route('admin.orders.updatePaymentStatus', props.order.id), {
        payment_status: newPaymentStatus.value
    }, {
        onFinish: () => {
            updatingPayment.value = false;
        }
    });
};
</script>
