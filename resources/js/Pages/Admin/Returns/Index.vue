<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Returns</h1>
            <p class="text-gray-500 mt-1">Manage return requests</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex gap-4">
                <div class="min-w-[150px]">
                    <Select v-model="statusFilter" :options="statusOptions" optionLabel="name" optionValue="value" 
                            placeholder="All Status" class="w-full" @change="applyFilters" />
                </div>
            </div>
        </div>
        
        <!-- Returns Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="returnItem in returns.data" :key="returnItem.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ getReturnReference(returnItem) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ getOrderReference(returnItem) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ returnItem.user?.name }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ returnItem.reason }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium" :class="getStatusClass(returnItem.status)">
                                {{ getStatusLabel(returnItem.status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ new Date(returnItem.created_at).toLocaleDateString() }}</td>
                        <td class="px-6 py-4">
                            <Link
                                :href="route('admin.returns.show', returnItem.id)"
                                class="inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-medium text-blue-600 hover:bg-blue-50 hover:text-blue-800"
                            >
                                <i class="pi pi-eye" aria-hidden="true"></i>
                                <span>View</span>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="px-6 py-4 border-t">
                <Paginator :rows="returns.per_page" :totalRecords="returns.total" @page="onPageChange" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Select from 'primevue/select';
import Paginator from 'primevue/paginator';

const props = defineProps({
    returns: Object,
    filters: Object
});

const statusFilter = ref(props.filters?.status || '');

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

const getOrderReference = (returnItem) => {
    return returnItem.order?.order_number || `#${returnItem.order_id}`;
};

const getReturnReference = (returnItem) => {
    return returnItem.return_number || `RET-${String(returnItem.id).padStart(6, '0')}`;
};

const applyFilters = () => {
    router.get(route('admin.returns.index'), {
        status: statusFilter.value
    }, { preserveState: true });
};

const onPageChange = (event) => {
    router.get(route('admin.returns.index'), {
        ...props.filters,
        page: event.page + 1
    }, { preserveState: true });
};
</script>
