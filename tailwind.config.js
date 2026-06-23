import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'kas-primary': '#2F5D34',
                'kas-secondary': '#4F7A3F',
                'kas-gold': '#D4A62A',
                'kas-bg': '#F8FAF5',
                'kas-border': '#E5E7EB',
                'kas-text': '#1F2937',
            },
        },
    },

    plugins: [forms],
};
