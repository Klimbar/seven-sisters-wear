<template>
    <section class="testimonials">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Testimonials</span>
                <h2 class="font-serif text-4xl md:text-5xl text-text-dark mb-4">What Our Customers Say</h2>
                <p class="text-text-body max-w-xl mx-auto mb-4">Stories from those who wear our heritage.</p>
                <div class="divider"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <Card v-for="testimonial in testimonials" :key="testimonial.id" class="testimonial-card">
                    <template #header>
                        <div class="flex items-center gap-4 p-5 border-bottom">
                            <img :src="testimonial.avatar" :alt="testimonial.name" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <div class="font-serif text-base text-text-dark">{{ testimonial.name }}</div>
                                <div class="text-sm text-text-body location">{{ testimonial.location }}</div>
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <div class="stars flex gap-1 mb-4">
                            <i v-for="i in 5" :key="i" class="pi pi-star-fill text-sm"></i>
                        </div>
                        <p class="text-text-body leading-relaxed">{{ testimonial.text }}</p>
                    </template>
                </Card>
            </div>
        </div>
    </section>
</template>

<script setup>
import Card from 'primevue/card';

const testimonials = [
    {
        id: 1,
        text: "The quality of the Muga silk is absolutely stunning. I received so many compliments at my wedding. The craftsmanship is truly remarkable.",
        name: "Priya Sharma",
        location: "Mumbai, India",
        avatar: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80"
    },
    {
        id: 2,
        text: "I've been searching for authentic Mekhela Chadors for years. Seven Sisters Wear delivers genuine quality that I couldn't find anywhere else. Worth every rupee.",
        name: "Ananya Patel",
        location: "Bangalore, India",
        avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&q=80"
    },
    {
        id: 3,
        text: "The attention to detail in every piece is extraordinary. My Jonbiri Chador arrived beautifully packaged and exceeded all expectations.",
        name: "Ritu Goswami",
        location: "Guwahati, Assam",
        avatar: "https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=100&q=80"
    }
];
</script>

<style scoped>
.testimonials {
    padding: 100px 0;
    background-color: var(--color-cream);
}

.divider {
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
    margin: 20px auto 0;
    border-radius: 2px;
}

.testimonial-card {
    background: var(--color-white);
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(44, 24, 16, 0.08);
    overflow: hidden;
}

.border-bottom {
    border-bottom: 1px solid var(--color-cream-pattern);
}

.location {
    opacity: 0.7;
}

.stars {
    color: var(--color-accent);
}
</style>
