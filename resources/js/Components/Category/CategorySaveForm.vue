<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                <div class="card w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>Create Category</h4>
                            <br/>
                            <input id="id" v-model="form.id" class="form-control" type="hidden"/>
                            <br/>
                            <input id="category" v-model="form.name" placeholder="Give category name" class="form-control" type="text"/>
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
import {ref} from 'vue'

const urlParam = new URLSearchParams(window.location.search)
let id = ref(parseInt(urlParam.get('id')))
let url='/create-category';

const form = useForm({id:id,name:''})
const page = usePage()

if(id.value!==0){
    url='/update-category';
    form.name = page.props.list['name'];
}
function submit(){
   if(form.name.length===0){
       alert('Category is required')
   }else{
       form.post(url,{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/CategoryPage')
                }else{
                    alert(page.props.flash.message)
                }
            }
        })
   }

}
</script>

<style scoped>

</style>
