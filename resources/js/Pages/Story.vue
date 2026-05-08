<template>
    <div class="story-page">
        <Navbar />
        <div class="container mx-auto px-6 py-24">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Our Story</span>
                    <h1 class="font-serif text-4xl md:text-5xl text-text-dark mb-6">Preserving Heritage, Weaving Dreams</h1>
                </div>

                <div class="grid md:grid-cols-2 gap-12 mb-16">
                    <div>
                        <img src="https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?w=600&q=80" 
                             alt="Traditional weaving" class="w-full rounded-lg shadow-lg">
                    </div>
                    <div class="flex flex-col justify-center">
                        <h2 class="font-serif text-3xl mb-6">Our Journey Since 1892</h2>
                        <p class="text-text-body leading-relaxed mb-4">
                            In the heart of Assam, where the Brahmaputra flows gently past ancient weaving villages, 
                            our family's tradition of silk weaving has been passed down through five generations.
                        </p>
                        <p class="text-text-body leading-relaxed">
                            Each Mekhela Chador tells a story—not just of intricate patterns and natural dyes, 
                            but of dedication, patience, and an unwavering commitment to preserving the dying 
                            art of traditional Assamese weaving.
                        </p>
                    </div>
                </div>

                <div class="bg-cream-light p-12 rounded-lg mb-16">
                    <h2 class="font-serif text-3xl text-center mb-12">Our Values</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="pi pi-heart text-2xl text-primary"></i>
                            </div>
                            <h3 class="font-serif text-xl mb-2">Authenticity</h3>
                            <p class="text-text-body">Every piece is handwoven using traditional techniques passed down through generations.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="pi pi-users text-2xl text-primary"></i>
                            </div>
                            <h3 class="font-serif text-xl mb-2">Community</h3>
                            <p class="text-text-body">Supporting over 500 artisan families across Assam and North-East India.</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="pi pi-leaf text-2xl text-primary"></i>
                            </div>
                            <h3 class="font-serif text-xl mb-2">Sustainability</h3>
                            <p class="text-text-body">Using natural dyes and eco-friendly processes that respect our environment.</p>
                        </div>
                    </div>
                </div>

                <div class="stats grid grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="font-serif text-5xl text-primary font-bold">130+</div>
                        <div class="text-text-body mt-2">Years of Heritage</div>
                    </div>
                    <div>
                        <div class="font-serif text-5xl text-primary font-bold">500+</div>
                        <div class="text-text-body mt-2">Artisan Partners</div>
                    </div>
                    <div>
                        <div class="font-serif text-5xl text-primary font-bold">12K+</div>
                        <div class="text-text-body mt-2">Happy Customers</div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
</script>
