<script setup>
import { useForm } from '@inertiajs/vue3';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Message from 'primevue/message';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.add({ severity: 'success', summary: 'Success', detail: 'Password updated successfully.', life: 3000 });
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
            }
            if (form.errors.current_password) {
                form.reset('current_password');
            }
        },
    });
};
</script>

<template>
    <section>
        <header class="mb-8">
            <h2 class="font-serif text-2xl text-text-dark">
                Update Password
            </h2>
            <p class="mt-2 text-sm text-text-body">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="space-y-2">
                <label for="current_password" class="block text-sm font-medium text-text-dark">Current Password</label>
                <Password
                    id="current_password"
                    v-model="form.current_password"
                    class="w-full"
                    :inputClass="'w-full'"
                    :invalid="!!form.errors.current_password"
                    :feedback="false"
                    toggleMask
                    maskIcon="pi pi-eye"
                    unmaskIcon="pi pi-eye-slash"
                    required
                    autocomplete="current-password"
                />
                <Message v-if="form.errors.current_password" severity="error" size="small" variant="simple">
                    {{ form.errors.current_password }}
                </Message>
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-text-dark">New Password</label>
                <Password
                    id="password"
                    v-model="form.password"
                    class="w-full"
                    :inputClass="'w-full'"
                    :invalid="!!form.errors.password"
                    toggleMask
                    maskIcon="pi pi-eye"
                    unmaskIcon="pi pi-eye-slash"
                    required
                    autocomplete="new-password"
                />
                <Message v-if="form.errors.password" severity="error" size="small" variant="simple">
                    {{ form.errors.password }}
                </Message>
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-text-dark">Confirm Password</label>
                <Password
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    class="w-full"
                    :inputClass="'w-full'"
                    :invalid="!!form.errors.password_confirmation"
                    :feedback="false"
                    toggleMask
                    maskIcon="pi pi-eye"
                    unmaskIcon="pi pi-eye-slash"
                    required
                    autocomplete="new-password"
                />
                <Message v-if="form.errors.password_confirmation" severity="error" size="small" variant="simple">
                    {{ form.errors.password_confirmation }}
                </Message>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <Button
                    type="submit"
                    label="Update Password"
                    :loading="form.processing"
                    class="!bg-primary !border-primary hover:!bg-primary/90"
                />
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-secondary font-medium">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
