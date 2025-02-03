
<template>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 customer_tbl">
              <input type="date" v-model="dateRange.start" required>
              <input type="date" v-model="dateRange.end" required>
              <button @click="DownloadReport">Download Report</button>
            </div>
        </div>
    </div>

</body>


</template>

<script setup>
import {reactive} from 'vue'
import axios from 'axios'
const dateRange = reactive({
    start:'',
    end:''
})

const DownloadReport=async()=>{
    // alert(dateRange.start)
    try{
     const res = await axios.get('/GenerateReport',{
         params:{
            dateRange:dateRange
         }
     })
    }catch(error){
        console.log(error)
    }
}
</script>

<style scoped>

</style>
