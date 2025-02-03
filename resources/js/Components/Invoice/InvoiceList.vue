
<template>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Total</th>
                                        <th>Vat</th>
                                        <th>Discount</th>
                                        <th>Payable</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in items" :key="item.id">
                                            <td>{{index+1}}</td>
                                            <td>{{item.customer.name}}</td>
                                            <td>{{item.customer.mobile}}</td>
                                            <td>{{item.total}}</td>
                                            <td>{{item.vat}}</td>
                                            <td>{{item.discount}}</td>
                                            <td>{{item.payable}}</td>
                                            <td>
                                                <button type="button" @click="invoiceProduct(item)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal">
                                                     <i class="fa-regular fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger" @click="invoiceToDelete(item.id)">
                                                    <i class="fa-solid fa-delete-left"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <ViewModal>
                                    <div class="customer_tbl">
                                        <table class="table_fr">
                                        <tr>
                                            <td class="fr_td1">
                                                <h6>BILLED TO</h6>
                                                <span class="customer_info">Name: {{ customer_info?.name ||'' }} </span>
                                                <span class="customer_info">Email: {{ customer_info?.mobile ||'' }} </span>
                                                <span class="customer_info">User ID: {{ customer_info?.user_id ||'' }} </span>
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
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Unit</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(eachProduct,index) in InvoiceProduct" :key="eachProduct.id">
                                                   <td>{{index+1}}</td>
                                                   <td>{{eachProduct.product.name}}</td>
                                                   <td>{{eachProduct.product.price}}</td>
                                                   <td>{{eachProduct.product.unit}}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="total_calculation">
                                            <tr>
                                                <td>Total &#58; {{price_change.total}}</td>
                                            </tr>
                                            <tr>
                                                <td>Vat &#58; {{price_change.vat}}</td>
                                            </tr>
                                            <tr>
                                                <td>Discount &#58; {{price_change.discount}}</td>
                                            </tr>
                                            <tr>
                                                <td>Payable&#58; {{price_change.payable}}</td>
                                            </tr>
                                            <button class="printButton" @click="generatePdf">Print</button>
                                        </table>

                                    </div>
                                </ViewModal>

                                <DeleteModal>
                                    <h1>Are you sure to delete?</h1>
                                    <button type="button" @click="deleteInvoice" class="btn btn-primary">Yes</button>
                                </DeleteModal>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script setup>
import ViewModal from '@/Components/ModalReuse/Modal.vue'
import {useForm,usePage,router,Link} from '@inertiajs/vue3'
import {ref,reactive,computed, onMounted} from "vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import {format} from 'date-fns'
import axios from 'axios';
import jsPDF from 'jspdf'
import html2canvas from "html2canvas";
import DeleteModal from '@/Components/ModalReuse/DeleteModal.vue'
import {Modal} from 'bootstrap'


const page = usePage()
const items = ref(page.props.invoices)
let CustomerDetail = ref([])
let InvoiceProduct = ref([])
let InvoiceTotal = ref([])
let customer_info = reactive({
        name:'',
        mobile:'',
        user_id:''
})

let price_change = reactive({
        total:'',
        vat:'',
        discount:'',
        payable:''
})
let modalToDelete;

let dltModal=ref(null)

const invoiceProduct = async(item={})=>{
        // let itemId = item.id?item.id:item;
        customer_info.name = item.customer?.name || '';
        customer_info.mobile = item.customer?.mobile || '';
        customer_info.user_id = item.customer?.id || '';
        price_change.total = item.total || '';
        price_change.vat = item.vat || '';
        price_change.discount = item.discount || '';
        price_change.payable = item.payable || '';
   try{
     const res = await axios.get('/InvoiceDetail',{
        params:{
            inv_id:item.id
        }

     })

     InvoiceProduct.value = res.data.InvoiceProduct
    }catch(error){
        console.log(error)
    }
}

const date = ref(new Date());
const originalDate = computed(()=>{
    return format(new Date(date.value),'yyyy-MM-dd')
})

const generatePdf=async()=>{
    const element = document.querySelector(".customer_tbl"); // Select the content to print
    const printButton = document.querySelector(".printButton");
  if (!element) {
    console.error("Element not found!");
    return;
  }

  try {
    if(printButton){
        printButton.style.display="none";
    }
    // Set up PDF dimensions (A4 size)
    const pdf = new jsPDF("p", "mm", "a4");
    const pageWidth = pdf.internal.pageSize.getWidth(); // 210mm
    const pageHeight = pdf.internal.pageSize.getHeight(); // 297mm

    // Use html2canvas to capture the element as an image
    const canvas = await html2canvas(element, { scale: 2 });
    const imgData = canvas.toDataURL("image/png");

    // Original dimensions of the element
    const elementWidth = canvas.width;
    const elementHeight = canvas.height;

    // Calculate scaling factor to fit the content on a single page
    const scaleX = pageWidth / (elementWidth / 96 * 25.4); // Convert px to mm
    const scaleY = pageHeight / (elementHeight / 96 * 25.4); // Convert px to mm
    const scale = Math.min(scaleX, scaleY);

    // Calculate final image dimensions
    const imgWidth = elementWidth * scale * 0.264583; // px to mm
    const imgHeight = elementHeight * scale * 0.264583; // px to mm

    // Center the image on the page
    const offsetX = (pageWidth - imgWidth) / 2;
    const offsetY = (pageHeight - imgHeight) / 2;

    // Add the scaled image to the PDF
    pdf.addImage(imgData, "PNG", offsetX, offsetY, imgWidth, imgHeight);

    // Save the PDF
    pdf.save("invoice.pdf");
  } catch (error) {
    console.error("Error generating PDF:", error);
  }finally{
     if(printButton){
        printButton.style.display="block";
    }
  }
}


let getItemId = ref('')
const invoiceToDelete=(itemId)=>{
    if(modalToDelete){
        console.log(modalToDelete)
    }
   getItemId.value = itemId
   modalToDelete.show()
}
console.log(getItemId.value)

const deleteInvoice=async()=>{
    modalToDelete.hide()
   try{
     const res = await axios.post('/DeleteInvoice',{
        'inv_id':getItemId.value
     })
     InvoiceList()
    }catch(error){
        console.log(error)
    }
}

const InvoiceList =async()=>{
    try{
     const res = await axios.get('/InvoiceList')
     items.value = res.data.invoices
    }catch(error){
        console.log(error)
    }
}

onMounted(()=>{
    modalToDelete = new Modal(document.getElementById('DeleteInvoice'));
    console.log(modalToDelete)
})

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

