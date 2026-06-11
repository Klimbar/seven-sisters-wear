<template>
    <nav class="navbar" :class="{ 'scrolled': navbarScrolled }">
        <div class="container mx-auto px-6">
            <div class="nav-inner">
                <a href="/" class="logo">
                    <img src="/images/logo.webp" alt="Seven Sisters Wear" class="logo-icon" />
                    <span class="logo-text">Seven Sisters Wear</span>
                </a>

                <ul class="nav-links hidden md:flex">
                    <li><a href="/" :class="{ active: isActive('/') }">Home</a></li>
                    <li><a href="/shop" :class="{ active: isActive('/shop') }">Shop</a></li>
                    <li><a href="/orders" :class="{ active: isActive('/orders') }">My Orders</a></li>
                    <li><a href="/contact" :class="{ active: isActive('/contact') }">Contact</a></li>
                </ul>

                <div class="nav-actions">
                    <!-- Guest: Sign In / Register -->
                    <template v-if="!user">
                        <Link :href="route('login')" class="nav-link" :class="navbarScrolled ? 'dark' : 'light'">Sign In</Link>
                        <Link :href="route('register')" class="nav-link nav-link-register" :class="navbarScrolled ? 'dark' : 'light'">Register</Link>
                    </template>

                    <div class="relative flex items-center">
                        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 w-0" enter-to-class="opacity-100 w-48" leave-active-class="transition ease-in duration-150" leave-from-class="opacity-100 w-48" leave-to-class="opacity-0 w-0">
                            <input v-if="searchOpen" ref="searchInput" v-model="searchQuery" @keyup.enter="submitSearch" @keyup.escape="searchOpen = false" type="text" placeholder="Search..." class="search-input" />
                        </Transition>
                        <button class="nav-icon" @click="toggleSearch">
                            <i class="pi pi-search"></i>
                        </button>
                    </div>
                    <a href="/wishlist" class="nav-icon">
                        <i class="pi pi-heart"></i>
                    </a>
                    <a href="/cart" class="nav-icon cart">
                        <i class="pi pi-shopping-cart"></i>
                        <span v-if="cartCount > 0" class="cart-badge">{{ cartCount }}</span>
                    </a>

                    <!-- Authenticated: User Dropdown -->
                    <div v-if="user" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="nav-avatar" :class="navbarScrolled ? 'dark' : 'light'">
                            {{ initials }}
                        </button>
                        <div v-show="dropdownOpen" class="fixed inset-0 z-40" @click="dropdownOpen = false"></div>
                        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                            <div v-show="dropdownOpen" class="dropdown-menu">
                                <div class="dropdown-header">
                                    <div class="dropdown-avatar">{{ initials }}</div>
                                    <div>
                                        <div class="dropdown-name">{{ user.name }}</div>
                                        <div class="dropdown-email">{{ user.email }}</div>
                                    </div>
                                </div>
                                <hr class="dropdown-divider">
                                <Link :href="route('orders.index')" class="dropdown-item" @click="dropdownOpen = false">
                                    <i class="ph ph-package"></i> My Orders
                                </Link>
                                <Link :href="route('profile.edit')" class="dropdown-item" @click="dropdownOpen = false">
                                    <i class="ph ph-user"></i> Profile
                                </Link>
                                <Link v-if="isAdmin" :href="route('admin.dashboard')" class="dropdown-item" @click="dropdownOpen = false">
                                    <i class="ph ph-gauge"></i> Admin Dashboard
                                </Link>
                                <hr class="dropdown-divider">
                                <Link :href="route('logout')" method="post" as="button" class="dropdown-item dropdown-item-danger" @click="dropdownOpen = false">
                                    <i class="ph ph-sign-out"></i> Log Out
                                </Link>
                            </div>
                        </Transition>
                    </div>

                    <Button icon="pi pi-bars" text class="mobile-menu-btn md:hidden" :class="navbarScrolled ? 'dark-icon' : 'light-icon'" @click="toggleMenu" />
                </div>
            </div>
        </div>

        <Drawer v-model:visible="menuVisible" position="right" class="w-64">
            <template #header>
                <span class="drawer-title">Menu</span>
            </template>
            <div class="drawer-links">
                <a href="/" @click="menuVisible = false">Home</a>
                <a href="/shop" @click="menuVisible = false">Shop</a>
                <a href="/orders" @click="menuVisible = false">My Orders</a>
                <a href="/contact" @click="menuVisible = false">Contact</a>
            </div>
            <hr class="drawer-divider">
            <template v-if="!user">
                <Link :href="route('login')" class="drawer-auth-link" @click="menuVisible = false">Sign In</Link>
                <Link :href="route('register')" class="drawer-auth-link" @click="menuVisible = false">Register</Link>
            </template>
            <template v-else>
                <div class="drawer-user">
                    <div class="drawer-avatar">{{ initials }}</div>
                    <div>
                        <div class="drawer-user-name">{{ user.name }}</div>
                        <div class="drawer-user-email">{{ user.email }}</div>
                    </div>
                </div>
                <Link :href="route('orders.index')" class="drawer-auth-link" @click="menuVisible = false">
                    <i class="ph ph-package"></i> My Orders
                </Link>
                <Link :href="route('profile.edit')" class="drawer-auth-link" @click="menuVisible = false">
                    <i class="ph ph-user"></i> Profile
                </Link>
                <Link v-if="isAdmin" :href="route('admin.dashboard')" class="drawer-auth-link" @click="menuVisible = false">
                    <i class="ph ph-gauge"></i> Admin Dashboard
                </Link>
                <Link :href="route('logout')" method="post" as="button" class="drawer-auth-link drawer-auth-logout" @click="menuVisible = false">
                    <i class="ph ph-sign-out"></i> Log Out
                </Link>
            </template>
        </Drawer>
    </nav>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, onUnmounted } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Drawer from 'primevue/drawer';

