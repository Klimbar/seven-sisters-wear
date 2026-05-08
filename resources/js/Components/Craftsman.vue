<template>
    <section class="craftsman">
        <div class="pattern-overlay"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <div class="craftsman-images grid grid-cols-2 gap-5">
                    <div class="rounded-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?w=400&q=80" alt="Artisan 1" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden row-span-2">
                        <img src="https://images.unsplash.com/photo-1558171813-4c088753af8f?w=400&q=80" alt="Artisan 2" class="w-full h-full object-cover">
                    </div>
                    <div class="rounded-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1583391733956-6c78276477e2?w=400&q=80" alt="Artisan 3" class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="text-cream">
                    <span class="text-xs tracking-widest uppercase text-accent mb-3 block">The Artisans</span>
                    <h3 class="font-serif text-4xl text-cream mb-6">Master Craftspeople of Assam</h3>
                    <p class="opacity-85 mb-5">Our weavers are the heartbeat of Rong Bah. Each brings decades of expertise passed down through generations, using traditional handloom techniques that produce fabrics of unparalleled beauty and quality.</p>
                    <p class="opacity-85 mb-8">Every thread tells a story of dedication, every pattern a celebration of Assamese heritage.</p>
                    
                    <ul class="space-y-4">
                        <li v-for="item in features" :key="item" class="flex items-center gap-4">
                            <i class="pi pi-check-circle text-2xl text-accent"></i>
                            <span>{{ item }}</span>
                        </li>
                    </ul>

                    <Button label="Meet Our Artisans" icon="pi pi-arrow-right" iconPos="right" outlined class="mt-8 custom-button" />
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import Button from 'primevue/button';

const features = [
    '100% Handwoven Using Traditional Looms',
    'Natural Dyes Derived from Indigenous Plants',
    'Each Piece Takes 4-8 Weeks to Complete'
];
</script>

<style scoped>
.craftsman {
    background-color: var(--color-text-dark);
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.pattern-overlay {
    position: absolute;
    inset: 0;
    opacity: 0.5;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a227' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.custom-button {
    color: var(--color-white) !important;
    border-color: var(--color-white) !important;
}

.custom-button:hover {
    background-color: var(--color-white) !important;
    color: var(--color-text-dark) !important;
}
</style>
