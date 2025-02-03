<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90 p-4">
                    <form @submit.prevent="submit">
                    <div class="card-body">
                        <h4>SET NEW PASSWORD</h4>
                        <br/>
                        <label>New Password</label>
                        <input id="password" v-model="form.password" placeholder="New Password" class="form-control" type="password"/>
                        <br/>
                        <label>Confirm Password</label>
                        <input id="cpassword" v-model="form.cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                        <br/>
                        <button type="submit"  class="btn w-100 btn-success">Reset Password</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm,usePage,router} from '@inertiajs/vue3'

const form = useForm({password:'',cpassword:''})
const page = usePage()
function submit(){
   if(form.password.length===0){
       alert('password is required')
   }else if(form.cpassword.length===0){
       alert('confirm password is required')
   }else if(form.password.length!==form.cpassword.length){
       alert('password doesnt match')
   }else{
       form.post('/reset-password',{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/LoginPage')
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
