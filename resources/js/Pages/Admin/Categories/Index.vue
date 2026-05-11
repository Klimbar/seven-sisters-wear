<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Categories</h1>
            <p class="text-gray-500 mt-1">Manage product categories</p>
        </div>

        <!-- Add Category Form -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="font-serif text-xl text-gray-900 mb-4">Add New Category</h2>
            <form @submit.prevent="storeCategory" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <InputText v-model="form.name" class="w-full" placeholder="e.g., Saree, Kurti" required />
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <InputText v-model="form.description" class="w-full" placeholder="Optional description" />
                </div>
                <Button type="submit" label="Add Category" :loading="loading" />
            </form>
        </div>

        <!-- Categories Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ category.name }}</div>
                            <div v-if="category.description" class="text-sm text-gray-500">{{ category.description }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                {{ category.products_count }} products
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ category.slug }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <Button icon="pi pi-pencil" size="small" text @click="openEditModal(category)" />
                                <Button
                                    icon="pi pi-trash"
                                    size="small"
                                    text
                                    severity="danger"
                                    :disabled="category.products_count > 0"
                                    @click="deleteCategory(category)"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="categories.length === 0" class="p-8 text-center text-gray-500">
                No categories found. Add one above.
            </div>
        </div>

        <!-- Edit Category Dialog -->
        <Dialog v-model:visible="editDialogVisible" header="Edit Category" :modal="true" class="w-[500px]">
            <form @submit.prevent="updateCategory">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                        <InputText v-model="editForm.name" class="w-full" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <Textarea v-model="editForm.description" rows="3" class="w-full" />
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
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

const props = defineProps({
    categories: Array
});

const loading = ref(false);
const updateLoading = ref(false);
const editDialogVisible = ref(false);
const selectedCategory = ref(null);

const form = ref({
    name: '',
    description: ''
});

const editForm = ref({
    name: '',
    description: ''
});

const storeCategory = () => {
    loading.value = true;
    router.post(route('admin.categories.store'), form.value, {
        preserveState: true,
        onSuccess: () => {
            form.value = { name: '', description: '' };
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};

const openEditModal = (category) => {
    selectedCategory.value = category;
    editForm.value = {
        name: category.name,
        description: category.description || ''
    };
    editDialogVisible.value = true;
};

const updateCategory = () => {
    if (!selectedCategory.value) return;

    updateLoading.value = true;
    router.patch(route('admin.categories.update', selectedCategory.value.id), editForm.value, {
        onFinish: () => {
            updateLoading.value = false;
            editDialogVisible.value = false;
        }
    });
};

const deleteCategory = (category) => {
    if (!confirm(`Delete category "${category.name}"?`)) return;

    router.delete(route('admin.categories.destroy', category.id), {
        preserveState: true
    });
};
</script>