<!-- <template>
    <v-app>
        <v-container>
            <v-btn color="primary">Test Button</v-btn>
        </v-container>

        <div>
            <h1>In the name of Allah!</h1>
            <h1>front is ok</h1>
            <router-view></router-view>
            <AppBar mainTitle="man" subTitle="women" />
        </div>
        <h1 class="text-4xl underline bg-blue-100">Hello world!</h1>
        <table
            class="min-w-50 table-auto border-collapse border border-red-300"
        >
            <thead>
                <tr
                    class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 text-white"
                >
                    <th class="px-6 py-3 text-left border-b border-gray-300">
                        Name
                    </th>
                    <th class="px-6 py-3 text-left border-b border-gray-300">
                        Age
                    </th>
                    <th class="px-6 py-3 text-left border-b border-gray-300">
                        Email
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="bg-blue-100 hover:bg-blue-200 transition duration-300"
                >
                    <td class="px-6 py-4 border-b border-gray-300">John Doe</td>
                    <td class="px-6 py-4 border-b border-gray-300">25</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        john@example.com
                    </td>
                </tr>
                <tr
                    class="bg-green-100 hover:bg-green-200 transition duration-300"
                >
                    <td class="px-6 py-4 border-b border-gray-300">
                        Jane Smith
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">30</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        jane@example.com
                    </td>
                </tr>
                <tr
                    class="bg-yellow-100 hover:bg-yellow-200 transition duration-300"
                >
                    <td class="px-6 py-4 border-b border-gray-300">
                        Mike Johnson
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">28</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        mike@example.com
                    </td>
                </tr>
                <tr
                    class="bg-pink-100 hover:bg-pink-200 transition duration-300"
                >
                    <td class="px-6 py-4 border-b border-gray-300">
                        Emily Davis
                    </td>
                    <td class="px-6 py-4 border-b border-gray-300">22</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        emily@example.com
                    </td>
                </tr>
            </tbody>
        </table>
 ================= 
        <hr />
        <v-card
            width="300"
            title="Card title"
            subtitle="Subtitle"
            text="
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet maiores cumque iure commodi, doloribus temporibus ipsam omnis deleniti quis dicta! Beatae blanditiis voluptate illum nam corrupti, minima eveniet repellendus magni."
        >
            <v-card-actions>
                <v-btn>Click me</v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
</template>

<script>
import AppBar from "./AppBar.vue";
export default {
    name: "ExampleComponent",
};
</script>

<style scoped>
/* Your styles here */
</style> -->

