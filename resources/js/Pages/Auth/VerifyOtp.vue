<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: props.email,
    otp: '',
});

const resendForm = useForm({
    email: props.email,
});

const canResend = ref(false);
const countdown = ref(60);

onMounted(() => {
    const timer = setInterval(() => {
        countdown.value--;
        if (countdown.value <= 0) {
            canResend.value = true;
            clearInterval(timer);
        }
    }, 1000);
});

const submit = () => {
    form.post(route('otp.verify'));
};

const resend = () => {
    resendForm.post(route('otp.resend'), {
        onSuccess: () => {
            canResend.value = false;
            countdown.value = 60;
            const timer = setInterval(() => {
                countdown.value--;
                if (countdown.value <= 0) {
                    canResend.value = true;
                    clearInterval(timer);
                }
            }, 1000);
        },
    });
};
</script>

<template>
    <GuestLayout
        title="Verify Your Email"
        subtitle="We sent a 6-digit code to your email"
        :show-register-link="false"
    >
        <Head title="Verify Email" />

        <div
            v-if="status"
            class="mb-4 text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <div class="mb-4 text-sm text-gray-600">
            Enter the 6-digit OTP sent to
            <span class="font-semibold text-gray-800">{{ email }}</span>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <div>
                <InputLabel for="otp" value="OTP Code" class="mb-1.5 font-medium text-gray-700" />

                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <TextInput
                        id="otp"
                        type="text"
                        class="w-full pl-11"
                        v-model="form.otp"
                        required
                        autofocus
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        placeholder="Enter 6-digit code"
                    />
                </div>

                <InputError class="mt-2" :message="form.errors.otp" />
            </div>

            <PrimaryButton
                class="w-full justify-center rounded-lg bg-orange-700 py-2.5 text-sm font-semibold text-white shadow-lg transition-all hover:bg-orange-800 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                :class="{ 'opacity-50': form.processing }"
                :disabled="form.processing"
            >
                <span v-if="form.processing">Verifying...</span>
                <span v-else>Verify Email</span>
            </PrimaryButton>
        </form>

        <div class="mt-6 text-center">
            <button
                v-if="canResend"
                @click="resend"
                class="text-sm font-medium text-orange-700 hover:text-orange-800 hover:underline"
                :disabled="resendForm.processing"
            >
                Resend OTP
            </button>
            <span v-else class="text-sm text-gray-500">
                Resend OTP in {{ countdown }}s
            </span>
        </div>

        <div class="mt-4 text-center">
            <Link
                :href="route('register')"
                class="text-sm text-gray-500 hover:text-gray-700 hover:underline"
            >
                &larr; Back to Register
            </Link>
        </div>
    </GuestLayout>
</template>
