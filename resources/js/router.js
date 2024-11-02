import { createRouter, createWebHistory } from "vue-router";
import AllExpense from  "./pages/expenses/AllExpenses/AllExpense.vue"
import exp from "./components/exp.vue";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/expense", component: AllExpense },
        { path: "/exp", component: exp },

    ]
})


export default router;
