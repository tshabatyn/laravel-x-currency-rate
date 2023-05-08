import {useAuthStore} from "~/stores/auth";

const authStore = useAuthStore()

export const useCurrencyRates = defineStore('CurrencyRates', {
  state: () => ({
    today: null,
    month: null,
    apiBaseURL: useRuntimeConfig()?.public?.API_URL,
  }),
  getters: {
    //
  },
  actions: {

    async getTodayRates() {
      if (this.today === null || this.today === undefined) {
        this.today = await $fetch(
          this.apiBaseURL + '/api/currency-rates/today?' + new URLSearchParams({
            currencies: 'EUR-USD',
          }), {
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "Authorization": 'Bearer ' + authStore.authToken,
            },
          }
        )
      }

      return this.today
    },

    async getMonthRates() {
      if (this.month === null || this.month === undefined) {
        this.month = await $fetch(
          this.apiBaseURL + '/api/currency-rates/month?' + new URLSearchParams({
            currencies: 'EUR-USD',
          }), {
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "Authorization": 'Bearer ' + authStore.authToken,
            },
          }
        )
      }

      return this.month
    },

  }
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useCurrencyRates, import.meta.hot))
}
