import {defineNuxtRouteMiddleware, useNuxtApp} from "#app";
import {useAuthStore} from "~/stores/auth";

export default defineNuxtRouteMiddleware(async(to) => {
  const authStore = useAuthStore()

  if (authStore.isNotAuthenticated) {
    return '/login'
  }
})
