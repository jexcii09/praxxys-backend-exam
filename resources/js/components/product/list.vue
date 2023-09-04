<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <label>Products List</label>
                <button class="btn btn-success float-end mb-2" @click="goToFormCreate()">Create New</button>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, key) in products.data" :key="key">
                            <td>{{product.id}}</td>
                            <td>{{product.name}}</td>
                            <td>{{product.category.name}}</td>
                            <td>{{product.description}}</td>
                            <td>
                                <a :href="editProductLink(product.id)" class="text-primary">Edit</a> |
                                <a href="javascript:void(0)" class="text-danger" data-coreui-toggle="modal" data-coreui-target="#deleteProductModal" @click="openModal(product.id)">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>

    </div>


    <div class="modal fade" id="deleteProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Product</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal" ref="Close">No</button>
                    <button type="button" class="btn btn-primary" @click="deleteProduct(deleteModalId)">Yes</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import config from '../../config.js';

    export default {
        data() {
            return {
                products: {},
                deleteModalId: 0,
            };
        },
        created() {
            this.all();
        },
        methods: {
            all() {
                let params = {
                    paginate: true,
                    per_page: 100,
                }

                axios.get(config.base_url + config.end_point.products, {
                        params
                    })
                    .then((response) => {
                        this.products = response.data;
                    })
                    .catch((error) => {
                        alert(error);
                        console.log(error);
                    });
            },
            deleteProduct(id) {
                if (this.deleteModalId !== 0) {
                    axios.delete(config.base_url + config.end_point.products + '/' + id)
                        .then((response) => {
                            this.$refs.Close.click();
                            this.all();
                            this.deleteModalId = 0;
                            alert(response.data.response);
                        })
                        .catch((error) => {
                            alert(error);
                            console.log(error);
                        });
                }

            },
            openModal(id) {
                this.deleteModalId = id;
            },
            goToFormCreate() {
                window.location.href = '/product/create';
            },
            editProductLink(productId) {
                // You can generate the dynamic href here based on productId
                return `/product/edit/${productId}`;
            }
        }
    };

</script>

<style lang="css" scoped>

</style>
