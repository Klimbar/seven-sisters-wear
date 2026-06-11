<template>
    <AdminLayout>
        <div class="mb-8">
            <Link :href="route('admin.products.index')" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
                <i class="pi pi-arrow-left"></i>
                Back to Products
            </Link>
            <h1 class="font-serif text-3xl text-gray-900">Edit Product</h1>
        </div>
        
        <form @submit.prevent="submitForm" class="bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <InputText v-model="form.name" class="w-full" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fabric</label>
                    <InputText v-model="form.fabric" class="w-full" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹)</label>
                    <InputNumber v-model="form.price" class="w-full" mode="currency" currency="INR" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount Price (₹)</label>
                    <InputNumber v-model="form.discount_price" class="w-full" mode="currency" currency="INR" />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                    <InputNumber v-model="form.stock" class="w-full" :min="0" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Occasion</label>
                    <Select v-model="form.occasion" :options="occasions" class="w-full" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <Select v-model="form.category_id" :options="categories" optionLabel="name" optionValue="id" class="w-full" required />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tribe</label>
                    <Select v-model="form.tribe_id" :options="tribes" optionLabel="name" optionValue="id" class="w-full" />
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <Select v-model="form.status" :options="statusOptions" optionLabel="name" optionValue="value" class="w-full" required />
                </div>
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <Textarea v-model="form.description" rows="4" class="w-full" required />
            </div>
            
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Primary Product Image</label>
                <input type="file" accept="image/*" class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-primary file:px-4 file:py-2 file:text-white hover:file:bg-opacity-90" @change="handlePrimaryImageChange" />
                <p class="text-sm text-gray-500 mt-1">Upload a new file only if you want to replace the card/default image.</p>
                <div v-if="primaryImagePreview" class="mt-3 h-32 w-32 overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                    <img :src="primaryImagePreview.url" alt="Primary product preview" class="h-full w-full object-cover">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Images</label>
                <input type="file" accept="image/*" multiple class="block w-full text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-700 file:px-4 file:py-2 file:text-white hover:file:bg-gray-800" @change="handleAdditionalImagesChange" />
                <p class="text-sm text-gray-500 mt-1">Select multiple files to add more gallery images. You can delete saved gallery images below.</p>
                <div v-if="existingAdditionalImages.length" class="mt-3">
                    <p class="mb-2 text-sm font-medium text-gray-700">Saved gallery images</p>
                    <div class="flex flex-wrap gap-3">
                        <div v-for="image in existingAdditionalImages" :key="image.id" class="relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                            <img :src="image.url" alt="Saved additional product image" class="h-24 w-24 object-contain">
                            <button
                                type="button"
                                class="absolute right-1 top-1 rounded bg-white/90 px-2 py-1 text-xs font-medium text-red-600 shadow hover:bg-white"
                                @click="deleteAdditionalImage(image.id)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="additionalImagePreviews.length" class="mt-3">
                    <p class="mb-2 text-sm font-medium text-gray-700">New selected images</p>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 md:grid-cols-6">
                        <div v-for="(preview, index) in additionalImagePreviews" :key="preview.url" class="relative overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                            <img :src="preview.url" :alt="`Additional product preview ${index + 1}`" class="h-24 w-full object-contain">
                            <button
                                type="button"
                                class="absolute right-1 top-1 rounded bg-white/90 px-2 py-1 text-xs font-medium text-red-600 shadow hover:bg-white"
                                @click="removeAdditionalImage(index)"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants Section -->
            <div class="mt-8 pt-6 border-t">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-serif text-xl text-gray-900">Product Variants</h3>
                    <Button type="button" label="Add Variant" icon="pi pi-plus" size="small" @click="addVariant" />
                </div>

                <div v-if="variants.length > 0" class="space-y-4">
                    <div v-for="(variant, index) in variants" :key="index" class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start mb-4">
                            <span class="font-medium text-gray-700">Variant {{ index + 1 }}</span>
                            <Button type="button" icon="pi pi-trash" severity="danger" size="small" text @click="removeVariant(index)" />
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                <InputText v-model="variant.size" class="w-full" placeholder="e.g., S, M, L" />
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
                <p v-else class="text-gray-500 text-sm">No variants. Add variants to support size/color options.</p>
            </div>

            <div class="mt-8 flex gap-4">
                <Button type="submit" label="Update Product" :loading="loading" />
                <Button type="button" label="Cancel" severity="secondary" @click="$inertia.visit(route('admin.products.index'))" />
            </div>
        </form>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';

