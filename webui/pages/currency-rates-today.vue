<template>
  <div class="max-w-5xl mx-auto mt-5 px-5">
    <h1 class="text-3xl font-bold container">
      Currency rates (Today)
    </h1>
    <div v-show="rate?.rate !== null">
      <h3 class="my-5 text-xl font-bold container">{{ rate?.currencies }}</h3>
      <div class="my-5">
        Today exchange rate between
        <span class="text-gold">{{ rate?.currencies }}</span> is
        <span class="text-gold">{{ rate?.rate }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({middleware: ['auth']});
import {useCurrencyRates} from "~/stores/currencyRates";
const currencyRates = useCurrencyRates();

let rate = ref({rate: null, currencies: null});
rate.value = await currencyRates.getTodayRates()
</script>
