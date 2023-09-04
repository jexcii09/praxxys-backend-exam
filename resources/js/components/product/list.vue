<template>
    <div class="container mt-5">
        <button class="btn btn-success float-end mb-2">Create New</button>
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, key) in products.data" :key="key">
                    <td>{{product.id}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.category}}</td>
                    <td>{{product.description}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>    
    import config from '../../config.js';

    export default {
        data() {
            return {
                products: {},
            };
        },
        created(){
            this.all();
        },
        methods: {
            all() {
                let params = {
                    paginate: true,
                    per_page: 2,
                }

                axios.get(config.base_url + config.end_point.products, {params})
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
        }
    };

</script>

<style lang="css" scoped>

</style>