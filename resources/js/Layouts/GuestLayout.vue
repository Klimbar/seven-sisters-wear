<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Welcome Back',
    },
    subtitle: {
        type: String,
        default: 'Sign in to continue your journey',
    },
    showRegisterLink: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-gradient-to-br from-amber-50 via-orange-50 to-rose-50 px-4 py-8 sm:px-6 lg:px-8"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -left-40 -top-40 h-96 w-96 rounded-full bg-orange-200/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-40 h-96 w-96 rounded-full bg-amber-200/20 blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="mb-8 text-center">
                <Link href="/" class="inline-block transition-transform hover:scale-105">
                    <ApplicationLogo class="h-16 w-auto fill-current text-orange-700" />
                </Link>
                <h2 class="mt-6 text-2xl font-bold text-gray-900">{{ title }}</h2>
                <p class="mt-2 text-sm text-gray-600">{{ subtitle }}</p>
            </div>

            <div
                class="relative w-full overflow-hidden rounded-2xl bg-white/80 px-6 py-8 shadow-xl backdrop-blur-sm ring-1 ring-black/5 sm:px-10"
            >
                <slot />
            </div>

            <p v-if="showRegisterLink" class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <Link :href="route('register')" class="font-medium text-orange-700 hover:text-orange-800 hover:underline">
                    Create one
                </Link>
            </p>
            <p v-else class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <Link :href="route('login')" class="font-medium text-orange-700 hover:text-orange-800 hover:underline">
                    Sign in
                </Link>
            </p>
        </div>
    </div>
</template>
