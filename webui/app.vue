<template>
  <div class="h-full">
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>

<script setup lang="ts">
useHead({
  bodyAttrs: {
    class: 'bg-gold-light text-gold-dark dark:bg-slate-900 dark:text-slate-200'
  }
});
</script>
