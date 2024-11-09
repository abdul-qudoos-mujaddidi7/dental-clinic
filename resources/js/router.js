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
        
        
        
        
        

    ]
})


export default router;
