
<template>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text" v-model="searchValue">
                             <Link class="btn btn-success" href="/ProductSavePage?id=0">Create Product</Link>
                            <EasyDataTable buttons-pagination alternating :headers="Header" :items="Item" :rows-per-page="10" :search-field="searchField"  :search-value="searchValue">
                                <template #item-img_url="{ img_url }">
                                    <img
                                        :src="getImageUrl(img_url)"
                                        alt="Product Image"
                                        class="img-thumbnail"
                                        style="width: 100px; height: auto;"
                                    />
                                </template>

                                <template #item-number="{ id }">
                                   <Link class="btn btn-success mx-3 btn-sm" :href="`/ProductSavePage?id=${id}`">Edit</Link>
                                    <button class="btn btn-danger btn-sm" @click="deleteProduct(id)">Delete</button>
                                </template>
                            </EasyDataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>
import {useForm,usePage,router,Link} from '@inertiajs/vue3'
import {ref} from "vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const page = usePage()


const Header = [
    { text: "No", value: "id" },
    { text: "Name", value: "name"},
    { text: "Price", value: "price"},
    { text: "Unit", value: "unit"},
    { text: "Image", value: "img_url"},
    { text: "Action", value: "number"},
];


const Item = ref(page.props.list)

const deleteProduct = (id) => {
    const text="Do you want to delete ?"
    if(confirm(text)===true){
       router.get(`/delete-product/${id}`);
    }else{
       text="You canceled";
    }
}

const $toast = useToast();

if(page.props.flash.status===true){
    $toast.success(page.props.flash.message);
}

if(page.props.flash.status===false){
    $toast.danger(page.props.flash.message);
}

const getImageUrl = (imageName)=>{
    return imageName?`images/products/${imageName}`:'';
};

</script>
