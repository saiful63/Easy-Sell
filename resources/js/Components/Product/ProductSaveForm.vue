<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                <div class="card w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>Create Product</h4>
                            <br/>
                            <input id="id" v-model="form.id" class="form-control" type="hidden"/>
                            <br/>
                            <input id="category" v-model="form.name" placeholder="Give product name" class="form-control" type="text"/>
                            <br/>
                            <input id="email" v-model="form.price" placeholder="Give price" class="form-control" type="text"/>
                            <br/>
                            <input id="unit" v-model="form.unit" placeholder="Give unit" class="form-control" type="text"/>
                            <br/>
                            <img v-if="previewImage" :src="previewImage" alt="Image Preview" class="img-thumbnail" width="150" />
                            <br />
                            <input class="form-control" type="file" accept="image/*" @change="takePhoto"/>
                            <br/>
                            <select id="cat_id" v-model="form.category_id">
                             <option disabled value="">Select Category</option>
                             <option v-for="category in categories" :key="category.id" :value="category.id">
                                 {{ category.name }}
                             </option>
                            </select>
                            <br/>
                            <button type="submit"  class="btn w-100 btn-success">Save</button>
                            <hr/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm,usePage,router,Link} from '@inertiajs/vue3'
import {ref,onMounted} from 'vue'
import axios from 'axios'


const urlParam = new URLSearchParams(window.location.search)
let id = ref(parseInt(urlParam.get('id')))


const form = useForm({id:id,name:'',price:'',unit:'',img_url:'',category_id:'',prev_img:null})
const page = usePage()
let previewImage = ref(null);
let categories = ref([]);
console.log(categories.value)
let url='/create-product';
if(id.value!==0){
    url='/update-product';
    form.name = page.props.list['name'];
    form.price = page.props.list['price'];
    form.unit = page.props.list['unit'];
    form.prev_img = page.props.list['img_url'];
    form.category_id = page.props.list['category_id'];
    previewImage.value = `/images/products/${page.props.list['img_url']}`;
}
function submit(){
   if(form.name.length===0){
       alert('Product is required')
   }else if(form.price.length===0){
       alert('price is required')
   }else if(form.unit.length===0){
       alert('unit is required')
   }else if(form.category_id.length===0){
       alert('category_id is required')
   }else if(form.img_url.length===0 && id.value===0){
       console.log(id.value)
       alert('img_url is required')
   }
   else{
       form.post(url,{
       forceFormData:true,
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/ProductPage')
                }else{
                    alert(page.props.flash.message)
                }
            }
        })
   }

}

function takePhoto(event) {
    const file = event.target.files[0]
    if(file){
        form.img_url = file
        const reader = new FileReader()
        reader.onload = (e)=>{
          previewImage.value = e.target.result
        }
        reader.readAsDataURL(file)
    }
}

onMounted(()=>{
    categories.value = page.props.categories;
})

</script>

<style scoped>

</style>
