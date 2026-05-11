<template>
    <div class="checkout-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">Checkout</h1>
            
            <div v-if="cartItems.length === 0" class="text-center py-16">
                <p class="text-text-body text-lg mb-6">Your cart is empty</p>
                <Button label="Continue Shopping" @click="$inertia.visit('/shop')" />
            </div>

            <div v-else class="grid md:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="md:col-span-2">
                    <form @submit.prevent="placeOrder">
                        <!-- Shipping Address -->
                        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                            <h3 class="font-serif text-xl mb-6">Shipping Address</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Address</label>
                                    <Textarea v-model="form.shipping_address" rows="3" class="w-full" required />
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                            <h3 class="font-serif text-xl mb-6">Payment Method</h3>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50" 
                                       :class="form.payment_method === 'cod' ? 'border-primary bg-primary/5' : ''">
                                    <RadioButton v-model="form.payment_method" inputId="cod" name="payment" value="cod" />
                                    <label for="cod" class="cursor-pointer flex-1">
                                        <span class="font-medium">Cash on Delivery</span>
                                        <p class="text-sm text-text-body">Pay when you receive the order</p>
                                    </label>
                                </label>

                                <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50"
                                       :class="form.payment_method === 'upi' ? 'border-primary bg-primary/5' : ''">
                                    <RadioButton v-model="form.payment_method" inputId="upi" name="payment" value="upi" />
                                    <label for="upi" class="cursor-pointer flex-1">
                                        <span class="font-medium">UPI</span>
                                        <p class="text-sm text-text-body">Pay via UPI (GPay, PhonePe, etc.)</p>
                                    </label>
                                </label>

                                <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50"
                                       :class="form.payment_method === 'card' ? 'border-primary bg-primary/5' : ''">
                                    <RadioButton v-model="form.payment_method" inputId="card" name="payment" value="card" />
                                    <label for="card" class="cursor-pointer flex-1">
                                        <span class="font-medium">Credit/Debit Card</span>
                                        <p class="text-sm text-text-body">Pay securely with your card</p>
                                    </label>
                                </label>
                            </div>
                        </div>

                        <Button type="submit" label="Place Order" class="w-full" :loading="loading" />
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="order-summary bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="font-serif text-xl mb-6">Order Summary</h3>

                    <!-- Coupon Input -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div v-if="appliedDiscount > 0" class="flex justify-between items-center">
                            <div>
                                <span class="text-sm text-text-body">Coupon Applied:</span>
                                <span class="font-semibold text-green-600 ml-2">{{ couponCode }}</span>
                            </div>
                            <button @click="removeCoupon" class="text-red-500 text-sm hover:underline">Remove</button>
                        </div>
                        <div v-else class="flex gap-2">
                            <InputText v-model="form.coupon_code" placeholder="Enter coupon code" class="flex-1" />
                            <Button label="Apply" @click="applyCoupon" size="small" />
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div v-for="item in cartItems" :key="item.id" class="flex gap-4">
                            <img :src="item.product.images?.[0]?.url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=200&q=80'"
                                 :alt="item.product.name" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium">{{ item.product.name }}</h4>
                                <p class="text-xs text-text-body">Qty: {{ item.quantity }}</p>
                            </div>
                            <span class="text-sm font-semibold">₹{{ (item.product.price * item.quantity).toLocaleString() }}</span>
                        </div>
                    </div>

                    <Divider />

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-text-body">Subtotal</span>
                            <span>₹{{ calculatedSubtotal.toLocaleString() }}</span>
                        </div>
                        <div v-if="appliedDiscount > 0" class="flex justify-between text-green-600">
                            <span class="text-text-body">Discount</span>
                            <span>-₹{{ appliedDiscount.toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Shipping</span>
                            <span>₹{{ shipping.toLocaleString() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-text-body">Tax (18% GST)</span>
                            <span>₹{{ tax.toLocaleString() }}</span>
                        </div>
                        <Divider />
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span class="text-primary">₹{{ total.toLocaleString() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import Button from 'primevue/button';
import Textarea from 'primevue/textarea';
import RadioButton from 'primevue/radiobutton';
import Divider from 'primevue/divider';
import InputText from 'primevue/inputtext';

const props = defineProps({
    cartItems: Array,
    subtotal: Number,
    discount: Number,
    coupon: Object,
    couponCode: String
});

const loading = ref(false);
const appliedDiscount = ref(props.discount || 0);

const form = ref({
    shipping_address: '',
    payment_method: 'cod',
    coupon_code: props.couponCode || ''
});

const calculatedSubtotal = computed(() => {
    if (props.subtotal !== undefined) {
        return props.subtotal;
    }
    return props.cartItems.reduce((sum, item) => {
        const price = item.variant_id ? (item.product.variants?.find(v => v.id === item.variant_id)?.price || item.product.price) : item.product.price;
        return sum + (price * item.quantity);
    }, 0);
});

const shipping = computed(() => {
    return calculatedSubtotal.value > 2000 ? 0 : 150;
});

const tax = computed(() => {
    return Math.round((calculatedSubtotal.value - appliedDiscount.value) * 0.18);
});

const total = computed(() => {
    return calculatedSubtotal.value + shipping.value + tax.value - appliedDiscount.value;
});

const applyCoupon = () => {
    if (!form.value.coupon_code) return;
    router.get('/checkout', { coupon_code: form.value.coupon_code }, {
        preserveState: true,
        onSuccess: (page) => {
            if (page.props.discount) {
                appliedDiscount.value = page.props.discount;
            }
        }
    });
};

const removeCoupon = () => {
    appliedDiscount.value = 0;
    form.value.coupon_code = '';
    router.get('/checkout', {}, { preserveState: true });
};

const placeOrder = () => {
    loading.value = true;
    router.post('/orders', form.value, {
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>
