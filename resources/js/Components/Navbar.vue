<template>
    <nav class="navbar" :class="{ 'scrolled': scrolled }">
        <div class="container mx-auto px-6">
            <div class="nav-inner">
                <a href="#" class="logo">
                    <svg class="logo-icon" viewBox="0 0 40 40" fill="currentColor">
                        <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="2"/>
                        <path d="M20 8 L22 18 L32 20 L22 22 L20 32 L18 22 L8 20 L18 18 Z" fill="currentColor"/>
                    </svg>
                    <span class="logo-text">Seven Sisters Wear</span>
                </a>

                <ul class="nav-links hidden md:flex">
                    <li><a href="#collections">Collections</a></li>
                    <li><a href="#shop">Shop</a></li>
                    <li><a href="#story">Our Story</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>

                <div class="nav-actions">
                    <button class="nav-icon">
                        <i class="pi pi-search"></i>
                    </button>
                    <button class="nav-icon">
                        <i class="pi pi-heart"></i>
                    </button>
                    <button class="nav-icon cart">
                        <i class="pi pi-shopping-cart"></i>
                        <span class="cart-badge">{{ cartCount }}</span>
                    </button>
                    <Button icon="pi pi-bars" text class="mobile-menu-btn md:hidden" :class="scrolled ? 'dark-icon' : 'light-icon'" @click="toggleMenu" />
                </div>
            </div>
        </div>

        <Drawer v-model:visible="menuVisible" position="right" class="w-64">
            <template #header>
                <span class="drawer-title">Menu</span>
            </template>
            <div class="drawer-links">
                <a href="#collections" @click="menuVisible = false">Collections</a>
                <a href="#shop" @click="menuVisible = false">Shop</a>
                <a href="#story" @click="menuVisible = false">Our Story</a>
                <a href="#contact" @click="menuVisible = false">Contact</a>
            </div>
        </Drawer>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Button from 'primevue/button';
import Drawer from 'primevue/drawer';

const scrolled = ref(false);
const menuVisible = ref(false);
const cartCount = ref(2);

const handleScroll = () => {
    scrolled.value = window.scrollY > 50;
};

const toggleMenu = () => {
    menuVisible.value = !menuVisible.value;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 50;
    padding: 20px 0;
    transition: all 0.4s ease;
}

.navbar.scrolled {
    background: var(--color-cream);
    box-shadow: 0 2px 20px rgba(44, 24, 16, 0.1);
    padding: 12px 0;
}

.nav-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--color-white);
    transition: color 0.4s ease;
}

.navbar.scrolled .logo {
    color: var(--color-text-dark);
}

.logo-icon {
    width: 40px;
    height: 40px;
}

.logo-text {
    font-family: var(--font-serif);
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 1px;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 40px;
    list-style: none;
}

.nav-links a {
    color: var(--color-white);
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
}

.navbar.scrolled .nav-links a {
    color: var(--color-text-body);
}

.nav-links a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--color-accent);
    transition: width 0.3s ease;
}

.nav-links a:hover::after {
    width: 100%;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.nav-icon {
    color: var(--color-white);
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    background: none;
    border: none;
}

.navbar.scrolled .nav-icon {
    color: var(--color-text-dark);
}

.nav-icon:hover {
    color: var(--color-accent);
    transform: scale(1.1);
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--color-accent-coral);
    color: var(--color-white);
    font-size: 11px;
    font-weight: 600;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-menu-btn {
    display: none;
}

@media (max-width: 768px) {
    .mobile-menu-btn {
        display: block !important;
    }
}

.light-icon {
    color: var(--color-white) !important;
}

.dark-icon {
    color: var(--color-text-dark) !important;
}

.drawer-title {
    font-family: var(--font-serif);
    font-size: 20px;
    font-weight: 700;
    color: var(--color-text-dark);
}

.drawer-links {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.drawer-links a {
    font-size: 18px;
    font-weight: 500;
    color: var(--color-text-body);
    text-decoration: none;
    transition: color 0.3s ease;
}

.drawer-links a:hover {
    color: var(--color-primary);
}
</style>
