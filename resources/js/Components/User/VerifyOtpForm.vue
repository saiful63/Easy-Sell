<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-90  p-4">
                    <form @submit.prevent="submit">
                    <div class="card-body">
                        <h4>ENTER OTP CODE</h4>
                        <br/>
                        <label>4 Digit Code Here</label>
                        <input id="otp" v-model="form.otp" placeholder="Code" class="form-control" type="text"/>
                        <br/>
                        <button href="submit"  class="btn w-100 btn-success">Verify Otp</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {useForm,usePage,router} from '@inertiajs/vue3'

const form = useForm({otp:''})
const page = usePage()
function submit(){
    if(form.otp.length===0){
       alert('otp is required')
   }else{
       form.post('/verify-otp',{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/ResetPasswordPage')
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
