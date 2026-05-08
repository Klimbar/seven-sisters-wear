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
                            <h3 class="font-serif text-lg mb-1">Order #{{ order.id }}</h3>
                            <p class="text-sm text-text-body">{{ new Date(order.created_at).toLocaleDateString() }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold" 
                                  :class="getStatusClass(order.status)">
                                {{ order.status }}
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-4 mb-4">
                        <div v-for="item in order.items.slice(0, 3)" :key="item.id" class="w-16 h-16 flex-shrink-0">
                            <img :src="item.product?.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=200&q=80'" 
                                 :alt="item.product?.name" class="w-full h-full object-cover rounded">
                        </div>
                        <div v-if="order.items.length > 3" class="w-16 h-16 flex items-center justify-center bg-gray-100 rounded text-sm text-text-body">
                            +{{ order.items.length - 3 }}
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-sm text-text-body">{{ order.items.length }} item(s)</span>
                        <span class="font-bold text-lg text-primary">₹{{ order.total_amount.toLocaleString() }}</span>
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
        'confirmed': 'bg-blue-100 text-blue-800',
        'packed': 'bg-purple-100 text-purple-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
        'returned': 'bg-gray-100 text-gray-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const onPageChange = (event) => {
    router.get('/orders', { page: event.page + 1 }, { preserveState: true });
};
</script>
