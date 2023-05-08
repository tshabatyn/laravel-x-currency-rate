// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxtjs/tailwindcss',
    '@nuxtjs/color-mode',
    '@pinia/nuxt',
    '@pinia-plugin-persistedstate/nuxt',
  ],

  pinia: {
    autoImports: [
      // automatically imports `defineStore`
      'defineStore', // import { defineStore } from 'pinia'
      ['defineStore', 'definePiniaStore'], // import { defineStore as definePiniaStore } from 'pinia'
      'acceptHMRUpdate',
    ],
  },
  piniaPersistedstate: {
    cookieOptions: {
      sameSite: 'strict',
    },
    storage: 'localStorage'
  },

  imports: {
    dirs: ['stores'],
  },

  runtimeConfig: {
    public: {
      API_URL: process.env.API_URL,
    },
  },

  tailwindcss: {
    injectPosition: 0,
    viewer: true,
  },

  colorMode: {
    classSuffix: '',
    classPrefix: '',
  },

  devServer: {
    host: '0.0.0.0',
    port: 9000,
    https: false,
  }
})
