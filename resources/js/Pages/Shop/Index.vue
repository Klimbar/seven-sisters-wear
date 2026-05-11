<template>
    <div class="shop-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="text-center mb-16">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Our Collection</span>
                <h1 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">Shop Traditional Wear</h1>
                <p class="text-text-body max-w-xl mx-auto">Discover authentic handwoven Mekhela Chadors and traditional wear from North-East India.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Filters Sidebar -->
                <div class="filters bg-white p-6 rounded-lg shadow-sm h-fit">
                    <h3 class="font-serif text-xl mb-6">Filters</h3>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <InputText v-model="filters.search" placeholder="Search products..." class="w-full" @input="applyFilters" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <Select v-model="filters.category" :options="categories" optionLabel="name" optionValue="slug" placeholder="All Categories" class="w-full" @change="applyFilters" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Tribe</label>
                        <Select v-model="filters.tribe" :options="tribes" optionLabel="name" optionValue="slug" placeholder="All Tribes" class="w-full" @change="applyFilters" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Fabric</label>
                        <Select v-model="filters.fabric" :options="fabrics" optionLabel="name" optionValue="value" placeholder="All Fabrics" class="w-full" @change="applyFilters" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Price Range</label>
                        <div class="flex gap-2">
                            <InputText v-model="filters.min_price" placeholder="Min" type="number" class="w-full" @input="applyFilters" />
                            <InputText v-model="filters.max_price" placeholder="Max" type="number" class="w-full" @input="applyFilters" />
                        </div>
                    </div>

                    <Button label="Clear Filters" text class="w-full" @click="clearFilters" />
                </div>

                <!-- Products Grid -->
                <div class="md:col-span-3">
                    <div class="grid md:grid-cols-3 gap-6">
                        <Link v-for="product in products.data" :key="product.id" :href="`/products/${product.id}`" class="product-card bg-white rounded-lg overflow-hidden hover:shadow-xl transition-all block">
                            <div class="relative aspect-[3/4] overflow-hidden group">
                                <img :src="getProductImage(product)" :alt="product.name" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                <button class="product-wishlist absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-primary hover:text-white transition-all shadow-lg" @click.prevent="toggleWishlist(product)">
                                    <i :class="product.is_wishlisted ? 'pi pi-heart-fill text-red-500' : 'pi pi-heart'"></i>
                                </button>
                                <button v-if="product.stock > 0" class="absolute bottom-0 left-0 right-0 bg-primary text-white py-3 opacity-0 group-hover:opacity-100 transition-all font-medium translate-y-full group-hover:translate-y-0" @click.prevent="quickAddToCart(product)">
                                    Quick Add to Cart
                                </button>
                            </div>
                            <div class="p-5">
                                <h3 class="font-serif text-lg text-text-dark mb-1">{{ product.name }}</h3>
                                <p class="text-sm text-text-body opacity-70 mb-3">{{ product.category?.name }} • {{ product.fabric }}</p>
                                <div class="flex items-center gap-3">
                                    <span class="font-semibold text-xl text-primary">₹{{ product.price.toLocaleString() }}</span>
                                    <span v-if="product.discount_price" class="text-sm text-text-body opacity-50 line-through">₹{{ product.discount_price.toLocaleString() }}</span>
                                </div>
                            </div>
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center">
                        <Paginator :rows="products.per_page" :totalRecords="products.total" @page="onPageChange" />
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import InputText from 'primevue/inputtext';
import Select from 'primevue/select';
import Button from 'primevue/button';
import Paginator from 'primevue/paginator';

const props = defineProps({
    products: Object,
    filters: Object,
    categories: Array,
    tribes: Array
});

const filters = ref({
    search: props.filters?.search || '',
    category: props.filters?.category || null,
    tribe: props.filters?.tribe || null,
    fabric: props.filters?.fabric || null,
    min_price: props.filters?.min_price || '',
    max_price: props.filters?.max_price || '',
    page: 1
});

const fabrics = [
    { name: 'Muga Silk', value: 'Muga' },
    { name: 'Pat Silk', value: 'Pat' },
    { name: 'Eri Silk', value: 'Eri' }
];

const applyFilters = () => {
    router.get('/shop', filters.value, { preserveState: true });
};

const clearFilters = () => {
    filters.value = {
        search: '',
        category: null,
        tribe: null,
        fabric: null,
        min_price: '',
        max_price: '',
        page: 1
    };
    applyFilters();
};

const onPageChange = (event) => {
    filters.value.page = event.page + 1;
    applyFilters();
};

const toggleWishlist = (product) => {
    router.post(`/wishlist/toggle/${product.id}`, {}, {
        preserveState: true,
        onSuccess: () => {
            product.is_wishlisted = !product.is_wishlisted;
        }
    });
};

const getProductImage = (product) => {
    if (product.images && product.images.length > 0) {
        return product.images[0].image_path || product.images[0].url || 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80';
    }
    return 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&q=80';
};

const quickAddToCart = (product) => {
    router.post(`/cart/add/${product.id}`, { quantity: 1 }, {
        preserveState: true,
        onSuccess: () => {
            alert('Product added to cart!');
        }
    });
};
</script>
