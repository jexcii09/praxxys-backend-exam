import './bootstrap';

import { createApp } from 'vue';
import ProductList from "./components/product/list.vue";

const app = createApp({
    components: {
        ProductList
    }
});
app.mount("#app");