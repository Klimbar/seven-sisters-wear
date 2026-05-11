<template>
    <div class="returns-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">My Returns</h1>
            
            <div v-if="returns.data.length === 0" class="text-center py-16">
                <i class="pi pi-replay text-6xl text-gray-300 mb-4"></i>
                <p class="text-text-body text-lg mb-6">No return requests yet</p>
                <Button label="Go to Orders" @click="$inertia.visit('/orders')" />
            </div>
            
            <div v-else class="space-y-6">
                <div v-for="returnItem in returns.data" :key="returnItem.id" 
                     class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-serif text-lg mb-1">Return Request #{{ returnItem.id }}</h3>
                            <p class="text-sm text-text-body">Order #{{ returnItem.order_id }} • {{ new Date(returnItem.created_at).toLocaleDateString() }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium" :class="getStatusClass(returnItem.status)">
                            {{ returnItem.status }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center pt-4 border-t">
                        <span class="text-sm text-text-body">Reason: {{ returnItem.reason }}</span>
                        <Button label="View Details" text @click="$inertia.visit(`/returns/${returnItem.id}`)" />
                    </div>
                </div>
                
                <div class="mt-8 flex justify-center">
                    <Paginator :rows="returns.per_page" :totalRecords="returns.total" @page="onPageChange" />
                </div>
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
    returns: Object
});

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'approved': 'bg-blue-100 text-blue-800',
        'rejected': 'bg-red-100 text-red-800',
        'refunded': 'bg-green-100 text-green-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const onPageChange = (event) => {
    router.get('/returns', { page: event.page + 1 }, { preserveState: true });
};
</script>