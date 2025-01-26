import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                kodamaWhite: '#E8F5FC',
                darkKnight: '#0F172A',
                sapphireGlitter: '#0133CC',
                islamicGreen: '#009900',
                sunflowerIsland: '#FFC900',
                redNew: '#FF0000',
                plumb: '#64748B',
            },
        },
    },

    plugins: 
    [forms, require('flowbite/plugin',)],
    
};
