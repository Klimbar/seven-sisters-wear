<template>
    <div class="contact-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Get in Touch</span>
                    <h1 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Contact Us</h1>
                    <p class="text-text-body">Have questions about our products or need assistance? We're here to help.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div class="bg-white p-8 rounded-lg shadow-sm">
                        <h2 class="font-serif text-2xl mb-6">Send us a Message</h2>
                        <form @submit.prevent="submitForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Name</label>
                                    <InputText v-model="form.name" class="w-full" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Email</label>
                                    <InputText v-model="form.email" type="email" class="w-full" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Subject</label>
                                    <InputText v-model="form.subject" class="w-full" required />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Message</label>
                                    <Textarea v-model="form.message" rows="5" class="w-full" required />
                                </div>
                                <Button type="submit" label="Send Message" class="w-full" :loading="loading" />
                            </div>
                        </form>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <div class="bg-cream p-8 rounded-lg mb-6">
                            <h3 class="font-serif text-xl mb-4">Visit Our Store</h3>
                            <p class="text-text-body mb-4">
                                123 Heritage Lane<br>
                                Guwahati, Assam 781001<br>
                                North-East India
                            </p>
                            <div class="flex items-center gap-3 text-text-body">
                                <i class="pi pi-clock"></i>
                                <span>Mon-Sat: 10:00 AM - 8:00 PM</span>
                            </div>
                        </div>

                        <div class="bg-cream p-8 rounded-lg mb-6">
                            <h3 class="font-serif text-xl mb-4">Contact Info</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <i class="pi pi-phone text-primary"></i>
                                    <span>+91 98765 43210</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="pi pi-envelope text-primary"></i>
                                    <span>hello@sevensisterswear.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-cream p-8 rounded-lg">
                            <h3 class="font-serif text-xl mb-4">Follow Us</h3>
                            <div class="flex gap-4">
                                <a href="#" class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-all">
                                    <i class="pi pi-facebook"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-all">
                                    <i class="pi pi-instagram"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center hover:bg-primary/80 transition-all">
                                    <i class="pi pi-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useToast } from 'primevue/usetoast';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';

const toast = useToast();
const loading = ref(false);

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const submitForm = () => {
    loading.value = true;
    // Simulate form submission
    setTimeout(() => {
        loading.value = false;
        toast.add({ severity: 'success', summary: 'Message Sent', detail: 'We will get back to you soon!', life: 3000 });
        form.value = { name: '', email: '', subject: '', message: '' };
    }, 1000);
};
</script>
