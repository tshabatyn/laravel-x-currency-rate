// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxtjs/tailwindcss',
    '@nuxtjs/color-mode',
    // 'nuxt-icon',
  ],

  tailwindcss: {
    injectPosition: 0,
    viewer: true,
  },

  colorMode: {
    classSufix: '',
    classPrefix: '',
  },

  devServer: {
    host: '0.0.0.0',
    port: 9000,
    https: false,
  }
})
