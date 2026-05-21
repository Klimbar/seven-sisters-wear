<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Password from 'primevue/password';
import Message from 'primevue/message';
import { ref, nextTick } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value?.$el?.querySelector('input')?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.$el?.querySelector('input')?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section>
        <header class="mb-6">
            <h2 class="font-serif text-2xl text-text-dark">
                Delete Account
            </h2>
            <p class="mt-2 text-sm text-text-body">
                Once your account is deleted, all of its resources and data will be permanently deleted.
                Please download any data or information that you wish to retain before deleting.
            </p>
        </header>

        <Button
            label="Delete Account"
            severity="danger"
            @click="confirmUserDeletion"
        />

        <Dialog
            v-model:visible="confirmingUserDeletion"
            modal
            header="Delete Account"
            :style="{ width: '28rem' }"
            :breakpoints="{ '640px': '90vw' }"
            @hide="closeModal"
        >
            <p class="text-text-body text-sm mb-6">
                Are you sure you want to delete your account? Once deleted, all data will be permanently lost.
                Please enter your password to confirm.
            </p>

            <div class="space-y-2">
                <label for="delete-password" class="block text-sm font-medium text-text-dark">Password</label>
                <Password
                    id="delete-password"
                    ref="passwordInput"
                    v-model="form.password"
                    class="w-full"
                    :inputClass="'w-full'"
                    :invalid="!!form.errors.password"
                    :feedback="false"
                    toggleMask
                    maskIcon="pi pi-eye"
                    unmaskIcon="pi pi-eye-slash"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    @keyup.enter="deleteUser"
                />
                <Message v-if="form.errors.password" severity="error" size="small" variant="simple">
                    {{ form.errors.password }}
                </Message>
            </div>

            <template #footer>
                <Button
                    label="Cancel"
                    severity="secondary"
                    text
                    @click="closeModal"
                />
                <Button
                    label="Delete Account"
                    severity="danger"
                    :loading="form.processing"
                    @click="deleteUser"
                />
            </template>
        </Dialog>
    </section>
</template>
