<template>
  <div class="h-screen min-h-full">
    <Navbar />
    <slot />
  </div>
</template>

<script setup lang="ts">
import Navbar from '~/components/layout/navbar.vue'
</script>