const props = defineProps({
    product: Object,
    categories: Array,
    tribes: Array,
    states: Array
});

const loading = ref(false);
const primaryImage = ref(null);
const primaryImagePreview = ref(null);
const additionalImages = ref([]);
const additionalImagePreviews = ref([]);
const existingAdditionalImages = ref([]);
const variants = ref([]);

onMounted(() => {
    if (props.product) {
        form.value = { ...props.product };
        const existingPrimaryImage = props.product.images?.find(img => img.is_primary) || props.product.images?.[0] || null;
        primaryImagePreview.value = existingPrimaryImage ? {
            name: existingPrimaryImage.image_path,
            url: existingPrimaryImage.url
        } : null;
        existingAdditionalImages.value = props.product.images?.filter(img => !img.is_primary) || [];
        variants.value = props.product.variants?.map(v => ({
            id: v.id,
            size: v.size,
            color: v.color,
            price: v.price,
            stock: v.stock
        })) || [];
    }
});

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
    tribe_id: null
});

const occasions = ['Wedding', 'Festival', 'Daily Wear', 'Ceremonial'];

const statusOptions = [
    { name: 'Active', value: 'active' },
    { name: 'Inactive', value: 'inactive' }
];

const addVariant = () => {
    variants.value.push({
        size: '',
        color: '',
        price: form.value.price,
        stock: 0
    });
};

const removeVariant = (index) => {
    variants.value.splice(index, 1);
};

const handlePrimaryImageChange = (event) => {
    const file = event.target.files?.[0] || null;

    if (primaryImagePreview.value?.url?.startsWith('blob:')) {
        URL.revokeObjectURL(primaryImagePreview.value.url);
    }

    primaryImage.value = file;
    primaryImagePreview.value = file ? {
        name: file.name,
        url: URL.createObjectURL(file)
    } : primaryImagePreview.value;
};

const handleAdditionalImagesChange = (event) => {
    const selectedFiles = Array.from(event.target.files || []);

    additionalImages.value = [...additionalImages.value, ...selectedFiles];
    additionalImagePreviews.value = [
        ...additionalImagePreviews.value,
        ...selectedFiles.map((file) => ({
            name: file.name,
            url: URL.createObjectURL(file)
        }))
    ];
    event.target.value = '';
};

const removeAdditionalImage = (index) => {
    URL.revokeObjectURL(additionalImagePreviews.value[index].url);
    additionalImagePreviews.value.splice(index, 1);
    additionalImages.value.splice(index, 1);
};

const deleteAdditionalImage = (imageId) => {
    if (!confirm('Delete this gallery image?')) {
        return;
    }

    router.delete(route('admin.products.images.destroy', [props.product.id, imageId]), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            existingAdditionalImages.value = existingAdditionalImages.value.filter(image => image.id !== imageId);
        }
    });
};

const submitForm = () => {
    loading.value = true;

    const filteredVariants = variants.value.filter(v => v.size || v.color).map(v => ({
        id: v.id || null,
        size: v.size,
        color: v.color,
        price: v.price || form.value.price,
        stock: v.stock || 0
    }));

    router.post(route('admin.products.update', props.product.id), {
        ...form.value,
        _method: 'patch',
        primary_image: primaryImage.value,
        additional_images: additionalImages.value,
        variants: filteredVariants
    }, {
        forceFormData: true,
        preserveState: true,
        onFinish: () => {
            loading.value = false;
        }
    });
};
</script>
