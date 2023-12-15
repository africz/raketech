<script setup>
import { FlagList, Header } from '@/components'
</script>

<template>
  <main>
    <Header />
    <p v-if="logged_in" class="info">Please log in to see the flags!</p>
    <FlagList />
  </main>
</template>
<script>
export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'HomeView',
  data() {
    return {
      logged_in: false
    }
  },
  create() {
    this.emitter.on('logged_in', (event) => {
      this.logged_in = event.logged_in
      this.$forceUpdate()
      console.log('Home,logged_in:', this.logged_in)
    })
  }
}
</script>

<style scoped>
.info {
  margin-top: 2rem;
  margin-left: 3rem;
}
</style>
