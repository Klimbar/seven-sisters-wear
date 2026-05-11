<template>
    <AdminLayout>
        <div class="mb-8">
            <Link :href="route('admin.orders.index')" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
                <i class="pi pi-arrow-left"></i>
                Back to Orders
            </Link>
            <h1 class="font-serif text-3xl text-gray-900">Order #{{ order.id }}</h1>
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
                                <img :src="item.product?.images?.[0]?.url || 'https://via.placeholder.com/100'" 
                                     class="w-full h-full object-cover">
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
                        <Button label="Update Status" class="w-full" @click="updateStatus" :loading="updating" />
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Summary</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method</span>
                            <span class="font-medium uppercase">{{ order.payment_method }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Status</span>
                            <span class="font-medium capitalize">{{ order.payment_status }}</span>
                        </div>
                        <div class="border-t pt-2 flex justify-between font-semibold">
                            <span>Total</span>
                            <span>₹{{ order.total_amount?.toLocaleString() }}</span>
                        </div>
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
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Select from 'primevue/select';
import Button from 'primevue/button';

const props = defineProps({
    order: Object
});

const updating = ref(false);
const newStatus = ref(props.order.status);

const statusOptions = [
    { name: 'Pending', value: 'pending' },
    { name: 'Confirmed', value: 'confirmed' },
    { name: 'Packed', value: 'packed' },
    { name: 'Shipped', value: 'shipped' },
    { name: 'Delivered', value: 'delivered' },
    { name: 'Cancelled', value: 'cancelled' },
    { name: 'Returned', value: 'returned' }
];

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'confirmed': 'bg-blue-100 text-blue-800',
        'packed': 'bg-purple-100 text-purple-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
        'returned': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const updateStatus = () => {
    updating.value = true;
    router.patch(route('admin.orders.updateStatus', props.order.id), {
        status: newStatus.value
    }, {
        onFinish: () => {
            updating.value = false;
        }
    });
};
</script>