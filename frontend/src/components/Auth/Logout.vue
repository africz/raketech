<template>
  <div>
    <button @click="logout">Log out</button>
  </div>
</template>
<script>
import { useAuth0 } from '@auth0/auth0-vue'

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Logout',
  setup() {
    const { logout } = useAuth0()

    return {
      logout: () => {
        logout({ logoutParams: { returnTo: window.location.origin } })
      }
    }
  }
}
</script>
