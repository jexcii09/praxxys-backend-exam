<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <label>Products List</label>
                <button class="btn btn-success float-end mb-2" @click="goToFormCreate()">Create New</button>
            </div>
            <div class="card-body">
                <!-- SEARCH -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-control" v-model="filter.category_id">
                            <option value="" selected>Select Category</option>
                            <option v-for="(category, key) in categoriesSearch" :key="key" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Search" v-model="filter.keyword"/>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success" @click="search()">
                            <i class="nav-icon cil-search"></i> Search
                        </button>
                        <a href="javascript:void(0)" class="text-danger float-end mt-2" @click="clearSearch()">
                            <i class="nav-icon cil-x"></i> Clear
                        </a>
                    </div>
                </div>


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
                            <td>{{product.category?.name}}</td>
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
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" v-for="(value, key) in products.links" 
                        :class="{'active' : value.active == true, 'disabled' : value.url == null}" 
                        :key="key">
                            <a class="page-link" href="javascript:void(0)" @click="paginate(value.url)" v-html="value.label"></a>
                        </li>
                    </ul>
                </nav>
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
        props: ['token'],
        data() {
            return {
                products: {},
                deleteModalId: 0,
                categoriesSearch: {},
                filter: {
                    paginate : 1,
                    per_page: 5,
                    page: 1,
                    category_id: '',
                    keyword: ''
                },
            };
        },
        created() {
            this.all(this.filter);
            this.getCategoriesForSearch();
            
        },
        mounted(){
            console.log(this.token);
        },
        methods: {
            all(query) {
                axios.get(config.base_url + config.end_point.products, {params: query})
                .then((response) => {
                    this.products = response.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            getCategoriesForSearch(){
                axios.get(config.base_url + config.end_point.categories)
                .then((response) => {
                    this.categoriesSearch = response.data.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            search(){
                var query = {
                    paginate : 1,
                    per_page: 5,
                    page: 1,
                    category_id: this.filter.category_id,
                    keyword: this.filter.keyword
                };
                this.all(query);
            },
            clearSearch(){
                this.filter = {
                    paginate : 1,
                    per_page: 5,
                    page: 1,
                    category_id: '',
                    keyword: ''
                };
                this.all(this.filter);
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
            },


            paginate(url){
                const page = this.splitUrlPaginate(url);
                this.filter.page = page;
                this.all(this.filter);
            },

            splitUrlPaginate(url){
                const page = url.split('?');
                if(page.length == 2) {
                    let vars = page[1].split('&');
                    let getVars = {};
                    let tmp = '';
                    vars.forEach(function(v) {
                    tmp = v.split('=');
                    if(tmp.length == 2)
                        getVars[tmp[0]] = tmp[1];
                    });
                    return getVars.page;
                }
            }
        }
    };

</script>

<style lang="css" scoped>

</style>
