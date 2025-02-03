<template>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                <div class="card w-90  p-4">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4>SIGN IN</h4>
                            <br/>
                            <input id="email" v-model="form.email"  placeholder="User Email" class="form-control" type="email"/>
                            <br/>
                            <input id="password" v-model="form.password" placeholder="User Password" class="form-control" type="password"/>
                            <br/>
                            <button type="submit"  class="btn w-100 btn-success">Login</button>
                            <hr/>
                            <div>
                                <Link  href="/RegistrationPage" class="btn mt-3 w-50  btn-success">Sign Up </Link>
                                <Link  href="/SendOtpPage" class="btn mt-3 w-50  btn-success">Forget Password</Link>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useForm,usePage,router,Link} from '@inertiajs/vue3'

const form = useForm({name:'',email:'',mobile:'',password:''})
const page = usePage()
function submit(){
   if(form.email.length===0){
       alert('email is required')
   }else if(form.password.length===0){
       alert('password is required')
   }else{
       form.post('/user-login',{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/DashboardPage')
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
