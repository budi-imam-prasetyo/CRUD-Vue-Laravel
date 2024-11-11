import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import './style.css';
import CardComponent from './components/card.vue'

const app = createApp(App);
app.component("CardComponent", CardComponent)

app.use(router);
app.mount("#app");
