import { createRouter, createWebHistory } from "vue-router";
// try 
import exp from "./components/exp.vue";
// expenses
import AllExpense from  "./pages/expenses/AllExpenses/AllExpense.vue"
import BillExpense from "./pages/expenses/billExpenses/BillExpense.vue";
import CreateBillExpense from "./pages/expenses/billExpenses/CreateBillExpense.vue";
import UpdateBillExpense from "./pages/expenses/billExpenses/UpdateBillExpense.vue";
import ExpenseProduct from "./pages/expenses/expenseProduct/ExpenseProduct.vue";


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
        
        
        

    ]
})


export default router;
