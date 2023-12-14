import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import './index.css'
import { createAuth0 } from '@auth0/auth0-vue';

const app =createApp(App);
app.use(router);
app.use(
    createAuth0({
      domain: "attilafricz.eu.auth0.com",
      clientId: "CD8kx6qZ7JRO8fUffeuYF95wT56aTfDH",
      authorizationParams: {
        redirect_uri: window.location.origin,
        audience: "https://github.com/auth0/laravel-auth0",
      }
    })
  );
  
app.mount("#app");