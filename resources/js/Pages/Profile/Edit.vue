<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = computed(() => usePage().props.auth.user);
const initials = computed(() => {
    if (!user.value?.name) return '?';
    return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
});
</script>

<template>
    <Head title="Profile" />
    <Navbar />

    <div class="profile-page">
        <!-- Hero Banner -->
        <div class="profile-hero">
            <div class="container mx-auto px-6 py-16 text-center">
                <div class="profile-avatar">{{ initials }}</div>
                <h1 class="font-serif text-4xl text-text-dark mt-4">{{ user.name }}</h1>
                <p class="text-text-body mt-2">{{ user.email }}</p>
                <div class="flex justify-center gap-4 mt-6">
                    <Link :href="route('orders.index')" class="profile-quick-link">
                        <i class="ph ph-package"></i> My Orders
                    </Link>
                    <Link :href="route('wishlist')" class="profile-quick-link">
                        <i class="ph ph-heart"></i> Wishlist
                    </Link>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-6 py-12">
            <div class="max-w-2xl mx-auto space-y-8">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ $page.props.flash.success }}
                </div>

                <!-- Email Verification Notice -->
                <div v-if="mustVerifyEmail && user.email_verified_at === null" class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg flex items-center justify-between">
                    <p class="text-sm">Your email address is unverified.</p>
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-sm font-medium text-primary hover:underline"
                    >
                        Resend verification email
                    </Link>
                </div>
                <div v-if="status === 'verification-link-sent'" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    A new verification link has been sent to your email address.
                </div>

                <!-- Profile Information -->
                <div class="profile-card">
                    <UpdateProfileInformationForm />
                </div>

                <!-- Update Password -->
                <div class="profile-card">
                    <UpdatePasswordForm />
                </div>

                <!-- Delete Account -->
                <div class="profile-card profile-card-danger">
                    <DeleteUserForm />
                </div>
            </div>
        </div>
    </div>

    <Footer />
</template>

<style scoped>
.profile-page {
    padding-top: 80px;
    min-height: 100vh;
    background: var(--color-cream);
}

.profile-hero {
    background: linear-gradient(135deg, var(--color-cream-light) 0%, var(--color-cream-pattern) 100%);
    border-bottom: 1px solid var(--color-cream-pattern);
}

.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--color-primary);
    color: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 1px;
    margin: 0 auto;
    font-family: var(--font-serif);
}

.profile-quick-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-text-body);
    background: var(--color-white);
    border: 1px solid var(--color-cream-pattern);
    text-decoration: none;
    transition: all 0.3s ease;
}

.profile-quick-link:hover {
    color: var(--color-primary);
    border-color: var(--color-primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 35, 35, 0.1);
}

.profile-card {
    background: var(--color-white);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 1px 3px rgba(44, 24, 16, 0.06);
    border: 1px solid var(--color-cream-pattern);
}

.profile-card-danger {
    border-color: #fecaca;
    background: #fff5f5;
}
</style>
