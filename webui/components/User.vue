<template>
  <div ref="userActions" class="w-full">
    <div @click="hideActions = !hideActions">
      <AvatarIcon class="w-6 h-6 text-gold hover:dark:text-amber-500 hover:text-amber-500" />
    </div>

    <ul :class="[{ 'hidden': hideActions }]"
        class="dropdown-menu min-w-max absolute bottom bg-amber-400/50 dark:bg-amber-200/70 text-amber-700 z-100 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 m-0 bg-clip-padding border-none"
        aria-labelledby="dropdownMenuButton1">
      <li @click="hideActions = !hideActions" v-show="isLoggedIn" @click.prevent="logout">
        <a
          class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-amber-700 hover:bg-amber-200"
          href="#">Logout</a>
      </li>
      <li @click="hideActions = !hideActions" v-show="!isLoggedIn">
        <NuxtLink
          class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-amber-700 hover:bg-amber-200"
          href="/register">Register</NuxtLink>
      </li>
      <li @click="hideActions = !hideActions" v-show="!isLoggedIn">
        <NuxtLink
          class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-amber-700 hover:bg-amber-200"
          href="/login">Login</NuxtLink>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import {ref} from "@vue/reactivity";
import {useAuthStore} from '~/stores/auth';
import {onClickOutside} from '@vueuse/core'
import {useRouter} from "#app";
import AvatarIcon from "~/components/icons/AvatarIcon.vue";

const authStore = useAuthStore()

async function logout() {
  authStore.logout().then(() => {
    useRouter().push('/').then(() => {
      location.reload()
    })
  })
}

const hideActions = ref(true)
const userActions = ref(null)
const isLoggedIn = ref(authStore.isAuthenticated)

onClickOutside(userActions, () => hideActions.value = true)

</script>
