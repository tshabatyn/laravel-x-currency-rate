/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./components/**/*.{js,vue,ts}",
    "./layouts/**/*.vue",
    "./pages/**/*.vue",
    "./plugins/**/*.{js,ts}",
    "./nuxt.config.{js,ts}",
    "./app.vue",
    "./error.vue",
  ],
  theme: {
    extend: {
      colors: {
        'gold': '#FFD700',
        'gold-dark': '#383018',
        'gold-light': '#968141',
        'moonlight': '#c0c0c0',
      }
    },
  },
  plugins: [],
}
