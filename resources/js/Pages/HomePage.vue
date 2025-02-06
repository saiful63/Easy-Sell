
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-6 mrg">
                <div class="card animated fadeIn w-100 p-3">
                    <div class="card-body">
                        <h4>Start selling</h4>
                        <hr/>
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <Link href="/LoginPage" class="btn mt-3 w-100 btn-success">Login</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import{Link} from '@inertiajs/vue3'
</script>
<style scoped>
.mrg{
    margin: 0 auto;
    margin-top: 25vh;
}
</style>

