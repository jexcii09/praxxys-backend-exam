<template>
    <div class="card">
        <div class="card-header">
            <label v-if="!this.pathId" class="mt-2">Create Product</label>
            <label v-if="this.pathId" class="mt-2">Update Product</label>
            <button class="btn btn-danger float-end mb-2" @click="backToListing()">Cancel</button>
        </div>

        <div class="card-body contianer">

            <nav class="breadcrumbs mb-3">
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active text-uppercase' : currentTab == 1}">Step 1</a>
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active text-uppercase' : currentTab == 2}">Step 2</a> 
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active text-uppercase' : currentTab == 3}">Step 3</a>
            </nav>

            <!-- STEP 1 -->
            <div class="step1" id="step1" ref="Step1" v-show="currentTab == 1">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="text" v-model="data.name" class="form-control" 
                        :class="{'is-invalid' : errors.name && errors.name == 'true'}" placeholder="Input Name" />
                        <div v-if="errors && errors.name == 'true'" class="text-danger">
                            <small class="ml-3">Name is required</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" v-model="data.category_id"
                        :class="{'is-invalid' : errors.category_id && errors.category_id == 'true'}">
                            <option value="" selected disabled>Select Category</option>
                            <option v-for="(category, key) in categories" :key="key" :value="category.id">{{ category.name }}</option>
                        </select>
                        <div v-if="errors && errors.category_id == 'true'" class="text-danger">
                            <small class="ml-3">Category is required</small>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="text" v-model="data.description" class="form-control" 
                        :class="{'is-invalid' : errors.description && errors.description == 'true'}" placeholder="Input Description" />
                        <div v-if="errors && errors.description == 'true'" class="text-danger">
                            <small class="ml-3">Description is required</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary mb-2 mr-3" @click="proceedStep2()">Proceed</button>
                    </div>
                </div>
            </div>


            <!-- STEP 2 -->
            <div class="step2" id="step2" ref="Step2" v-show="currentTab == 2">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Upload Images</label>
                        <!-- <input type="file" class="form-control"/> -->
                        <input type="file" @change="uploadFile" class="form-control" ref="file"
                        :class="{'is-invalid' : errors.images && errors.images == 'true'}" accept=".png, .jpg, .jpeg" multiple>
                        <div v-if="errors && errors.images == 'true'" class="text-danger">
                            <small class="ml-3">Image is required</small>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="data.images">
                    <div class="col-md-3" v-for="(image, key) in data.images" :key="key">
                        <img :src="image.path" class="img-thumbnail" />
                        <a href="javascript:void(0)" class="text-danger float-end" @click="removeImage(key)">
                            <small><i class="nav-icon cil-x"></i> Remove</small>
                        </a>
                    </div>
                </div>
            

                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-block btn-outline-danger pr-4" @click="backStep1()">Back</button>
                        <button class="btn btn-outline-primary" @click="proceedStep3()">Proceed</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="step3" id="step3" ref="Step3" v-show="currentTab == 3">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="datetime-local" class="form-control" v-model="data.date" :class="{'is-invalid' : errors.date && errors.date == 'true'}">
                        <div v-if="errors && errors.date == 'true'" class="text-danger">
                            <small class="ml-3">Date is required</small>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-danger" @click="backStep2()">Back</button>
                        <button class="btn btn-success" v-if="!this.pathId" @click="store()">Submit</button>
                        <button class="btn btn-primary" v-if="this.pathId" @click="update(data.id)">Update</button>
                    </div>
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
                data: {
                    category_id: '',
                    date: '',
                    categories: {},
                    images: {}
                },
                categories: {},

                images : null,

                errors: {
                    name: 'false',
                    category_id: 'false',
                    description: 'false',
                    images: 'false',
                    date: 'false'
                },

                pathId: '',
                currentTab:1,
            };
        },
        created(){
            this.getCategories();
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
            uploadFile() {
                this.images = this.$refs.file.files;
            },
            saveImage(id) {
                for (var i = 0; i < this.images.length; i++ ){
                    let file = this.$refs.file.files[i];

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('product_id', id);
                    const headers = { 'Content-Type': 'multipart/form-data' };

                    axios.post(config.base_url + config.end_point.images, formData, { headers })
                    .then((response) => {
                        console.log(response.data);
                    })
                    .catch((error) => {
                        alert(error);
                        console.log(error);
                    });
                }
            },
            removeImage(key){
                this.data.images.splice(key, 1);
            },

            getCategories(){
                axios.get(config.base_url + config.end_point.categories)
                .then((response) => {
                    this.categories = response.data.data;
                })
                .catch((error) => {
                    alert(error);
                    console.log(error);
                });
            },
            selectCategory(event) {
                this.data.category_id = event.target.value;
                console.log(event);
            },
            store() {
                this.errors.date = 'false';
                this.errors.images = 'false';

                if(!this.data.date){
                    this.errors.date = 'true';
                } else {
                    this.currentTab = 3;
                    this.data.date = this.formatDateTime(this.data.date);

                    axios.post(config.base_url + config.end_point.products, this.data)
                    .then((response) => {
                        var product_id = response.data.data.id             
                        this.saveImage(product_id);

                        if(!alert(response.data.response)){window.location.href = '/product/list';}
                    })
                    .catch((error) => {
                        alert(error);
                        console.log(error);
                    });
                }
            },
            show(id) {
                axios.get(config.base_url + config.end_point.products + '/' + id)
                .then((response) => {
                    this.data = response.data.data;
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
            },


            formatDateTime(date){
                // Convert the original date string to a Date object
                const originalDate = new Date(date);

                // Set the desired time (00:11:48)
                originalDate.setHours(0);
                originalDate.setMinutes(11);
                originalDate.setSeconds(48);

                // Format the result as a string in the desired format (YYYY-MM-DD HH:mm:ss)
                const formattedDate = originalDate.toISOString().slice(0, 19).replace("T", " ");
                return formattedDate;
            },

            backStep1(){
                this.currentTab = 1;

                this.errors = {
                    name: 'false',
                    category_id: 'false',
                    description: 'false',
                    images: 'false',
                    date: 'false'
                };
            },
            backStep2(){
                this.currentTab = 2;

                this.errors = {
                    name: 'false',
                    category_id: 'false',
                    description: 'false',
                    images: 'false',
                    date: 'false'
                };
            },

            proceedStep2(){
                this.errors = {
                    name: 'false',
                    category_id: 'false',
                    description: 'false',
                    images: 'false',
                    date: 'false'
                };

                if(!this.data.name){
                    this.errors.name = 'true';
                } else if(!this.data.category_id){
                    this.errors.category_id = 'true';
                } else if(!this.data.description){
                    this.errors.description = 'true';
                } else {
                    this.currentTab = 2;
                }
            },
            proceedStep3(){
                if(!this.images){
                    this.errors.images = 'true';
                } else {
                    this.currentTab = 3;
                }
            },
        }
    };

</script>

<style scoped>
.breadcrumbs {
  border: 1px solid #cbd2d9;
  border-radius: 0.3rem;
  display: inline-flex;
  overflow: hidden;
}

.breadcrumbs_item {
  background: #fff;
  color: #333;
  outline: none;
  padding: 0.75em 0.75em 0.75em 1.25em;
  position: relative;
  text-decoration: none;
  transition: background 0.2s linear;
}
.is-active::after {
  background:  #323f4a !important;
}


.breadcrumbs_item:after,
.breadcrumbs_item:before {
  background: white;
  bottom: 0;
  clip-path: polygon(50% 50%, -50% -50%, 0 100%);
  content: "";
  left: 100%;
  position: absolute;
  top: 0;
  transition: background 0.2s linear;
  width: 1em;
  z-index: 1;
}


.breadcrumbs_item:before {
  background: #cbd2d9;
  margin-left: 1px;
}

.breadcrumbs_item:last-child {
  border-right: none;
}

.breadcrumbs_item.is-active {
  background: #323f4a;
  color: #fff;
}

/* Some styles to make the page look a little nicer */
body {
  color: #323f4a;
  background: #f5f7fa;
  display: flex;
  align-items: center;
  justify-content: center;

}

html, body {
  height: 100%;
}

</style>