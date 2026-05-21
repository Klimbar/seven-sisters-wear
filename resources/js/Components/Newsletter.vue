<template>
    <section class="newsletter">
        <div class="pattern-bar bottom"></div>
        
        <div class="max-w-xl mx-auto text-center px-6 py-20">
            <span class="text-xs tracking-widest uppercase text-accent mb-3 block">Newsletter</span>
            <h2 class="font-serif text-4xl text-text-dark mb-4">Stay Connected</h2>
            <p class="text-text-body mb-8">Subscribe to receive updates on new collections, artisan stories, and exclusive offers.</p>
            
            <div class="flex gap-3 max-w-md mx-auto form-row">
                <InputText 
                    v-model="email" 
                    placeholder="Your email address" 
                    class="flex-1 custom-input"
                    :class="{ 'error': error }"
                />
                <Button 
                    label="Subscribe" 
                    icon="pi pi-send" 
                    severity="danger" 
                    @click="subscribe" 
                />
            </div>
            
            <Message v-if="success" severity="success" :life="3000" class="mt-5 custom-message">
                <div class="flex items-center gap-2">
                    <i class="pi pi-check-circle"></i>
                    Thank you for subscribing!
                </div>
            </Message>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';

const email = ref('');
const error = ref(false);
const success = ref(false);

const subscribe = () => {
    if (!email.value || !email.value.includes('@')) {
        error.value = true;
        setTimeout(() => { error.value = false; }, 400);
        return;
    }
    success.value = true;
    email.value = '';
    setTimeout(() => { success.value = false; }, 3000);
};
</script>

<style scoped>
.newsletter {
    background-color: var(--color-cream-light);
    position: relative;
}

.pattern-bar {
    height: 8px;
    background: repeating-linear-gradient(
        90deg,
        var(--color-primary) 0px,
        var(--color-primary) 20px,
        var(--color-accent) 20px,
        var(--color-accent) 40px,
        var(--color-secondary) 40px,
        var(--color-secondary) 60px
    );
}

.pattern-bar.top {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
}

.pattern-bar.bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}

.form-row {
    position: relative;
    z-index: 1;
}

.custom-input {
    padding: 16px 24px !important;
    border: 2px solid var(--color-cream-pattern) !important;
    border-radius: 4px;
    background: var(--color-white) !important;
    color: var(--color-text-body) !important;
    flex: 1;
}

.custom-input:focus {
    border-color: var(--color-primary) !important;
    outline: none;
}

.custom-input.error {
    border-color: #e74c3c !important;
    animation: shake 0.4s ease;
}

.custom-message {
    position: relative;
    z-index: 1;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-8px); }
    75% { transform: translateX(8px); }
}
</style>
