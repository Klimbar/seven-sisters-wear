<template>
    <div class="return-create-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <Button label="Back to Order" text icon="pi pi-arrow-left" @click="$inertia.visit(`/orders/${order.id}`)" class="mb-6" />
            
            <div class="max-w-2xl mx-auto">
                <h1 class="font-serif text-3xl text-center mb-8">Request Return</h1>
                
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="font-semibold mb-4">Order {{ order.order_number }}</h3>
                    <div class="space-y-2 text-text-body">
                        <p>Total: <span class="font-semibold">₹{{ order.total_amount?.toLocaleString() }}</span></p>
                        <p>Status: <span class="capitalize">{{ order.status }}</span></p>
                    </div>
                </div>
                
                <form @submit.prevent="submitReturn" class="bg-white rounded-lg shadow-sm p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Reason for Return</label>
                        <Select v-model="form.reason" :options="reasons" class="w-full" required />
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Description</label>
                        <Textarea v-model="form.description" rows="4" class="w-full" placeholder="Please describe the issue in detail..." required />
                    </div>
                    
                    <div class="flex gap-4">
                        <Button type="submit" label="Submit Return Request" :loading="loading" />
                        <Button type="button" label="Cancel" severity="secondary" @click="$inertia.visit(`/orders/${order.id}`)" />
                    </div>
                </form>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';

const props = defineProps({
    order: Object
});

const loading = ref(false);
const form = ref({
    reason: '',
    description: ''
});

const reasons = [
    'Product damaged during shipping',
    'Wrong product received',
    'Product not as described',
    'Quality issue',
    'Changed mind',
    'Other'
];

const submitReturn = () => {
    loading.value = true;
    router.post('/returns', {
        order_id: props.order.id,
        reason: form.value.reason,
        description: form.value.description
    }, {
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>