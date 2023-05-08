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
            Sign Up
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
          <input type="hidden" name="remember" value="true" />
          <div class="rounded-md shadow-sm -space-y-px mb-1">
            <div>
              <label for="name" class="sr-only">Name</label>
              <input v-model="name" id="name" name="name" required
                     class="appearance-none dark:bg-slate-500 dark:text-white dark:placeholder-white rounded-none relative block w-full px-3 py-2 m-0 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm"
                     :class="errors?.has('name') ? ' border-red-500' : ''" placeholder="Name" />

              <label for="email-address" class="sr-only">Email address</label>
              <input v-model="email" id="email-address" name="email" type="email" autocomplete="email" required
                     class="dark:bg-slate-500 dark:text-white dark:placeholder-white appearance-none rounded-none relative block w-full px-3 py-2 m-0 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm"
                     :class="errors?.has('email') ? ' border-red-500' : ''" placeholder="Email address" />

              <label for="password" class="sr-only">Password</label>
              <input v-model="password" id="password" name="password" type="password" autocomplete="current-password"
                     required
                     class="dark:bg-slate-500 dark:text-white dark:placeholder-white appearance-none rounded-none relative block w-full px-3 py-2 m-0 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-amber-500 focus:border-amber-500 focus:z-10 sm:text-sm"
                     :class="errors?.has('password') ? ' border-red-500' : ''" placeholder="Password" />
            </div>
          </div>

          <div class="flex items-center justify-between">
            <div class="text-sm">
              <a href="#" class="font-medium text-amber-600 hover:text-amber-500">
                Forgot your password?
              </a>
            </div>
          </div>

          <div></div>
        </form>
        <button @click.prevent="postRegisterForm"
                class="text-sm text-gold-light hover:text-gold bg-gold-dark dark:hover:bg-gold-light mt-5 group relative w-full flex justify-center py-2 px-4 border border-transparent font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <LockIcon class="h-5 w-5" />
          </span>
          Register
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import LockIcon from "~/components/icons/LockIcon.vue";

definePageMeta({middleware: ['guest']});
import { ref } from "@vue/reactivity";
import {useAuthStore} from "#imports";
import type { Ref } from "vue"

const email: Ref<string> = ref('');
const password: Ref<string> = ref('');
const name: Ref<string> = ref('');

const errors: Ref<Map<string, { message: InputValidation; }> | undefined> = ref(new Map<string, { message: InputValidation }>())
let response: FormValidation

async function postRegisterForm() {
  const authStore = useAuthStore();
  response = await authStore.register(name.value, email.value, password.value);
  if (response.hasErrors != false) {
    errors.value = response.errors
  }
  await useRouter().push('/')
}

</script>
