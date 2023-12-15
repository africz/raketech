<script setup>
import { FlagList, Header } from '@/components'
</script>

<template>
  <main>
    <Header />
    <p class="info">Please log in to see the flags!</p>
    <FlagList />
  </main>
</template>

<style scoped>
  .info{
    margin-top:2rem;
    margin-left:3rem;
  }
</style>
