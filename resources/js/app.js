import './bootstrap';

import { createApp } from 'vue';
import ProductList from "./components/product/list.vue";
import ProductForm from "./components/product/form.vue";
import CategoryList from "./components/category/list.vue";
import CategoryForm from "./components/category/form.vue";

const app = createApp({
    components: {
        ProductList,
        ProductForm,

        CategoryList,
        CategoryForm,
    }
});
app.mount("#app");