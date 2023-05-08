<template>
  <div class="navbar relative">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex justify-between border-b-2 border-gold-dark dark:border-moonlight">
        <div class="flex justify-between min-w-full md:min-w-0">
          <div class="md:hidden mt-4">
            <button @click="showSideDrawer = true" type="button"
                    class="bg-slate-900 dark:bg-gold text-gold dark:text-slate-900 rounded-md p-2 inline-flex focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gold"
                    aria-expanded="false">
              <span class="sr-only dark:bg-black">Open menu</span>
              <MenuIcon class="w-6 h-6"/>
            </button>
          </div>
          <div class="">
            <NuxtLink to="/">
              <span class="sr-only">Home</span>
              <LogoIcon
                class="h-16 md:h-24 w-auto transition duration-300 scale-50 md:hover:scale-75"
                alt="currency exchange rate portal logo"
              />
            </NuxtLink>
          </div>
        </div>
        <nav v-show="isLoggedIn" class="hidden md:visible md:flex justify-between space-x-10 align-bottom mt-14">
          <div class="md:flex space-x-10 align-bottom">
            <NuxtLink to="/currency-rates-today">
              <span
                class="text-base font-medium text-gold hover:text-amber-400">
                Currency rates for Today
              </span>
            </NuxtLink>
            <NuxtLink to="/currency-rates-month">
              <span
                class="text-base font-medium text-gold hover:text-amber-400">
                Currency rates for Month
              </span>
            </NuxtLink>
          </div>
        </nav>

        <div class="flex justify-between space-x-5 align-bottom mt-14">
          <!-- Begin: Color Theme Switcher -->
          <span
            class="hidden md:block"
            @click.prevent="setColorTheme($colorMode.preference == 'dark' ? 'light' : 'dark')"
          >
            <span v-show="$colorMode.value == 'dark'">
              <MoonIcon class="h-6 w-6"/>
            </span>
            <span v-show="$colorMode.value == 'light'">
                <SunIcon class="h-6 w-6"/>
            </span>
          </span>
          <!-- End: Color Theme Switcher -->
          <User :isLoggedIn="isLoggedIn" class="hidden md:block"/>
        </div>

      </div>
    </div>


    <!-- drawer component -->
    <div id="drawer-navigation my-12" :class="{ hidden: !showSideDrawer }"
         class="fixed z-40 top-0 h-screen transition-all duration-700 p-4 overflow-y-auto w-80 bg-gold-light/90 dark:bg-slate-900/90"
         tabindex="-1" aria-labelledby="drawer-navigation-label">
      <h5 id="drawer-navigation-label"
          class="text-base font-semibold uppercase">Menu</h5>

      <button @click="showSideDrawer = false" type="button" data-drawer-dismiss="drawer-navigation"
              aria-controls="drawer-navigation"
              class="bg-slate-900 dark:bg-gold text-gold dark:text-slate-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center">
        <CloseIcon/>
        <span class="sr-only">Close menu</span>
      </button>

      <div class="py-4 overflow-y-auto my-12">
        <ul class="space-y-2">
          <li v-show="isLoggedIn">
            <NuxtLink to="/currency-rates-today">
              <span
                class="text-base font-medium text-gold dark:text-moonlight hover:text-amber-400">
                Currency rates for Today
              </span>
            </NuxtLink>
          </li>
          <li v-show="isLoggedIn">
            <NuxtLink to="/currency-rates-month">
              <span
                class="text-base font-medium text-gold dark:text-moonlight hover:text-amber-400">
                Currency rates for Month
              </span>
            </NuxtLink>
          </li>
          <li
            class="flex items-center pt-2 text-base font-normal rounded-lg">
            <button
              class="ml-2"
              @click.prevent="setColorTheme($colorMode.preference == 'dark' ? 'light' : 'dark')"
            >
              <span v-show="$colorMode.value == 'dark'">
                <MoonIcon class="h-6 w-6"/>
              </span>
              <span v-show="$colorMode.value == 'light'">
                <SunIcon class="h-6 w-6"/>
              </span>
            </button>
          </li>
          <li v-show="!isLoggedIn"
              class="flex items-center p-2 text-base font-normal rounded-lg">
            <NuxtLink to="/login">
              <LoginIcon class="w-6 h-6 inline-flex"/>
              <span class="flex-1 ml-3 whitespace-nowrap">Login</span>
            </NuxtLink>
          </li>
          <li v-show="!isLoggedIn"
              class="flex items-center p-2 text-base font-normal rounded-lg">
            <NuxtLink to="/register">
              <RegisterIcon class="w-6 h-6 inline-flex"/>
              <span class="flex-1 ml-3 whitespace-nowrap">Register</span>
            </NuxtLink>
          </li>
          <li @click.prevent="logout" v-show="isLoggedIn"
              class="flex items-center p-2 text-base font-normal rounded-lg">
            <LogoutIcon class="w-6 h-6"/>
            <span class="flex-1 ml-3 whitespace-nowrap">Logout</span>
          </li>
        </ul>


      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import {useAuthStore} from "~/stores/auth";
import {useRouter} from "#app";
import LogoIcon from "~/components/icons/LogoIcon.vue";
import MenuIcon from "~/components/icons/MenuIcon.vue";
import CloseIcon from "~/components/icons/CloseIcon.vue";
import MoonIcon from "~/components/icons/MoonIcon.vue";
import SunIcon from "~/components/icons/SunIcon.vue";
import LogoutIcon from "~/components/icons/LogoutIcon.vue";
import RegisterIcon from "~/components/icons/RegisterIcon.vue";
import LoginIcon from "~/components/icons/LoginIcon.vue";

const showSideDrawer = ref(false)
const authStore = useAuthStore()
const router = useRouter()
const colorMode = useColorMode()

const isLoggedIn = ref(authStore.isAuthenticated)

async function logout() {
  showSideDrawer.value = true
  authStore.logout().then(() => {
    router.push('/').then(() => {
      location.reload()
    })
  })
}

router.afterEach(() => {
  showSideDrawer.value = false
})

const setColorTheme = (newTheme: Theme) => {
  colorMode.preference = newTheme
}
</script>
