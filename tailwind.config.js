import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', 'Georgia', 'serif'],
            },
            colors: {
                primary: '#8B2323',
                accent: '#C8956C',
                'accent-coral': '#E07B5A',
                secondary: '#4A6741',
                cream: {
                    DEFAULT: '#FDF8F0',
                    light: '#FAF5EB',
                    pattern: '#E8DFD3',
                },
                'text-dark': '#2C1810',
                'text-body': '#5C4A3E',
            },
        },
    },

    plugins: [forms],
};
