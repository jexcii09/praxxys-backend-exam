<template>
    <div class="card">
        <div class="card-header">
            <label>Create Product</label>
            <button class="btn btn-danger float-end mb-2" @click="backToListing()">Cancel</button>
        </div>
        <div class="card-body contianer">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <input type="text" v-model="data.name" class="form-control" placeholder="Input Name" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <input type="text" v-model="data.category" class="form-control" placeholder="Input Category" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" v-model="data.description" class="form-control" placeholder="Input Description" />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success float-end mb-2 mr-3" v-if="!this.pathId" @click="store()">Submit</button>
            <button class="btn btn-primary float-end mb-2 mr-3" v-if="this.pathId" @click="update(data.id)">Update</button>

        </div>
    </div>



    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
        <img src="..." class="rounded me-2" alt="...">
        <strong class="me-auto">Bootstrap</strong>
        <small>11 mins ago</small>
        <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
        Hello, world! This is a toast message.
        </div>
    </div>
    </div>

</template>

<script>    
    import config from '../../config.js';
    import { useRoute } from 'vue-router';

    export default {
        data() {
            return {
                data: {},
                pathId: '',
            };
        },
        created(){
            // this.all();
        },
        mounted(){
            var pathname = window.location.pathname;
            var pathId = parseInt(pathname.split('/')[3]);

            if( Number.isInteger(pathId) ){
                this.pathId = pathId;
                this.show(this.pathId);
            }


        },
        methods: {
            store() {
                axios.post(config.base_url + config.end_point.products, this.data)
                .then((response) => {
                    alert(response.data.response);
                    window.location.href = '/product/list';
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            show(id) {
                axios.get(config.base_url + config.end_point.products + '/' + id)
                .then((response) => {
                    this.data = response.data.data;
                    console.log(this.data);
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            update(id) {
                axios.put(config.base_url + config.end_point.products + '/' + id, this.data)
                .then((response) => {
                    alert(response.data.response);
                    window.location.href = '/product/list';
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            backToListing(){
                window.location.href = '/product/list';
            }
        }
    };

</script>

<style lang="css" scoped>

</style>