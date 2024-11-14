import { createRouter, createWebHistory } from "vue-router";
// try 
import exp from "./components/exp.vue";
// expenses
import AllExpense from  "./pages/expenses/AllExpenses/AllExpense.vue"
import BillExpense from "./pages/expenses/billExpenses/BillExpense.vue";
import CreateBillExpense from "./pages/expenses/billExpenses/CreateBillExpense.vue";
import UpdateBillExpense from "./pages/expenses/billExpenses/UpdateBillExpense.vue";
import ExpenseProduct from "./pages/expenses/expenseProduct/ExpenseProduct.vue";
import ExpenseCategory from "./pages/expenses/expenseCategory/ExpenseCategory.vue"
// people 
import OwnerPickup from "./pages/expenses/ownerPickup/OwnerPickup.vue";
import Patients from "./pages/people/patients/Patients.vue";
import Owner from "./pages/people/owner/Owner.vue";
import Doctor from "./pages/people/doctor/Doctor.vue";
import Supplier from "./pages/people/supplier/Supplier.vue";
import User from "./pages/people/user/User.vue";
// leads 
import Leads from "./pages/lead/leads/Leads.vue";
import LeadCategory from "./pages/lead/leadCategory/LeadCategory.vue";
import LeadStage from "./pages/lead/leadStage/LeadStage.vue";
// system setting 
import SystemSetting from "./pages/setting/system Setting/SystemSetting.vue";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        // try
        { path: "/exp", component: exp },
        // expenses
        { path: "/expense", component: AllExpense },
        {path: "/billExpense", component:BillExpense},
        {path: "/createBillExpense", component:CreateBillExpense},
        {path: "/updateBillExpense/:id", props:true, component:UpdateBillExpense},
        {path: "/expenseProducts", component:ExpenseProduct},
        {path: "/expenseCat", component:ExpenseCategory},
        // people
        {path: "/ownerPickup", component:OwnerPickup},
        {path: "/patients", component:Patients},
        {path: "/owners", component:Owner},
        {path: "/doctors", component:Doctor},
        {path: "/supplier", component:Supplier},
        {path: "/user", component:User},
        // leads 
        {path: "/lead", component:Leads},
        {path: "/leadCategory", component:LeadCategory},
        {path: "/leadStage", component:LeadStage},
        // system setting 
        {path: "/systemSetting", component:SystemSetting},




        
        
        
        
        

    ]
})


export default router;
