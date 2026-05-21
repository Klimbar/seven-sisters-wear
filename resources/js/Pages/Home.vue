<template>
    <div class="home-page">
        <Navbar />
        <Hero />
        <Heritage />
        <Collections :collections="collections" />
        <Products :products="featuredProducts" />
        <Craftsman />
        <Testimonials />
        <Newsletter />
        <Footer />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Hero from '@/Components/Hero.vue';
import Heritage from '@/Components/Heritage.vue';
import Collections from '@/Components/Collections.vue';
import Products from '@/Components/Products.vue';
import Craftsman from '@/Components/Craftsman.vue';
import Testimonials from '@/Components/Testimonials.vue';
import Newsletter from '@/Components/Newsletter.vue';
import Footer from '@/Components/Footer.vue';

const page = usePage();
const featuredProducts = computed(() => page.props.featuredProducts || []);
const collections = computed(() => page.props.collections || []);
</script>
