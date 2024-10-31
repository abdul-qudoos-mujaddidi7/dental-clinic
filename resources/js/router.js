import { createRouter, createWebHistory } from "vue-router";
import AllExpense from  "./pages/expenses/AllExpenses/AllExpense.vue"


const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/expense", component: AllExpense },

    ]
})


export default router;
