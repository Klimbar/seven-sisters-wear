<template>
    <AdminLayout>
        <div class="mb-8">
            <Link :href="route('admin.products.index')" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
                <i class="pi pi-arrow-left"></i>
                Back to Products
            </Link>
            <h1 class="font-serif text-3xl text-gray-900">Add New Product</h1>
        </div>

        <form @submit.prevent="submitForm" class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <InputText v-model="form.name" class="w-full" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fabric *</label>
                    <InputText v-model="form.fabric" class="w-full" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                    <InputNumber v-model="form.price" class="w-full" mode="currency" currency="INR" locale="en-IN" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount Price (₹)</label>
                    <InputNumber v-model="form.discount_price" class="w-full" mode="currency" currency="INR" locale="en-IN" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                    <InputNumber v-model="form.stock" class="w-full" :min="0" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Occasion *</label>
                    <Select v-model="form.occasion" :options="occasions" placeholder="Select occasion" class="w-full" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <Select v-model="form.category_id" :options="categories" optionLabel="name" optionValue="id" placeholder="Select category" class="w-full" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tribe</label>
                    <Select v-model="form.tribe_id" :options="tribes" optionLabel="name" optionValue="id" placeholder="Select tribe" class="w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <Select v-model="form.status" :options="statusOptions" optionLabel="name" optionValue="value" class="w-full" required />
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <Textarea v-model="form.description" rows="4" class="w-full" required />
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Image URLs (one per line) *</label>
                <Textarea v-model="imageUrlsInput" rows="4" class="w-full" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg" />
                <p class="text-sm text-gray-500 mt-1">Enter full image URLs, one per line</p>
            </div>

            <!-- Variants Section -->
            <div class="mt-8 pt-6 border-t">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-serif text-xl text-gray-900">Product Variants (Optional)</h3>
                    <Button type="button" label="Add Variant" icon="pi pi-plus" size="small" @click="addVariant" />
                </div>

                <div v-if="form.variants.length > 0" class="space-y-4">
                    <div v-for="(variant, index) in form.variants" :key="index" class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-medium text-gray-700">Variant {{ index + 1 }}</span>
                            <Button type="button" icon="pi pi-trash" severity="danger" size="small" text @click="removeVariant(index)" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                <InputText v-model="variant.size" class="w-full" placeholder="e.g., S, M, L, XL" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                <InputText v-model="variant.color" class="w-full" placeholder="e.g., Red, Blue" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price (₹)</label>
                                <InputNumber v-model="variant.price" class="w-full" mode="currency" currency="INR" locale="en-IN" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                                <InputNumber v-model="variant.stock" class="w-full" :min="0" />
                            </div>
                        </div>
                    </div>
                </div>
                <p v-else class="text-gray-500 text-sm">No variants added. Leave empty if product has no size/color options.</p>
            </div>

            <div class="mt-8 flex gap-4">
                <Button type="submit" label="Create Product" :loading="loading" />
                <Button type="button" label="Cancel" severity="secondary" @click="$inertia.visit(route('admin.products.index'))" />
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';

const props = defineProps({
    categories: Array,
    tribes: Array,
    states: Array
});

const loading = ref(false);
const imageUrlsInput = ref('');

const form = ref({
    name: '',
    description: '',
    price: null,
    discount_price: null,
    stock: 0,
    fabric: '',
    occasion: '',
    status: 'active',
    category_id: null,
    tribe_id: null,
    variants: []
});

const occasions = ['Wedding', 'Festival', 'Daily Wear', 'Ceremonial'];

const statusOptions = [
    { name: 'Active', value: 'active' },
    { name: 'Inactive', value: 'inactive' }
];

const addVariant = () => {
    form.value.variants.push({
        size: '',
        color: '',
        price: null,
        stock: 0
    });
};

const removeVariant = (index) => {
    form.value.variants.splice(index, 1);
};

const submitForm = () => {
    loading.value = true;

    const imageUrls = imageUrlsInput.value
        .split('\n')
        .map(url => url.trim())
        .filter(url => url.length > 0);

    // Filter out empty variants
    const variants = form.value.variants.filter(v => v.size || v.color).map(v => ({
        size: v.size,
        color: v.color,
        price: v.price || form.value.price,
        stock: v.stock || 0
    }));

    router.post(route('admin.products.store'), {
        ...form.value,
        image_urls: imageUrls,
        variants: variants
    }, {
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>