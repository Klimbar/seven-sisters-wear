<template>
    <div class="order-show-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <button class="flex items-center gap-2 text-text-body hover:text-primary mb-8" @click="$inertia.visit('/orders')">
                <i class="pi pi-arrow-left"></i>
                Back to Orders
            </button>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h1 class="font-serif text-3xl mb-1">Order #{{ order.id }}</h1>
                                <p class="text-text-body">{{ new Date(order.created_at).toLocaleString() }}</p>
                            </div>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold" :class="getStatusClass(order.status)">
                                {{ order.status }}
                            </span>
                        </div>

                        <div class="space-y-6">
                            <div v-for="item in order.items" :key="item.id" class="flex gap-4 pb-6 border-b last:border-0">
                                <img :src="item.product?.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=200&q=80'" 
                                     :alt="item.product?.name" class="w-20 h-20 object-cover rounded flex-shrink-0">
                                <div class="flex-1">
                                    <h3 class="font-medium mb-1">{{ item.product?.name || 'Product' }}</h3>
                                    <p class="text-sm text-text-body">Qty: {{ item.quantity }}</p>
                                </div>
                                <span class="font-semibold">₹{{ (item.price * item.quantity).toLocaleString() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h3 class="font-serif text-xl mb-4">Shipping Address</h3>
                        <p class="text-text-body">{{ order.shipping_address }}</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="font-serif text-xl mb-6">Order Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-text-body">Subtotal</span>
                            <span>₹{{ (order.total_amount / 1.18).toFixed(0).toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Shipping</span>
                            <span>₹150</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Tax (18% GST)</span>
                            <span>₹{{ (order.total_amount - (order.total_amount / 1.18)).toFixed(0).toLocaleString() }}</span>
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
                              :class="order.payment_status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
                            {{ order.payment_status }}
                        </span>
                    </div>
                    
                    <div v-if="order.status === 'delivered'" class="border-t pt-4 mt-4">
                        <Button label="Request Return" icon="pi pi-replay" class="w-full" 
                                @click="$inertia.visit(`/returns/create?order_id=${order.id}`)" />
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    order: Object
});

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
</script>
