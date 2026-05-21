<template>
    <div class="admin-layout min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 h-full w-64 bg-gray-900 text-white flex flex-col">
            <div class="p-6 border-b border-gray-800">
                <h1 class="text-xl font-serif font-bold">Seven Sisters Wear</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>
            
            <nav class="flex-1 p-4 space-y-2">
                <Link :href="route('admin.dashboard')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/dashboard') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-home"></i>
                    <span>Dashboard</span>
                </Link>
                
                <Link :href="route('admin.products.index')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/products') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-box"></i>
                    <span>Products</span>
                </Link>
                
                <Link :href="route('admin.orders.index')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/orders') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-shopping-cart"></i>
                    <span>Orders</span>
                </Link>
                
                <Link :href="route('admin.returns.index')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/returns') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-replay"></i>
                    <span>Returns</span>
                </Link>
                
                <Link :href="route('admin.users.index')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/users') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-users"></i>
                    <span>Users</span>
                </Link>
                
                <Link :href="route('admin.categories.index')"
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/categories') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-tags"></i>
                    <span>Categories</span>
                </Link>

                <Link :href="route('admin.coupons.index')"
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url.startsWith('/admin/coupons') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-ticket"></i>
                    <span>Coupons</span>
                </Link>

                <Link :href="route('admin.reports')" 
                      class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors"
                      :class="$page.url === '/admin/reports' ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-800'">
                    <i class="pi pi-chart-bar"></i>
                    <span>Reports</span>
                </Link>
            </nav>
            
            <div class="p-4 border-t border-gray-800">
                <Link :href="route('dashboard')" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="pi pi-arrow-left"></i>
                    <span>Back to Site</span>
                </Link>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="ml-64 p-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

