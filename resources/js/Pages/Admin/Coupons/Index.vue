<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Coupons</h1>
            <p class="text-gray-500 mt-1">Manage discount coupons</p>
        </div>

        <!-- Add Coupon Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="font-serif text-xl text-gray-900 mb-4">Add New Coupon</h2>
            <form @submit.prevent="storeCoupon" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code *</label>
                    <InputText v-model="form.code" class="w-full" placeholder="e.g., SAVE20" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <Select v-model="form.type" :options="typeOptions" optionLabel="name" optionValue="value" class="w-full" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Value *</label>
                    <InputNumber v-model="form.value" class="w-full" :min="0" required />
                </div>
                <div class="flex items-end">
                    <Button type="submit" label="Add Coupon" :loading="loading" class="w-full" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Order (₹)</label>
                    <InputNumber v-model="form.min_order_amount" class="w-full" :min="0" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                    <DatePicker v-model="form.expiry_date" class="w-full" dateFormat="yy-mm-dd" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Usage Limit</label>
                    <InputNumber v-model="form.usage_limit" class="w-full" :min="1" />
                </div>
                <div class="flex items-end">
                    <Checkbox v-model="form.is_active" :binary="true" inputId="active" />
                    <label for="active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>
            </form>
        </div>

        <!-- Coupons Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="coupon in coupons.data" :key="coupon.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-mono font-semibold text-gray-900">{{ coupon.code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium"
                                  :class="coupon.type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'">
                                {{ coupon.type === 'percentage' ? 'Percentage' : 'Fixed' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium">
                            {{ coupon.type === 'percentage' ? coupon.value + '%' : '₹' + coupon.value }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            ₹{{ coupon.min_order_amount || 0 }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900">{{ coupon.usage_count || 0 }}</span>
                            <span v-if="coupon.usage_limit" class="text-gray-500"> / {{ coupon.usage_limit }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ coupon.expiry_date ? formatDate(coupon.expiry_date) : 'No expiry' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium"
                                  :class="coupon.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                {{ coupon.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <Button icon="pi pi-pencil" size="small" text @click="openEditModal(coupon)" />
                                <Button icon="pi pi-trash" size="small" text severity="danger" @click="deleteCoupon(coupon)" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="coupons.data.length === 0" class="p-8 text-center text-gray-500">
                No coupons found. Add one above.
            </div>
        </div>

        <!-- Edit Coupon Dialog -->
        <Dialog v-model:visible="editDialogVisible" header="Edit Coupon" :modal="true" class="w-[500px]">
            <form @submit.prevent="updateCoupon">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                        <InputText v-model="editForm.code" class="w-full" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <Select v-model="editForm.type" :options="typeOptions" optionLabel="name" optionValue="value" class="w-full" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                            <InputNumber v-model="editForm.value" class="w-full" :min="0" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Min Order (₹)</label>
                            <InputNumber v-model="editForm.min_order_amount" class="w-full" :min="0" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Usage Limit</label>
                            <InputNumber v-model="editForm.usage_limit" class="w-full" :min="1" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                        <DatePicker v-model="editForm.expiry_date" class="w-full" dateFormat="yy-mm-dd" />
                    </div>
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="editForm.is_active" :binary="true" inputId="editActive" />
                        <label for="editActive" class="text-sm text-gray-700">Active</label>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <Button type="button" label="Cancel" severity="secondary" @click="editDialogVisible = false" />
                    <Button type="submit" label="Update" :loading="updateLoading" />
                </div>
            </form>
        </Dialog>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Select from 'primevue/select';
import DatePicker from 'primevue/datepicker';
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

const props = defineProps({
    coupons: Object
});

const loading = ref(false);
const updateLoading = ref(false);
const editDialogVisible = ref(false);
const selectedCoupon = ref(null);

const typeOptions = [
    { name: 'Percentage (%)', value: 'percentage' },
    { name: 'Fixed Amount (₹)', value: 'fixed' }
];

const form = ref({
    code: '',
    type: 'percentage',
    value: null,
    min_order_amount: null,
    expiry_date: null,
    usage_limit: null,
    is_active: true
});

const editForm = ref({
    code: '',
    type: 'percentage',
    value: null,
    min_order_amount: null,
    expiry_date: null,
    usage_limit: null,
    is_active: true
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-IN');
};

const storeCoupon = () => {
    loading.value = true;
    router.post(route('admin.coupons.store'), form.value, {
        preserveState: true,
        onSuccess: () => {
            form.value = {
                code: '',
                type: 'percentage',
                value: null,
                min_order_amount: null,
                expiry_date: null,
                usage_limit: null,
                is_active: true
            };
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};

const openEditModal = (coupon) => {
    selectedCoupon.value = coupon;
    editForm.value = {
        code: coupon.code,
        type: coupon.type,
        value: coupon.value,
        min_order_amount: coupon.min_order_amount,
        expiry_date: coupon.expiry_date ? new Date(coupon.expiry_date) : null,
        usage_limit: coupon.usage_limit,
        is_active: coupon.is_active
    };
    editDialogVisible.value = true;
};

const updateCoupon = () => {
    if (!selectedCoupon.value) return;

    updateLoading.value = true;
    router.patch(route('admin.coupons.update', selectedCoupon.value.id), editForm.value, {
        preserveState: true,
        onFinish: () => {
            updateLoading.value = false;
            editDialogVisible.value = false;
        }
    });
};

const deleteCoupon = (coupon) => {
    if (!confirm(`Delete coupon "${coupon.code}"?`)) return;

    router.delete(route('admin.coupons.destroy', coupon.id), {
        preserveState: true
    });
};
</script>