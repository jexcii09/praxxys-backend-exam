<template>
    <div class="card">
        <div class="card-header">
            <label>Create Category</label>
            <button class="btn btn-danger float-end mb-2" @click="backToListing()">Cancel</button>
        </div>
        <div class="card-body contianer">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <input type="text" v-model="data.name" class="form-control" placeholder="Input Name" />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success float-end mb-2 mr-3" v-if="!this.pathId" @click="store()">Submit</button>
            <button class="btn btn-primary float-end mb-2 mr-3" v-if="this.pathId" @click="update(data.id)">Update</button>

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
                axios.post(config.base_url + config.end_point.categories, this.data)
                .then((response) => {
                    alert(response.data.response);
                   window.location.href = '/category/list';
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            show(id) {
                axios.get(config.base_url + config.end_point.categories + '/' + id)
                .then((response) => {
                    this.data = response.data.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            update(id) {
                axios.put(config.base_url + config.end_point.categories + '/' + id, this.data)
                .then((response) => {
                    alert(response.data.response);
                    window.location.href = '/category/list';
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            backToListing(){
                window.location.href = '/category/list';
            }
        }
    };

</script>

<style lang="css" scoped>

</style>