const page = usePage();
const scrolled = ref(false);
const menuVisible = ref(false);
const dropdownOpen = ref(false);
const searchOpen = ref(false);
const searchQuery = ref('');
const searchInput = ref(null);
const cartCount = computed(() => page.props.cartCount || 0);
const user = computed(() => page.props.auth?.user || null);
const isAdmin = computed(() => page.props.auth?.is_admin || false);
const initials = computed(() => {
    if (!user.value?.name) return '?';
    return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
});
const isHomePage = computed(() => page.url === '/');
const navbarScrolled = computed(() => !isHomePage.value || scrolled.value);

const isActive = (path) => {
    const current = page.url.split('?')[0].split('#')[0];
    if (path === '/') return current === '/';
    return current === path || current.startsWith(path + '/');
};

const handleScroll = () => {
    scrolled.value = window.scrollY > 50;
};

const toggleMenu = () => {
    menuVisible.value = !menuVisible.value;
};

const toggleSearch = () => {
    searchOpen.value = !searchOpen.value;
    if (searchOpen.value) {
        nextTick(() => searchInput.value?.focus());
    }
};

const submitSearch = () => {
    if (searchQuery.value.trim()) {
        router.get('/shop', { search: searchQuery.value.trim() });
        searchOpen.value = false;
        searchQuery.value = '';
    }
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
    background: var(--color-cream-light);
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

.nav-links a:hover::after,
.nav-links a.active::after {
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

.search-input {
    width: 180px;
    padding: 6px 12px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.15);
    color: var(--color-white);
    font-size: 14px;
    outline: none;
    margin-right: 8px;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.search-input:focus {
    border-color: var(--color-accent);
    background: rgba(255, 255, 255, 0.25);
}

.navbar.scrolled .search-input {
    border-color: var(--color-border, #d1d5db);
    background: var(--color-white);
    color: var(--color-text-dark);
}

.navbar.scrolled .search-input::placeholder {
    color: var(--color-text-body);
    opacity: 0.5;
}

.navbar.scrolled .search-input:focus {
    border-color: var(--color-accent);
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

.drawer-divider {
    border: none;
    border-top: 1px solid var(--color-border, #e5e7eb);
    margin: 16px 0;
}

.drawer-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    padding: 0 4px;
}

.drawer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-primary);
    color: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}

.drawer-user-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--color-text-dark);
}

.drawer-user-email {
    font-size: 13px;
    color: var(--color-text-body);
    opacity: 0.7;
}

.drawer-auth-link {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 500;
    color: var(--color-text-body);
    text-decoration: none;
    padding: 8px 4px;
    transition: color 0.3s ease;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.drawer-auth-link i {
    font-size: 18px;
    opacity: 0.6;
}

.drawer-auth-link:hover {
    color: var(--color-primary);
}

.drawer-auth-logout {
    color: #dc2626;
}

.drawer-auth-logout:hover {
    color: #b91c1c;
}

.nav-link {
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    letter-spacing: 0.5px;
}

.nav-link.light {
    color: var(--color-white);
}

.nav-link.dark {
    color: var(--color-text-body);
}

.nav-link:hover {
    color: var(--color-accent) !important;
}

.nav-link-register {
    padding: 6px 16px;
    border-radius: 6px;
    border: 1.5px solid currentColor;
}

.nav-link-register.light {
    color: var(--color-white);
    border-color: var(--color-white);
}

.nav-link-register.dark {
    color: var(--color-text-body);
    border-color: var(--color-text-body);
}

.nav-link-register:hover {
    background: var(--color-accent);
    border-color: var(--color-accent);
    color: white !important;
}

.nav-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.nav-avatar.light {
    background: rgba(255, 255, 255, 0.2);
    color: var(--color-white);
    border-color: rgba(255, 255, 255, 0.3);
}

.nav-avatar.light:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
}

.nav-avatar.dark {
    background: var(--color-primary);
    color: var(--color-white);
    border-color: var(--color-primary);
}

.nav-avatar.dark:hover {
    opacity: 0.9;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 8px;
    min-width: 220px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    z-index: 100;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.06);
}

.dropdown-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
}

.dropdown-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--color-primary);
    color: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}

.dropdown-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--color-text-dark);
}

.dropdown-email {
    font-size: 12px;
    color: var(--color-text-body);
    opacity: 0.7;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 16px;
    font-size: 14px;
    font-weight: 500;
    color: var(--color-text-body);
    text-decoration: none;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    transition: background 0.15s ease;
    font-family: inherit;
}

.dropdown-item i {
    font-size: 16px;
    opacity: 0.6;
}

.dropdown-item:hover {
    background: #f9f5f0;
    color: var(--color-accent);
}

.dropdown-item-danger {
    color: #dc2626;
}

.dropdown-item-danger:hover {
    background: #fef2f2;
    color: #b91c1c;
}

.dropdown-divider {
    border: none;
    border-top: 1px solid #f0f0f0;
    margin: 4px 0;
}
</style>
