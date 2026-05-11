<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Users</h1>
            <p class="text-gray-500 mt-1">Manage registered users</p>
        </div>
        
        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <InputText v-model="search" placeholder="Search by name or email..." class="w-full" @input="applyFilters" />
                </div>
                <div class="min-w-[150px]">
                    <Select v-model="roleFilter" :options="roleOptions" optionLabel="name" optionValue="value" 
                            placeholder="All Roles" class="w-full" @change="applyFilters" />
                </div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ user.name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ user.email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium"
                                  :class="getRoleClass(user.roles?.[0]?.name)">
                                {{ user.roles?.[0]?.name || 'customer' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ new Date(user.created_at).toLocaleDateString() }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <Select v-model="userRoles[user.id]" :options="roleOptions" optionLabel="name" optionValue="value" 
                                        class="text-sm w-32" @change="updateRole(user.id)" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="px-6 py-4 border-t">
                <Paginator :rows="users.per_page" :totalRecords="users.total" @page="onPageChange" />
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Paginator from 'primevue/paginator';

const props = defineProps({
    users: Object,
    filters: Object
});

const search = ref(props.filters?.search || '');
const roleFilter = ref(props.filters?.role || '');
const userRoles = ref({});

onMounted(() => {
    props.users.data.forEach(user => {
        userRoles.value[user.id] = user.roles?.[0]?.name || 'customer';
    });
});

const roleOptions = [
    { name: 'Customer', value: 'customer' },
    { name: 'Admin', value: 'admin' }
];

const getRoleClass = (role) => {
    return role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';
};

const applyFilters = () => {
    router.get(route('admin.users.index'), {
        search: search.value,
        role: roleFilter.value
    }, { preserveState: true });
};

const onPageChange = (event) => {
    router.get(route('admin.users.index'), {
        ...props.filters,
        page: event.page + 1
    }, { preserveState: true });
};

const updateRole = (userId) => {
    router.patch(route('admin.users.updateRole', userId), {
        role: userRoles.value[userId]
    }, { preserveState: true });
};
</script>