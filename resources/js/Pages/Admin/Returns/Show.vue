<template>
    <AdminLayout>
        <div class="mb-8">
            <Link :href="route('admin.returns.index')" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 mb-4">
                <i class="pi pi-arrow-left"></i>
                Back to Returns
            </Link>
            <h1 class="font-serif text-3xl text-gray-900">Return {{ getReturnReference(returnRequest) }}</h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Return Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Return Details</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Reason</p>
                            <p class="font-medium">{{ returnRequest.reason }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="px-2 py-1 rounded-full text-xs font-medium" :class="getStatusClass(returnRequest.status)">
                                {{ getStatusLabel(returnRequest.status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <p class="text-text-body">{{ returnRequest.description }}</p>
                    </div>
                </div>

                <!-- Return Processing Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Processing Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Pickup Address</p>
                            <p class="font-medium whitespace-pre-line">{{ returnRequest.pickup_address || 'Not added' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tracking Number</p>
                            <p class="font-medium">{{ returnRequest.tracking_number || 'Not added' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Pickup Date</p>
                            <p class="font-medium">{{ formatDate(returnRequest.pickup_date) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Refund Date</p>
                            <p class="font-medium">{{ formatDate(returnRequest.refund_date) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Refund Amount</p>
                            <p class="font-medium">{{ returnRequest.refund_amount ? `₹${Number(returnRequest.refund_amount).toLocaleString()}` : 'Not set' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Items</h3>
                    <div class="space-y-4">
                        <div v-for="item in returnRequest.order?.items" :key="item.id" class="flex gap-4 pb-4 border-b last:border-0">
                            <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden">
                                <img v-if="item.product?.images?.[0]?.url" :src="item.product.images[0].url" class="w-full h-full object-cover">
                                <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ item.product?.name }}</p>
                                <p v-if="item.variant" class="text-xs text-gray-500">
                                    {{ [item.variant.size, item.variant.color].filter(Boolean).join(' / ') }}
                                </p>
                                <p class="text-sm text-gray-500">Qty: {{ item.quantity }} × ₹{{ item.price?.toLocaleString() }}</p>
                            </div>
                            <div class="font-semibold">₹{{ (item.quantity * item.price)?.toLocaleString() }}</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t flex justify-between font-semibold">
                        <span>Order Total</span>
                        <span>₹{{ returnRequest.order?.total_amount?.toLocaleString() }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Customer</h3>
                    <p class="font-medium">{{ returnRequest.user?.name }}</p>
                    <p class="text-gray-500">{{ returnRequest.user?.email }}</p>
                </div>
                
                <!-- Update Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-semibold text-lg mb-4">Process Return</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <Select v-model="form.status" :options="statusOptions" optionLabel="name" optionValue="value" class="w-full" />
                        </div>
                        
                        <div v-if="form.status !== 'pending' && form.status !== 'rejected'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Refund Amount (₹)</label>
                            <InputNumber v-model="form.refund_amount" mode="currency" currency="INR" class="w-full" />
                        </div>

                        <div v-if="form.status !== 'pending' && form.status !== 'rejected'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Address</label>
                            <Textarea v-model="form.pickup_address" rows="3" class="w-full" />
                        </div>

                        <div v-if="['picked_up', 'in_transit', 'received', 'refunded'].includes(form.status)">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tracking Number</label>
                            <InputText v-model="form.tracking_number" class="w-full" />
                        </div>

                        <div v-if="['approved', 'picked_up', 'in_transit', 'received', 'refunded'].includes(form.status)">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Date</label>
                            <input v-model="form.pickup_date" type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                        </div>

                        <div v-if="form.status === 'refunded'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Refund Date</label>
                            <input v-model="form.refund_date" type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <Textarea v-model="form.admin_notes" rows="3" class="w-full" />
                        </div>
                        
                        <Button label="Update Return" class="w-full" @click="updateStatus" :loading="updating" />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Select from 'primevue/select';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';

const props = defineProps({
    returnRequest: Object
});

const updating = ref(false);
const form = ref({
    status: props.returnRequest.status,
    refund_amount: props.returnRequest.refund_amount || props.returnRequest.order?.total_amount,
    admin_notes: props.returnRequest.admin_notes || '',
    pickup_address: props.returnRequest.pickup_address || '',
    tracking_number: props.returnRequest.tracking_number || '',
    pickup_date: toDateInput(props.returnRequest.pickup_date),
    refund_date: toDateInput(props.returnRequest.refund_date)
});

const statusOptions = [
    { name: 'Pending', value: 'pending' },
    { name: 'Approved', value: 'approved' },
    { name: 'Picked Up', value: 'picked_up' },
    { name: 'In Transit', value: 'in_transit' },
    { name: 'Received', value: 'received' },
    { name: 'Rejected', value: 'rejected' },
    { name: 'Refunded', value: 'refunded' }
];

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'approved': 'bg-blue-100 text-blue-800',
        'picked_up': 'bg-indigo-100 text-indigo-800',
        'in_transit': 'bg-purple-100 text-purple-800',
        'received': 'bg-teal-100 text-teal-800',
        'rejected': 'bg-red-100 text-red-800',
        'refunded': 'bg-green-100 text-green-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
    const labels = {
        'pending': 'Pending',
        'approved': 'Approved',
        'picked_up': 'Picked Up',
        'in_transit': 'In Transit',
        'received': 'Received',
        'rejected': 'Rejected',
        'refunded': 'Refunded'
    };
    return labels[status] || status;
};

const getReturnReference = (returnRequest) => {
    return returnRequest.return_number || `RET-${String(returnRequest.id).padStart(6, '0')}`;
};

function toDateInput(value) {
    if (!value) return '';
    return new Date(value).toISOString().slice(0, 10);
}

const formatDate = (value) => {
    if (!value) return 'Not set';
    return new Date(value).toLocaleDateString();
};

const updateStatus = () => {
    updating.value = true;
    router.patch(route('admin.returns.update', props.returnRequest.id), form.value, {
        preserveState: true,
        onFinish: () => {
            updating.value = false;
        }
    });
};
</script>
