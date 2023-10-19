import { createApp } from 'vue'
import store from "./store/index.js";
import router from "./router/index.js";
import components from "./components/UI";
import directives from "./directives";
import "./css/main.css";
import axios from "axios";
import App from './App.vue'

const app = createApp(App);

components.forEach((component) => {
    app.component(component.name, component);
});
directives.forEach((directive) => {
    app.directive(directive.name, directive);
});

axios.defaults.withCredentials = true;
axios.defaults.baseURL = `${import.meta.env.VITE_API_BASE_URL}/`;
app.config.globalProperties.axios = axios;

store
    .dispatch("auth/me")
    .then(() => {
        app.use(router).use(store).mount("#app");
    })
    .catch((error) => {
        console.log(error);
    });
