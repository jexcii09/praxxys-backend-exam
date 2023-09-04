import './bootstrap';

import { createApp } from 'vue';
import ProductList from "./components/product/list.vue";
import ProductForm from "./components/product/form.vue";

const app = createApp({
    components: {
        ProductList,
        ProductForm
    }
});
app.mount("#app");