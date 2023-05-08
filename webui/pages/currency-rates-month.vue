<template>
  <div class="container max-w-5xl mx-auto mt-5 px-5">
    <h1 class="text-3xl font-bold">
      Currency rates (Month)
    </h1>
    <div class="container" v-show="rate?.rate !== null">
      <h3 class="my-5 text-xl font-bold">{{ rate?.currencies }}</h3>
      <div class="my-5">Exchange rate between {{ rate?.currencies }} for the past month are the following</div>
      <dl class="divide-y divide-gold-dark dark:divide-moonlight">

        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6 text-gold">Date</dt>
          <dd class="mt-1 text-sm leading-6 sm:mt-0 text-gold">Rate</dd>
        </div>

        <div v-for="rate in rate.rates"
             :key="rate.date"
             class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
          <dt class="text-sm font-medium leading-6">{{ rate?.date }}</dt>
          <dd class="mt-1 text-sm leading-6 sm:mt-0">{{ rate?.rate }}</dd>
        </div>

      </dl>
    </div>
  </div>
</template>

<script setup>
definePageMeta({middleware: ['auth']});
import {useCurrencyRates} from "~/stores/currencyRates";

const currencyRates = useCurrencyRates();

let rate = ref({rates: null, currencies: null});
rate.value = await currencyRates.getMonthRates()
</script>
