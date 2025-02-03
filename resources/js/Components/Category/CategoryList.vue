
<template>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text" v-model="searchValue">
                            <Link class="btn btn-success" href="/CategorySavePage?id=0">Create Category</Link>
                            <EasyDataTable buttons-pagination alternating :headers="Header" :items="Item" :rows-per-page="10" :search-field="searchField"  :search-value="searchValue">
                                <template #item-number="{ id }">
                                    <Link class="btn btn-success mx-3 btn-sm" :href="`/CategorySavePage?id=${id}`">Edit</Link>
                                    <button class="btn btn-danger btn-sm" @click="deleteCategory(id)">Delete</button>
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
    { text: "Action", value: "number"},
];


const Item = ref(page.props.list)


const deleteCategory = (id) => {
    const text="Do you want to delete ?"
    if(confirm(text)===true){
       router.get(`/delete-category/${id}`);
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
</script>
