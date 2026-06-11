<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Reports</h1>
            <p class="text-gray-500 mt-1">Analytics and insights</p>
        </div>
        
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">₹{{ totalRevenue?.toLocaleString() || 0 }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ totalOrders }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Avg Order Value</p>
                <p class="text-3xl font-bold text-gray-900">₹{{ Math.round(averageOrderValue)?.toLocaleString() || 0 }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Orders by Status -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-lg mb-4">Orders by Status</h3>
                <div class="space-y-3">
                    <div v-for="item in ordersByStatus" :key="item.status" class="flex justify-between items-center">
                        <span class="capitalize text-gray-600">{{ item.status }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full" :class="getStatusColor(item.status)" 
                                     :style="{ width: (item.count / totalOrders * 100) + '%' }"></div>
                            </div>
                            <span class="font-medium w-8">{{ item.count }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Products -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-lg mb-4">Top Selling Products</h3>
                <div v-if="topProducts.length === 0" class="text-gray-500 text-center py-4">
                    No sales data yet
                </div>
                <div v-else class="space-y-4">
                    <div v-for="(product, index) in topProducts" :key="product.id" class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-primary text-white rounded-full flex items-center justify-center text-xs">
                            {{ index + 1 }}
                        </span>
                        <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden">
                            <img v-if="product.images?.[0]?.url" :src="product.images[0].url" class="w-full h-full object-cover">
                            <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ product.name }}</p>
                        </div>
                        <span class="text-gray-500">{{ product.order_items_count }} sold</span>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    totalRevenue: Number,
    totalOrders: Number,
    averageOrderValue: Number,
    ordersByMonth: Array,
    topProducts: Array,
    ordersByStatus: Array
});

const getStatusColor = (status) => {
    const colors = {
        'pending': 'bg-yellow-500',
        'processing': 'bg-blue-500',
        'shipped': 'bg-indigo-500',
        'delivered': 'bg-green-500',
        'cancelled': 'bg-red-500'
    };
    return colors[status] || 'bg-gray-500';
};
</script>
