<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1">Overview of your store</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Products</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.totalProducts }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="pi pi-box text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.totalOrders }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="pi pi-shopping-cart text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">₹{{ stats.totalRevenue?.toLocaleString() || 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="pi pi-wallet text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ stats.totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="pi pi-users text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Secondary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-semibold text-gray-900 mb-4">Order Status</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Pending Orders</span>
                        <span class="font-semibold text-yellow-600">{{ stats.pendingOrders }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Low Stock Products</span>
                        <span class="font-semibold text-red-600">{{ stats.lowStockProducts }}</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-semibold text-gray-900 mb-4">Orders by Status</h3>
                <div class="space-y-2">
                    <div v-for="item in ordersByStatus" :key="item.status" class="flex justify-between">
                        <span class="capitalize text-gray-600">{{ item.status }}</span>
                        <span class="font-semibold">{{ item.count }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders & Top Products -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="font-semibold text-gray-900">Recent Orders</h3>
                </div>
                <div class="p-6">
                    <div v-if="recentOrders.length === 0" class="text-gray-500 text-center py-4">
                        No orders yet
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="order in recentOrders" :key="order.id" class="flex justify-between items-center pb-4 border-b last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">Order {{ order.order_number }}</p>
                                <p class="text-sm text-gray-500">{{ order.user?.name || 'Guest' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">₹{{ order.total_amount?.toLocaleString() }}</p>
                                <span class="text-xs px-2 py-1 rounded-full"
                                      :class="getStatusClass(order.status)">
                                    {{ order.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b">
                    <h3 class="font-semibold text-gray-900">Top Products</h3>
                </div>
                <div class="p-6">
                    <div v-if="topProducts.length === 0" class="text-gray-500 text-center py-4">
                        No products yet
                    </div>
                    <div v-else class="space-y-4">
                        <div v-for="product in topProducts" :key="product.id" class="flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden">
                                    <img v-if="product.images?.[0]?.url" :src="product.images[0].url" class="w-full h-full object-cover">
                                    <div v-else class="flex h-full w-full items-center justify-center text-xs text-gray-500">No image</div>
                                </div>
                                <span class="font-medium text-gray-900">{{ product.name }}</span>
                            </div>
                            <span class="text-gray-500">{{ product.order_items_count }} sold</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: Object,
    recentOrders: Array,
    topProducts: Array,
    ordersByStatus: Array
});

const getStatusClass = (status) => {
    const classes = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'processing': 'bg-blue-100 text-blue-800',
        'shipped': 'bg-indigo-100 text-indigo-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800',
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};
</script>
