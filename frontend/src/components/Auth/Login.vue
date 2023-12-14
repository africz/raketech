<template>
  <div>
    <button @click="login">Log in</button>
  </div>
</template>
<script>
import { useAuth0 } from '@auth0/auth0-vue'

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Login',
  setup() {
    const { loginWithRedirect } = useAuth0()

    return {
      login: () => {
        loginWithRedirect()
      }
    }
  }
}
</script>
