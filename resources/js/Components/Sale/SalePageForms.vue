
<template>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 customer_tbl">
                <table class="table_fr">
                  <tr>
                      <td class="fr_td1">
                          <h6>BILLED TO</h6>
                          <span class="customer_info">Name: {{customerToInvoice.name}}</span>
                          <span class="customer_info">Email: {{customerToInvoice.email}}</span>
                          <span class="customer_info">User ID: {{customerToInvoice.user_id}}</span>
                      </td>
                      <td class="fr_td2">
                          <h6>My Shop</h6>
                          <span>Date: {{originalDate}}</span>
                      </td>
                  </tr>
                </table>
                <table class="table table_invoice">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(invoiceProduct,index) in invoiceListProduct" :key="index">
                            <td>{{invoiceProduct.name}}</td>
                            <td>{{invoiceProduct.price}}</td>
                            <td>{{invoiceProduct.qty}}</td>
                            <td> <button @click="removeProduct(index)">Remove</button></td>
                        </tr>
                    </tbody>
                </table>

                <table class="total_calculation">
                    <tr>
                        <td>Total &#58;</td>
                        <td>{{total}}</td>
                        <td rowspan="4" class="vat_discount">
                            <input type="number" @change="vatCalculation($event)" placeholder="Enter vat" class="form-control">
                            <br>
                            <input type="text" placeholder="Enter Discount" @keyup.enter="discountCalculation($event)" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <!-- <input v-model.number="discountRate" type="number" class="form-control" placeholder="Enter discount rate" /> -->
                        <td>After vat &#58;</td>
                        <td>{{totalVat}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>After discount &#58;</td>
                        <td>{{totalDiscount}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Payable &#58;</td>
                        <td>{{afterDiscount}}</td>
                        <td></td>
                    </tr>
                    <button @click="generateInvoice">Confirm</button>
                </table>

            </div>

            <div class="col-md-3 customer_tbl">
                <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text" v-model="searchValue">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                       <tr v-for="product in products" :key="product.id">
                            <td>{{product.name}}</td>
                            <td> <button @click="addProduct(product)">ADD</button></td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <div class="col-md-3 customer_tbl">
                <input placeholder="Search..." class="form-control mb-2 w-auto form-control-sm" type="text" v-model="searchValue">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers" :key="customer.id">
                            <td>{{customer.name}}</td>
                            <td> <button @click="addCustomer(customer)">ADD</button></td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invoice Generation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form @submit.prevent="submit">
                        <input id="name" v-model="productToInvoice.name"  placeholder="Give name" class="form-control" type="text"/>
                        <br/>
                        <input id="price" v-model="productToInvoice.price" placeholder="Give price" class="form-control" type="text"/>
                        <br/>
                        <input id="unit" v-model="qty" placeholder="Give unit" class="form-control" type="text"/>
                        <br/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

</body>


</template>

<script setup>
import {ref,onMounted,computed} from "vue";
import axios from 'axios';
import {format} from 'date-fns'
import { Modal } from 'bootstrap'



let customers = ref([]);
let products = ref([]);
const date = ref(new Date());
const originalDate = computed(()=>{
    return format(new Date(date.value),'yyyy-MM-dd')
})

const getCustomer = async()=>{
  try{
     const res = await axios.get('/list-customer')
     customers.value = res.data.customers;
  }catch(error){
      console.log(error)
  }
}

const getProduct = async()=>{
  try{
     const res = await axios.get('/list-product')
     products.value = res.data.products;
  }catch(error){
      console.log(error)
  }
}

let customerToInvoice = ref([]);
const addCustomer = (customer)=>{
    customerToInvoice.value = customer
}


let productToInvoice = ref([]);
let qty = ref('')
let myModal;
const addProduct=(product)=>{
    productToInvoice.value = product;
    myModal.show();
}

let invoiceListProduct = ref([]);

function submit(){
   invoiceListProduct.value.push({
        product_id:productToInvoice.value.id,
        name: productToInvoice.value.name,
        price: parseFloat(productToInvoice.value.price),
        qty: parseInt(qty.value),
   })
   if (myModal) {
        myModal.hide();
        qty.value=''
    }
}

const removeProduct=(index)=>{
    invoiceListProduct.value.splice(index,1)
    totalDiscount.value=''
    totalVat.value=''
}
onMounted(()=>{
  getCustomer()
  getProduct()
  myModal = new Modal(document.getElementById('addProduct'));
})

const total = computed(()=>invoiceListProduct.value.reduce((sum,product)=>
    sum+product.price*product.qty,0)
)


let afterVat = ref(0);
let totalVat=ref(0)
const vatCalculation=(event)=>{
    console.log(event.target.value)
    afterVat.value = (event.target.value*total.value)/100;
    totalVat.value = afterVat.value
    afterVat.value+=total.value;
}

let afterDiscount= ref(0);
let totalDiscount=ref(0)
const discountCalculation=(event)=>{
   totalDiscount.value = event.target.value
   afterDiscount.value=afterVat.value-event.target.value
}

const generateInvoice=async()=>{
    try{
        let res = await axios.post('/CreateInvoice',{
            total:total.value,
            customerToInvoice:customerToInvoice.value,
            invoiceListProduct:invoiceListProduct.value,
            totalVat:totalVat.value,
            totalDiscount:totalDiscount.value,
            afterDiscount:afterDiscount.value
        })
        console.log(res.data)
    }catch(error){
        console.log(error)
    }

}


</script>

<style scoped>
.table{
    width: 100%; /* Optional: Adjust table width */
    border-collapse: collapse; /* Merge borders for a clean look */
}

.table th,
.table td{
    border-bottom: 1px solid gray;
}

tr:last-child td{
    border-bottom:none;
}

.customer_tbl{
  border: 2px solid white;
  background: white;
  margin-left: 20px;
  margin-top: 20px;
  padding: 20px;
  border-radius: 5px;
}

body{
    background: hsl(0, 0%, 96%);
     margin: 0;
    padding: 0;
    height:100vh;
}

.table_fr{
    width: 100%;
}

.customer_info{
    display: block;
}

.fr_td1{
    width: 220px;
}
.table_invoice{
  height: 50px;
}
.total_calculation{
  margin-top:40px;
  width: 100%;
  padding-left: 5px;
}
.vat_discount{
  width: 211px;
  padding: 8px;
  border-left: 1px solid gray;
}
</style>
