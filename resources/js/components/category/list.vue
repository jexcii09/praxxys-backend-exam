<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <label>Categories List</label>
                <button class="btn btn-success float-end mb-2" @click="goToFormCreate()">Create New</button>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(category, key) in categories.data" :key="key">
                            <td>{{category.id}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <a :href="editCategoryLink(category.id)" class="text-primary">Edit</a> |
                                <a href="javascript:void(0)" class="text-danger" data-coreui-toggle="modal" data-coreui-target="#deleteCategoryModal" @click="openModal(category.id)">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" v-for="(value, key) in categories.links" 
                        :class="{'active' : value.active == true, 'disabled' : value.url == null}" 
                        :key="key">
                            <a class="page-link" href="javascript:void(0)" @click="paginate(value.url)" v-html="value.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal" ref="Close">No</button>
                    <button type="button" class="btn btn-primary" @click="deleteCategory(deleteModalId)">Yes</button>
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
                categories: {},
                deleteModalId: 0,
                filter: {
                    paginate : 1,
                    per_page: 5,
                    page: 1,
                    order_by: ''
                },
            };
        },
        created() {
            this.all(this.filter);
        },
        methods: {
            all(query) {
                axios.get(config.base_url + config.end_point.categories, {params: query})
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            deleteCategory(id) {
                if (this.deleteModalId !== 0) {
                    axios.delete(config.base_url + config.end_point.categories + '/' + id)
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
                window.location.href = '/category/create';
            },
            editCategoryLink(categoryId) {
                // You can generate the dynamic href here based on categoryId
                return `/category/edit/${categoryId}`;
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
