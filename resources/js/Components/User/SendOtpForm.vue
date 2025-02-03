<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <form @submit.prevent="submit">
                    <div class="card-body">
                        <h4>EMAIL ADDRESS</h4>
                        <br/>
                        <label>Your email address</label>
                        <input id="email" v-model="form.email"  placeholder="User Email" class="form-control" type="email"/>
                        <br/>
                        <button type="submit"  class="btn w-100 btn-success">Sent Otp</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {useForm,usePage,router} from '@inertiajs/vue3'

const form = useForm({email:''})
const page = usePage()
function submit(){
    if(form.email.length===0){
       alert('email is required')
   }else{
       form.post('/sent-otp',{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/VerifyOtpPage')
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
