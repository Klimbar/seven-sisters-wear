<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';
import { useToast } from 'primevue/usetoast';

const user = usePage().props.auth.user;
const toast = useToast();

const form = useForm({
    name: user.name,
    email: user.email,
});

const updateProfile = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: 'Profile updated successfully.', life: 3000 });
        },
    });
};
</script>

<template>
    <section>
        <header class="mb-8">
            <h2 class="font-serif text-2xl text-text-dark">
                Profile Information
            </h2>
            <p class="mt-2 text-sm text-text-body">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="updateProfile" class="space-y-6">
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-text-dark">Name</label>
                <InputText
                    id="name"
                    v-model="form.name"
                    class="w-full"
                    :invalid="!!form.errors.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <Message v-if="form.errors.name" severity="error" size="small" variant="simple">
                    {{ form.errors.name }}
                </Message>
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-text-dark">Email</label>
                <InputText
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full"
                    :invalid="!!form.errors.email"
                    required
                    autocomplete="username"
                />
                <Message v-if="form.errors.email" severity="error" size="small" variant="simple">
                    {{ form.errors.email }}
                </Message>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <Button
                    type="submit"
                    label="Save Changes"
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
