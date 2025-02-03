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
                            <input id="category" v-model="form.name" placeholder="Give customer name" class="form-control" type="text"/>
                            <br/>
                            <input id="email" v-model="form.email" placeholder="Give email" class="form-control" type="email"/>
                            <br/>
                            <input id="mobile" v-model="form.mobile" placeholder="Give mobile number" class="form-control" type="text"/>
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


const form = useForm({id:id,name:'',email:'',mobile:''})
const page = usePage()

let url='/create-customer';
if(id.value!==0){
    url='/update-customer';
    form.name = page.props.list['name'];
    form.email = page.props.list['email'];
    form.mobile = page.props.list['mobile'];
}
function submit(){
   if(form.name.length===0){
       alert('Category is required')
   }else if(form.email.length===0){
       alert('email is required')
   }else if(form.mobile.length===0){
       alert('mobile is required')
   }
   else{
       form.post(url,{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/CustomerPage')
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
