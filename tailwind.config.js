import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",


    ],
    safelist: [
        'flex', 'flex-col', 'lg:flex-row', 'lg:justify-between', 'lg:items-center',
        'mb-4', 'lg:mb-0', 'flex-1', 'lg:max-w-xs'
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                colors: {
                    principal: '#0097A7', // 👈 color personalizado

                },
            },
        },
    },

    plugins: [forms],
};
