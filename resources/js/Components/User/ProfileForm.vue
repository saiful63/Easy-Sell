
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card animated fadeIn w-100 p-3">
                    <div class="card-body">
                        <h4>User Profile</h4>
                        <hr/>
                        <form @submit.prevent="submit">
                           <div class="container-fluid m-0 p-0">
                                <div class="row m-0 p-0">
                                    <div class="col-md-4 p-2">
                                        <label>Name</label>
                                        <input id="name" v-model="form.name" placeholder="Name" class="form-control" type="text"/>
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <label>Email Address</label>
                                        <input readonly id="email" v-model="form.email" placeholder="User Email" class="form-control" type="email"/>
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <label>Mobile Number</label>
                                        <input id="mobile" v-model="form.mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                                    </div>
                                    <div class="col-md-4 p-2">
                                        <label>Password</label>
                                        <input id="password" v-model="form.password" placeholder="Give existing or new password" class="form-control" type="password"/>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-md-4 p-2">
                                        <button  class="btn mt-3 w-100 btn-success">Update</button>
                                    </div>
                                </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {useForm,usePage,router} from '@inertiajs/vue3'
const page = usePage()
const form = useForm({name:page.props.list['name'],email:page.props.list['email'],
                      mobile:page.props.list['mobile'],password:page.props.list['password']})

function submit(){
   if(form.name.length===0){
       alert('Name is required')
   }else if(form.email.length===0){
       alert('email is required')
   }else if(form.mobile.length===0){
       alert('mobile is required')
   }else{
       form.post('/update-profile',{
       onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get('/ProfilePage')
                }else{
                    alert(page.props.flash.message)
                }
            }
        })
   }

}
</script>

