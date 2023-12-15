import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './index.css'
import { createAuth0 } from '@auth0/auth0-vue'
import mitt from 'mitt'

const emitter = mitt()
const app = createApp(App)

app.use(router)
app.use(
  createAuth0({
    domain: import.meta.env.VITE_API_DOMAIN,
    clientId: import.meta.env.VITE_API_CLIENT_ID,
    authorizationParams: {
      redirect_uri: window.location.origin,
      audience: import.meta.env.VITE_API_AUDIENCE
    }
  })
)
app.config.globalProperties = {
  emitter: emitter,
  logged_in: false
}
app.mount('#app')
