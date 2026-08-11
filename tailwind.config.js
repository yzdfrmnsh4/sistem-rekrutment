/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: '#f0f7ff',
          100: '#e0effe',
          600: '#0284c7', // Warna utama PT Sariling Aneka Energi
          700: '#0369a1',
          900: '#0c4a6e',
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
