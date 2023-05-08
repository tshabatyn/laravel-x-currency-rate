import {useRouter} from "#app";
import useErrorMapper from "~/composables/useErrorMapper";

export const useAuthStore = defineStore('AuthStore', {
  state: () => ({
    token: null,
    user: null,
    apiBaseURL: useRuntimeConfig()?.public?.API_URL,
  }),
  getters: {
    isAuthenticated: (state) => state.token !== null,
    isNotAuthenticated: (state) => state.token === null,
    authToken: (state) => state.token,
  },
  actions: {
    async register(name, email, password) {
      try {
        const result = await $fetch(
          this.apiBaseURL + '/api/auth/register', {
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
            },
            method: 'POST',
            body: {name: name, email: email, password: password},
          })

        if (!result?.token || !result?.user) {
          throw Error('We cannot find this combination of email and password.')
        }
        this.token = result.token
        this.user = result.user

        return {hasErrors: false, loggedIn: true}
      } catch (error: any) {
        return useErrorMapper(error)
      }
    },

    async login(email, password) {
      try {
        const result = await $fetch(
          this.apiBaseURL + '/api/auth/login', {
            method: 'POST',
            body: {email: email, password: password}
          })

        if (!result?.token || !result?.user) {
          throw Error('We cannot find this combination of email and password.')
        }
        this.token = result.token
        this.user = result.user

        return {hasErrors: false, loggedIn: true}
      } catch (error: any) {
        return useErrorMapper(error)
      }
    },

    async logout() {
      try {
        await $fetch(
          this.apiBaseURL + '/api/auth/logout',
          {
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "Authorization": 'Bearer ' + this.token,
            },
          })

        this.token = null;
        this.user = null;
      } catch (error: any) {
        this.token = null;
        this.user = null;
      }
    },

    async getUser() {
      if (!this.user?.id) {
          $fetch(
            this.apiBaseURL + '/api/auth/user',
            {
              headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "Authorization": 'Bearer ' + this.token,
              },
            }).then((respons) => {
            this.user = respons;
          }).catch((error) => {
            console.error(error)
          })
      }
      return this.user
    },

  },
  persist: true,
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot))
}