<!-- <template>
    <div>
      <h1>Dashboard</h1>
      <p>Net Profit: {{ dashboardStore.dashboardReport.netProfit }}</p>
      <p>This Month Profit: {{ dashboardStore.dashboardReport.thisMonthProfit }}</p>
      <p>Total Patients: {{ dashboardStore.dashboardReport.totalPatients }}</p>

      <table>
        <thead>
          <tr>
            <th>Category</th>
            <th>Total Expense</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="expense in dashboardStore.dashboardReport.monthlyExpenses" :key="expense.expense_category_id">
            <td>{{ expense.expense_category_id }}</td>
            <td>{{ expense.totalExpense }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { onMounted } from "vue";
  import { useDashboardRepository } from "../store/DashboardRepository";
  
  const dashboardStore = useDashboardRepository();
  
  onMounted(async () => {
    await dashboardStore.fetchDashboardData();
  });
  </script>
   

   <template>
    <div class="all-expense rounded-xl m-4">
      <div class="card bg-white">
        <div class="btn-search pt-2">
          <date-picker 
            v-model:value="ReportRepository.productDateRange" 
            @change="onDateChange"
            range 
          ></date-picker>
  
          <div class="text-field">
            <v-text-field
              :loading="loading"
              color="#D3E2F8"
              density="compact"
              variant="outlined"
              label="Search"
              append-inner-icon="mdi-magnify"
              style="width: 300px;"
              single-line
              hide-details
              v-model="ReportRepository.ProductReportSearch"
            
            ></v-text-field>
          </div>
        </div>
  

        <v-data-table-server
          theme="cursor-pointer"
          v-model:items-per-page="ReportRepository.itemsPerPage"
          :headers="headers"
          :items-length="ReportRepository.totalItems"
          :items="ReportRepository.productAssetReport"
          :loading="ReportRepository.loading"
          :search="ReportRepository.ProductReportSearch"
          :item-key="'id'"
          hover
          class="mx-auto mt-4 no-padding-table"
        >
          <template v-slot:item.due="{ item }">
            <span class="text-red">{{ item.due }}</span>
          </template>
  
          <template v-slot:item.action="{ item }">
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn icon="mdi-dots-vertical" v-bind="props" variant="text"></v-btn>
              </template>
            </v-menu>
          </template>
        </v-data-table-server>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import DatePicker from 'vue-datepicker-next';
  import 'vue-datepicker-next/index.css';
  import { useReportRepository } from "../store/ReportRepository";
  
  const ReportRepository = useReportRepository();
  const productDateRange = ref([new Date(), new Date()]);
  
  
  const onDateChange = () => {
    const [startDate, endDate] = ReportRepository.productDateRange;
    if (startDate && endDate) {
  
      ReportRepository.fetchServiceReports(startDate, endDate);
    }
  };
  
  // Watch for changes in the search field to automatically trigger API call
  watch(
    () => ReportRepository.ProductReportSearch,
    (newSearchTerm) => {
      const [startDate, endDate] = ReportRepository.productDateRange;
      if (startDate && endDate) {
        ReportRepository.fetchServiceReports(startDate, endDate);
      }
    }
  );
  
  onMounted(() => {
    ReportRepository.productDateRange = productDateRange.value;
    ReportRepository.fetchServiceReports(productDateRange.value[0], productDateRange.value[1]);
  });
  
  const headers = [
    { title: "Product Name", align: "left", sortable: false, key: "product_name", color: "red" },
    { title: "Amount", key: "amount", align: "left", sortable: false },
  ];
  </script>
  
  <style scoped>
  .v-table {
    width: 100% !important;
  }
  .v-main {
    margin-left: 0px !important;
    margin-right: 0px !important;
  }
  .btn-search {
    display: flex !important;
    justify-content: space-between;
  }
  .no-padding-table .v-data-table-server tbody tr td {
    padding: 0 !important;
    margin: 0 !important;
  }
  .pa-0 {
    padding: 0 !important;
  }
  .ma-0 {
    margin: 0 !important;
  }
  .check-all-checkbox > * {
    margin-left: -5px !important;
  }
  </style>
-->
<template>
    <div>
        <h1>Select a date</h1>
        <!-- <vue-awesome-datepicker
            v-model="selectedDate"
            :format="$datepickerConfig.format"
            :lang="$datepickerConfig.lang"
            :clearable="true"
        /> -->
    </div>
    <v-form ref="formRef">
    <v-card color="#555" class="w-50 border-2">

        <v-text-field label="man" v-model="formData.name"></v-text-field>
        
      </v-card>
      <div>
        <v-textarea label="assad" density="compact" v-model="formData.email" >
        </v-textarea>
      </div>
      <v-btn  @click="Create">click</v-btn>
    </v-form>
</template>

<script setup>
import { ref, reactive } from "vue";
import {usePeopleRepository} from "../store/PeopleRepository"
const formRef = ref(null);
const  PeopleRepository = usePeopleRepository();
const formData = reactive({
  name:"",
  email:""
})

const Create = async()=>{
  await PeopleRepository.CreateLabPayment(formData)
  

}
const selectedDate = ref("");
</script>

<style scoped>
/* @import 'vue-awesome-datepicker/dist/style.css'; */
</style>
