<template>
    <AdminLayout>
        <div class="mb-8">
            <h1 class="font-serif text-3xl text-gray-900">Tribes</h1>
            <p class="text-gray-500 mt-1">Manage product tribes</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h2 class="font-serif text-xl text-gray-900 mb-4">Add New Tribe</h2>
            <form @submit.prevent="storeTribe" class="grid grid-cols-1 lg:grid-cols-[1fr_1fr_1.5fr_auto] gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tribe Name</label>
                    <InputText v-model="form.name" class="w-full" placeholder="e.g., Bodo, Khasi" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <Select v-model="form.state_id" :options="states" optionLabel="name" optionValue="id" placeholder="Select state" class="w-full" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <InputText v-model="form.description" class="w-full" placeholder="Optional description" />
                </div>
                <Button type="submit" label="Add Tribe" :loading="loading" />
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tribe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">State</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="tribe in tribes" :key="tribe.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ tribe.name }}</div>
                            <div v-if="tribe.description" class="text-sm text-gray-500">{{ tribe.description }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ tribe.state?.name || 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-medium">
                                {{ tribe.products_count }} products
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">
                            {{ tribe.slug }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <Button icon="pi pi-pencil" size="small" text @click="openEditModal(tribe)" />
                                <Button
                                    icon="pi pi-trash"
                                    size="small"
                                    text
                                    severity="danger"
                                    :disabled="tribe.products_count > 0"
                                    @click="deleteTribe(tribe)"
                                />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="tribes.length === 0" class="p-8 text-center text-gray-500">
                No tribes found. Add one above.
            </div>
        </div>

        <Dialog v-model:visible="editDialogVisible" header="Edit Tribe" :modal="true" class="w-[500px]">
            <form @submit.prevent="updateTribe">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tribe Name</label>
                        <InputText v-model="editForm.name" class="w-full" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <Select v-model="editForm.state_id" :options="states" optionLabel="name" optionValue="id" placeholder="Select state" class="w-full" required />
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
import Select from 'primevue/select';

const props = defineProps({
    tribes: Array,
    states: Array
});

const loading = ref(false);
const updateLoading = ref(false);
const editDialogVisible = ref(false);
const selectedTribe = ref(null);

const form = ref({
    name: '',
    state_id: null,
    description: ''
});

const editForm = ref({
    name: '',
    state_id: null,
    description: ''
});

const storeTribe = () => {
    loading.value = true;
    router.post(route('admin.tribes.store'), form.value, {
        preserveState: true,
        onSuccess: () => {
            form.value = { name: '', state_id: null, description: '' };
        },
        onFinish: () => {
            loading.value = false;
        }
    });
};

const openEditModal = (tribe) => {
    selectedTribe.value = tribe;
    editForm.value = {
        name: tribe.name,
        state_id: tribe.state_id,
        description: tribe.description || ''
    };
    editDialogVisible.value = true;
};

const updateTribe = () => {
    if (!selectedTribe.value) return;

    updateLoading.value = true;
    router.patch(route('admin.tribes.update', selectedTribe.value.id), editForm.value, {
        onFinish: () => {
            updateLoading.value = false;
            editDialogVisible.value = false;
        }
    });
};

const deleteTribe = (tribe) => {
    if (!confirm(`Delete tribe "${tribe.name}"?`)) return;

    router.delete(route('admin.tribes.destroy', tribe.id), {
        preserveState: true
    });
};
</script>
