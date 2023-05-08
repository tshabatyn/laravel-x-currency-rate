<template>
  <div>
    <div class="flex items-center justify-center px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full">
        <div class="lg:flex mt-10">
          <h1 class="py-9 text-center text-5xl font-extrabold">
            Currency exchange rate portal
          </h1>
        </div>
        <div>
          <h2 class="text-center text-3xl font-extrabold mt-5">
            Sign In
          </h2>
        </div>
        <div v-if="response?.hasErrors && errors"
             class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3" role="alert">
          <ul class="block sm:inline">
            <li v-for="[key, value] in errors">
              {{ value.message }}
            </li>
          </ul>
        </div>
        <form v-on:submit.prevent class="mt-8 space-y-6" action="#" method="POST">

          <div class="rounded-md shadow-sm -space-y-px mb-1">
            <div>
              <label for="email-address" class="sr-only">Username or Email</label>
              <input type="email" v-model="email" id="email" name="email" required
                     class="dark:bg-slate-500 dark:text-white dark:placeholder-white appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm"
                     :class="errors?.has('email') ? ' border-red-500' : ''" placeholder="Email"/>

              <label for="password" class="sr-only">Password</label>
              <input v-model="password" id="password" name="password" type="password" autocomplete="current-password"
                     required
                     class="dark:bg-slate-500 dark:text-white dark:placeholder-white appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm"
                     :class="errors?.has('password') ? ' border-red-500' : ''" placeholder="Password"/>
            </div>
          </div>
        </form>
        <button @click.prevent="postLoginForm"
                class="text-sm text-gold-light hover:text-gold bg-gold-dark dark:hover:bg-gold-light mt-5 group relative w-full flex justify-center py-2 px-4 border border-transparent font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <LockIcon class="h-5 w-5 text-gold-light group-hover:text-gold" />
          </span>
          Login
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({middleware: ['guest']});
import {useAuthStore} from "~/stores/auth";
import {ref} from "@vue/reactivity";
import type {Ref} from "vue"
import {useRouter} from "#app";
import LockIcon from "~/components/icons/LockIcon.vue";

const authStore = useAuthStore();

if (authStore.isAuthenticated) {
  await useRouter().push('/');
}

const email = ref('')
const password = ref('')

const errors: Ref<Map<string, { message: InputValidation; }> | undefined> = ref(new Map<string, {
  message: InputValidation
}>())

let response: FormValidation

definePageMeta({
  middleware: 'guest'
})

async function postLoginForm() {
  response = await authStore.login(email.value, password.value);
  if (response.hasErrors != false) {
    errors.value = response.errors
  }
  await useRouter().push('/')
  location.reload()
}
</script>
