// tailwind.config.js (ESM)
import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'
import daisyui from 'daisyui'
// import themes from 'daisyui/src/theming/themes.js' // aman di ESM

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{js,ts,vue}',
    './storage/framework/views/*.php',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        // GANTI dengan font-mu (mis. "Instrument Sans")
        sans: ['Arimo', ...defaultTheme.fontFamily.sans],
        customtitle: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        // ung: { 900: '#0a2a66', 800: '#123881' },
      },
    },
  },
  plugins: [forms, daisyui], // gabung jadi SATU array
  daisyui: {
     // Tanpa deep import. Definisikan langsung.
    themes: [
      {
        light: {
        //   primary: '#0a2a66',
        //   secondary: '#0EA5E9',
        //   accent: '#2563eb',
        //   neutral: '#1f2937',
        //   'base-100': '#ffffff',
        },
      },
    ],
    darkTheme: 'light',
  },
}