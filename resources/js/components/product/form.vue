<template>
    <div class="card">
        <div class="card-header">
            <label v-if="!this.pathId" class="mt-2">Create Product</label>
            <label v-if="this.pathId" class="mt-2">Update Product</label>
            <button class="btn btn-danger float-end mb-2" @click="backToListing()">Cancel</button>
        </div>

        <div class="card-body contianer">

            <nav class="breadcrumbs mb-3">
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active' : currentTab == 1}">Step 1</a>
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active' : currentTab == 2}">Step 2</a> 
                <a href="javascript:void(0)" class="breadcrumbs_item" :class="{'is-active' : currentTab == 3}">Step 3</a>
            </nav>

            <!-- STEP 1 -->
            <div class="step1" id="step1" ref="Step1" v-show="currentTab == 1">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input type="text" v-model="data.name" class="form-control" placeholder="Input Name" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <select class="form-control" v-model="data.category_id">
                            <option value="" selected disabled>Select Category</option>
                            <option v-for="(category, key) in categories" :key="key" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="text" v-model="data.description" class="form-control" placeholder="Input Description" />
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary mb-2 mr-3" @click="backStep2()">Proceed</button>
                    </div>
                </div>
            </div>


            <!-- STEP 2 -->
            <div class="step2" id="step2" ref="Step2" v-show="currentTab == 2">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        Upload Images
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
                        <input type="date" class="form-control">
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
    import { useRoute } from 'vue-router';

    export default {
        data() {
            return {
                data: {
                    category_id: '',
                    categories: {},
                    images: {}
                },
                categories: {},
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
            backStep1(){
                this.currentTab = 1;
                this.$refs.Step1.click();
            },
            backStep2(){
                this.currentTab = 2;
                this.$refs.Step2.click();
                this.$refs.Step2.click();
            },

            proceedStep2(){
                this.$refs.Step2.click();
                this.currentTab = 2;
            },
            proceedStep3(){
                this.$refs.Step3.click();
                this.currentTab = 3;
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

.breadcrumbs_item:hover:after,
.breadcrumbs_item:hover {
  /* background: #f5f3ed; */
  background: #3c4b64;
  color: #fff;
}

.breadcrumbs_item:focus:after,
.breadcrumbs_item:focus,
.breadcrumbs_item.is-active:focus {
  background:  #323f4a;
  color: #fff;
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