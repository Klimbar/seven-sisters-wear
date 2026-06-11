<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Orders</h1>
            <p class="text-gray-500 mt-1">Manage and track customer orders</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <InputText v-model="search" placeholder="Search by Order Number..." class="w-full" @input="applyFilters" />
                </div>
                <div class="min-w-[150px]">
                    <Select v-model="statusFilter" :options="statusOptions" optionLabel="name" optionValue="value" 
                            placeholder="All Status" class="w-full" @change="applyFilters" />
                </div>
            </div>
        </div>
        
        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ order.order_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ order.user?.name || 'Guest' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ order.items?.length || 0 }} items</td>
                        <td class="px-6 py-4 font-semibold">₹{{ order.total_amount?.toLocaleString() }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium" :class="getStatusClass(order.status)">
                                {{ order.status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ new Date(order.created_at).toLocaleDateString() }}</td>
                        <td class="px-6 py-4">
                            <Link
                                :href="route('admin.orders.show', order.id)"
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
                <Paginator :rows="orders.per_page" :totalRecords="orders.total" @page="onPageChange" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Paginator from 'primevue/paginator';

const props = defineProps({
    orders: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');

const statusOptions = [
    { name: 'Pending', value: 'pending' },
    { name: 'Processing', value: 'processing' },
    { name: 'Shipped', value: 'shipped' },
    { name: 'Delivered', value: 'delivered' },
    { name: 'Cancelled', value: 'cancelled' },
    { name: 'Returned', value: 'returned' }
];

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'processing': 'bg-blue-100 text-blue-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
        'returned': 'bg-purple-100 text-purple-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const applyFilters = () => {
    router.get(route('admin.orders.index'), {
        search: search.value,
        status: statusFilter.value
    }, { preserveState: true });
};

const onPageChange = (event) => {
    router.get(route('admin.orders.index'), {
        ...props.filters,
        page: event.page + 1
    }, { preserveState: true });
};
</script>
