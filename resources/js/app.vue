<template>
    <div id="app">
        <Navbar />
        <Hero />
        <Heritage />
        <Collections />
        <Products />
        <Craftsman />
        <Testimonials />
        <Newsletter />
        <Footer />
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Hero from './components/Hero.vue';
import Heritage from './components/Heritage.vue';
import Collections from './components/Collections.vue';
import Products from './components/Products.vue';
import Craftsman from './components/Craftsman.vue';
import Testimonials from './components/Testimonials.vue';
import Newsletter from './components/Newsletter.vue';
import Footer from './components/Footer.vue';
</script>

<style>
#app {
    min-height: 100vh;
}
</style>
