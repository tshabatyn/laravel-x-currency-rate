<template>
  <div class="navbar relative">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex justify-between  border-b-2 border-gray-100">
        <div class="flex justify-between min-w-full md:min-w-0">
          <div class="md:hidden mt-4 bg-black">
            <button @click="showSideDrawer = true" type="button"
                    class="bg-white rounded-md p-2 inline-flex  text-gray-400 hover:text-gray-500 dark:bg-black dark:text-gray-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    aria-expanded="false">
              <span class="sr-only dark:bg-black">Open menu</span>
              <svg class="h-6 w-6 dark:bg-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
            </button>
          </div>
          <div class="">
            <NuxtLink to="/">
              <span class="sr-only">Home</span>
              <LogoIcon class="h-16 md:h-24 w-auto transition duration-500 scale-50 md:hover:scale-75" />
            </NuxtLink>
          </div>
        </div>
<!--        <nav class="hidden md:flex justify-between space-x-10 align-bottom mt-14">-->
<!--          <div class="hidden md:flex space-x-10 align-bottom">-->
<!--            <NuxtLink to="/topics">-->
<!--              <span-->
<!--                class="text-base font-medium text-gray-500 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-300 ">-->
<!--                Topics-->
<!--              </span>-->
<!--            </NuxtLink>-->
<!--          </div>-->
<!--        </nav>-->

        <div class="flex justify-between space-x-5 align-bottom mt-14">
          <!-- Begin: Color Theme Switcher -->
          <span class="hidden md:block " @click="setColorTheme($colorMode.preference == 'dark' ? 'light' : 'dark')">
            <svg v-if="$colorMode.value == 'dark'" xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-gray-50 lg:block hover:dark:text-gold hover:text-gold"
                 viewBox="0 0 20 20"
                 fill="currentColor">
              <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
            </svg>
            <svg v-if="$colorMode.value == 'light'" xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 lg:block hover:dark:text-gold hover:text-gold"
                 viewBox="0 0 20 20" fill="currentColor ">
              <path fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    clip-rule="evenodd"/>
            </svg>
          </span>
          <!-- End: Color Theme Switcher -->
          <User :isLoggedIn="isLoggedIn" class="md:block"/>
        </div>

      </div>
    </div>


    <!-- drawer component -->
    <div id="drawer-navigation my-12" :class="{ hidden: !showSideDrawer }"
         class="fixed z-40 top-0 h-screen  transition-all duration-700   p-4 overflow-y-auto bg-white w-80 dark:bg-black"
         tabindex="-1" aria-labelledby="drawer-navigation-label">
      <h5 id="drawer-navigation-label"
          class="text-base font-semibold text-gray-500 dark:text-gray-200 uppercase hover:dark:text-green-400 hover:text-green-400">
        Menu
      </h5>

      <button @click="showSideDrawer = false" type="button" data-drawer-dismiss="drawer-navigation"
              aria-controls="drawer-navigation"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-500 dark:text-gray-200 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-black dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
      </button>

      <div class="py-4 overflow-y-auto my-12">
        <ul class="space-y-2">
          <li>
            <button class="ml-2" @click="setColorTheme($colorMode.preference == 'dark' ? 'light' : 'dark')">
              <svg v-if="$colorMode.value == 'dark'" xmlns="http://www.w3.org/2000/svg"
                   class="h-6 w-6 text-gray-500 dark:text-gray-200" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
              </svg>
              <svg v-if="$colorMode.value == 'light'" xmlns="http://www.w3.org/2000/svg"
                   class="h-6 w-6 text-gray-500 dark:text-gray-200" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                      clip-rule="evenodd"/>
              </svg>
            </button>
          </li>
          <li v-if="!isLoggedIn">
            <NuxtLink to="/login"
                      class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
              </svg>
              <span class="flex-1 ml-3 whitespace-nowrap">Sign In</span>
            </NuxtLink>
          </li>
          <li v-if="!isLoggedIn">
            <NuxtLink to="/register"
                      class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
              </svg>

              <span class="flex-1 ml-3 whitespace-nowrap">Sign Up</span>
            </NuxtLink>
          </li>
          <li @click="logout" v-if="isLoggedIn">
            <NuxtLink to="/register"
                      class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                   stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
              </svg>
              <span class="flex-1 ml-3 whitespace-nowrap">logout</span>
            </NuxtLink>
          </li>
        </ul>


      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
import {userLogout} from "~/composables/useAuth";
import LogoIcon from "~/components/LogoIcon.vue";

const showSideDrawer = ref(false)
const logout = userLogout
const router = useRouter()
const colorMode = useColorMode()

const user = useState('user')
const initialCheck = await useLoggedIn()
const isLoggedIn = ref(initialCheck)

router.afterEach(() => {
  showSideDrawer.value = false
})

const setColorTheme = (newTheme: Theme) => {
  colorMode.preference = newTheme
}

async function checkIfLoggedIn() {
  const check = await useLoggedIn()
  isLoggedIn.value = check
}

watch(user, async () => {
  await checkIfLoggedIn()
}, {deep: true});

</script>
