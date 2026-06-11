<template>
    <div class="cart-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">Your Cart</h1>
            
            <div v-if="cartItems.length === 0" class="text-center py-16">
                <i class="pi pi-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <p class="text-text-body text-lg mb-6">Your cart is empty</p>
                <Button label="Continue Shopping" icon="pi pi-arrow-left" @click="$inertia.visit('/shop')" />
            </div>

            <div v-else class="grid md:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="md:col-span-2">
                    <div v-for="item in cartItems" :key="item.id" class="cart-item bg-white p-6 rounded-lg shadow-sm mb-4 flex gap-6">
                        <div class="w-24 h-24 flex-shrink-0">
                            <img v-if="item.product.images?.[0]?.url" :src="item.product.images[0].url" :alt="item.product.name" class="w-full h-full object-cover rounded">
                            <div v-else class="flex h-full w-full items-center justify-center rounded bg-gray-100 text-xs text-gray-500">No image</div>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="font-serif text-lg mb-1">{{ item.product.name }}</h3>
                            <p class="text-sm text-text-body mb-2">{{ item.product.fabric }}</p>
                            <p v-if="variantLabel(item)" class="text-sm text-text-body mb-2">Variant: {{ variantLabel(item) }}</p>
                            <span class="font-semibold text-primary">₹{{ itemPrice(item).toLocaleString() }}</span>
                        </div>

                        <div class="flex flex-col items-end gap-4">
                            <button class="text-red-500 hover:text-red-700" @click="removeItem(item.id)">
                                <i class="pi pi-trash"></i>
                            </button>
                            <InputNumber v-model="item.quantity" :min="1" :max="10" showButtons size="small" 
                                         @update:modelValue="updateQuantity(item)" />
                            <span class="font-semibold">₹{{ (itemPrice(item) * item.quantity).toLocaleString() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="font-serif text-xl mb-6">Order Summary</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-text-body">Subtotal</span>
                            <span>₹{{ subtotal.toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Shipping</span>
                            <span>₹{{ shipping.toLocaleString() }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="text-primary">₹{{ total.toLocaleString() }}</span>
                        </div>
                    </div>

                    <Button label="Proceed to Checkout" class="w-full" @click="$inertia.visit('/checkout')" />
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import InputNumber from 'primevue/inputnumber';

const props = defineProps({
    cartItems: Array
});

const subtotal = computed(() => {
    return props.cartItems.reduce((sum, item) => sum + (itemPrice(item) * item.quantity), 0);
});

const shipping = computed(() => {
    return 100;
});

const total = computed(() => {
    return subtotal.value + shipping.value;
});

const removeItem = (id) => {
    router.delete(`/cart/remove/${id}`);
};

const updateQuantity = (item) => {
    router.patch(`/cart/update/${item.id}`, { quantity: item.quantity });
};

const itemPrice = (item) => {
    return Number(item.variant?.price || item.product.discount_price || item.product.price);
};

const variantLabel = (item) => {
    if (!item.variant) {
        return '';
    }

    return [item.variant.size, item.variant.color].filter(Boolean).join(' / ');
};
</script>
