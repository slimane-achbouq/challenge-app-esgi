<script setup>
import { RouterLink, RouterView } from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
</script>

<template>
  <router-view v-slot="slotProps">
            <component :is="slotProps.Component"></component>
  </router-view>
</template>

<style scoped>

</style>
