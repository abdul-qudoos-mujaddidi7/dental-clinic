import { createRouter, createWebHistory } from "vue-router";
import AllExpense from "./components/expenses/allExpenses/AllExpenses.vue"



const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/expense", component: AllExpense },

    ]
})


export default router;
