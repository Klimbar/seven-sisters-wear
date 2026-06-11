<template>
    <div class="checkout-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <h1 class="font-serif text-4xl text-center mb-12">Checkout</h1>

            <!-- Flash Messages -->
            <div v-if="$page.props.flash?.error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.error }}
            </div>
            <div v-if="$page.props.flash?.warning" class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.warning }}
            </div>
            <div v-if="$page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ $page.props.flash.success }}
            </div>

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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Full Name <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.full_name" class="w-full" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Phone Number <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.phone" type="tel" class="w-full" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Address Line 1 <span class="text-red-500">*</span></label>
                                    <Textarea v-model="form.address_line1" rows="3" class="w-full" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Address Line 2 <span class="text-text-body font-normal">(Optional)</span></label>
                                    <InputText v-model="form.address_line2" class="w-full" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">City <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.city" class="w-full" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">District</label>
                                    <InputText v-model="form.district" class="w-full" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">State <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.state" class="w-full" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Pincode <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.pincode" class="w-full" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium mb-2">Country <span class="text-red-500">*</span></label>
                                    <InputText v-model="form.country" class="w-full" required />
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
                            <img v-if="item.product.images?.[0]?.url" :src="item.product.images[0].url" :alt="item.product.name" class="w-16 h-16 object-cover rounded">
                            <div v-else class="flex h-16 w-16 items-center justify-center rounded bg-gray-100 text-xs text-gray-500">No image</div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium">{{ item.product.name }}</h4>
                                <p v-if="variantLabel(item)" class="text-xs text-text-body">Variant: {{ variantLabel(item) }}</p>
                                <p class="text-xs text-text-body">Qty: {{ item.quantity }}</p>
                            </div>
                            <span class="text-sm font-semibold">₹{{ (itemPrice(item) * item.quantity).toLocaleString() }}</span>
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
    shipping: Number,
    discount: Number,
    coupon: Object,
    couponCode: String
});

const loading = ref(false);
const appliedDiscount = ref(props.discount || 0);

const form = ref({
    full_name: '',
    phone: '',
    address_line1: '',
    address_line2: '',
    city: '',
    district: '',
    state: '',
    pincode: '',
    country: 'India',
    payment_method: 'cod',
    coupon_code: props.couponCode || ''
});

const calculatedSubtotal = computed(() => {
    if (props.subtotal !== undefined) {
        return props.subtotal;
    }
    return props.cartItems.reduce((sum, item) => {
        return sum + (itemPrice(item) * item.quantity);
    }, 0);
});

const shipping = computed(() => {
    return props.shipping ?? 100;
});

const total = computed(() => {
    return calculatedSubtotal.value + shipping.value - appliedDiscount.value;
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
        preserveState: true,
        onFinish: () => {
            loading.value = false;
        }
    });
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
