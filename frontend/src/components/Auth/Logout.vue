<template>
  <a
    href="#"
    class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium"
    aria-current="page"
    @click="logout"
    >Logout</a
  >
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
