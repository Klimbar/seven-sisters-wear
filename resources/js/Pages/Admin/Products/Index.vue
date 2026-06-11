<template>
    <AdminLayout>
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-serif text-3xl text-gray-900">Products</h1>
                <p class="text-gray-500 mt-1">Manage your product inventory</p>
            </div>
            <Link :href="route('admin.products.create')" 
                  class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-opacity-90 flex items-center gap-2">
                <i class="pi pi-plus"></i>
                Add Product
            </Link>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <InputText v-model="search" placeholder="Search products..." class="w-full" @input="applyFilters" />
                </div>
                <div class="min-w-[150px]">
                    <Select v-model="statusFilter" :options="statusOptions" optionLabel="name" optionValue="value" 
                            placeholder="All Status" class="w-full" @change="applyFilters" />
                </div>
                <div class="min-w-[150px]">
                    <Select v-model="categoryFilter" :options="categories" optionLabel="name" optionValue="slug" 
                            placeholder="All Categories" class="w-full" @change="applyFilters" />
                </div>
            </div>
        </div>
        
        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    <img v-if="product.images?.[0]?.url" :src="product.images[0].url" class="w-full h-full object-cover">
                                    <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ product.name }}</p>
                                    <p class="text-sm text-gray-500">{{ product.fabric }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ product.category?.name || '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold">₹{{ (product.discount_price || product.price)?.toLocaleString() }}</span>
                            <span v-if="product.discount_price" class="text-sm text-gray-400 line-through ml-2">
                                ₹{{ product.price?.toLocaleString() }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span :class="product.stock < 5 ? 'text-red-600 font-semibold' : 'text-gray-600'">
                                {{ product.stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium"
                                  :class="product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                {{ product.status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <Link :href="route('admin.products.edit', product.id)" 
                                      class="text-blue-600 hover:text-blue-800">
                                    <i class="pi pi-pencil"></i>
                                </Link>
                                <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-800">
                                    <i class="pi pi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                <Paginator :rows="products.per_page" :totalRecords="products.total" 
                           @page="onPageChange" />
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
    products: Object,
    categories: Array,
    filters: Object
});

const search = ref(props.filters?.search || '');
const statusFilter = ref(props.filters?.status || '');
const categoryFilter = ref(props.filters?.category || '');

const statusOptions = [
    { name: 'Active', value: 'active' },
    { name: 'Inactive', value: 'inactive' }
];

const applyFilters = () => {
    router.get(route('admin.products.index'), {
        search: search.value,
        status: statusFilter.value,
        category: categoryFilter.value
    }, { preserveState: true });
};

const onPageChange = (event) => {
    router.get(route('admin.products.index'), {
        ...props.filters,
        page: event.page + 1
    }, { preserveState: true });
};

const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('admin.products.destroy', id));
    }
};
</script>
