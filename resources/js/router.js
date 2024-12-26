import { createRouter, createWebHistory } from "vue-router";
// try
import exp from "./components/exp.vue";
// expenses
import AllExpense from "./pages/expenses/AllExpenses/AllExpense.vue";
import BillExpense from "./pages/expenses/billExpenses/BillExpense.vue";
import CreateBillExpense from "./pages/expenses/billExpenses/CreateBillExpense.vue";
import UpdateBillExpense from "./pages/expenses/billExpenses/UpdateBillExpense.vue";
import ExpenseProduct from "./pages/expenses/expenseProduct/ExpenseProduct.vue";
import ExpenseCategory from "./pages/expenses/expenseCategory/ExpenseCategory.vue";
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
import RolePermission from "./pages/setting/rolePermission/RolePermission.vue";
import CreatePermissions from "./pages/setting/rolePermission/CreatePermissions.vue";
import ServiceGroup from "./pages/setting/service Group/ServiceGroup.vue";
import Service from "./pages/setting/service/Service.vue";
// reports
import ProfitLoss from "./pages/reports/profit and loss/Profit&Loss.vue";
import PatientsReport from "./pages/reports/patients report/PatientsReport.vue";
import ExpenseCatReport from "./pages/reports/Expense category report/ExpenseCatReport.vue";
import ExpenseProductReport from "./pages/reports/Expense Product report/ExpenseProductReport.vue";
import PickupReport from "./pages/reports/pickup report/PickupReport.vue";
//dashboard
import Dashboard from "./pages/dashboard/Dashboard.vue";
// cure cycle
import CureCycle from "./pages/cureCycle/cureCycle/CureCycle.vue";
import CreateCureCycle from "./pages/cureCycle/cureCycle/CreateCureCycle.vue";
import UpdateCureCycle from "./pages/cureCycle/cureCycle/UpdateCureCycle.vue";
// login
import Login from "./pages/Auth/Login.vue";
import Home from "./Home.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: "/", component: Login ,meta:''},
        {
            path: "/home",
            component: Home,
            meta: { authentication: true },
            children: [
                { path: "/dashboard", alias: "/dashboard", component: Dashboard },

                // try
                { path: "/exp", component: exp },
                // expenses
                { path: "/expense", component: AllExpense },
                { path: "/billExpense", component: BillExpense },
                { path: "/createBillExpense", component: CreateBillExpense },
                {
                    path: "/updateBillExpense/:id",
                    props: true,
                    component: UpdateBillExpense,
                },
                { path: "/expenseProducts", component: ExpenseProduct },
                { path: "/expenseCat", component: ExpenseCategory },
                // people
                { path: "/ownerPickup", component: OwnerPickup },
                { path: "/patients", component: Patients },
                { path: "/owners", component: Owner },
                { path: "/doctors", component: Doctor },
                { path: "/supplier", component: Supplier },
                { path: "/user", component: User },
                // leads
                { path: "/lead", component: Leads },
                { path: "/leadCategory", component: LeadCategory },
                { path: "/leadStage", component: LeadStage },
                // system setting
                { path: "/systemSetting", component: SystemSetting },
                { path: "/rolePermissions", component: RolePermission },
                { path: "/createPermissions", component: CreatePermissions },
                { path: "/serviceGroup", component: ServiceGroup },
                { path: "/service", component: Service },
                // reports
                { path: "/profitLoss", component: ProfitLoss },
                { path: "/patientsReport", component: PatientsReport },
                { path: "/categoryReport", component: ExpenseCatReport },
                { path: "/productReport", component: ExpenseProductReport },
                { path: "/pickupReport", component: PickupReport },
                // Dashboard
                // CureCycle
                { path: "/cure", component: CureCycle },
                { path: "/createCure", component: CreateCureCycle },
                {
                    path: "/updateCure/:id",
                    props: true,
                    component: UpdateCureCycle,
                },
                // login
            ],
        },
    ],
});
router.beforeEach(async function (to, from, next) {
    if (to.meta.authentication && !sessionStorage.getItem("token")) {
        // If the route requires authentication and the user is not logged in, redirect to login page
        next("/");
    } else {
        // Check if the user is already authenticated and trying to access the login page
        if (to.path === "/" && JSON.parse(sessionStorage.getItem("token"))) {
            // If the user is logged in, find the first route that the user has permission to access and redirect
            const userPermissions = JSON.parse(
                sessionStorage.getItem("permissions")
            );

            if (!userPermissions) {
                console.error("User permissions not found in sessionStorage.");
                next("/unAuth");
                return;
            }

            const authorizedRoute = findAuthorizedRoute(
                userPermissions,
                router.options.routes
            );
            if (authorizedRoute) {
                // Redirect to the first authorized route
                next(authorizedRoute.path);
                console.log(authorizedRoute.path);
            } else {
                // If no authorized route found, redirect to unauthorized page
                next("/unAuth");
                console.log("unAuth");
            }
        } else {
            // Check if the route has permissions defined and the user has those permissions
            if (to.meta.permissions) {
                try {
                    const userPermissions = JSON.parse(
                        sessionStorage.getItem("permissions")
                    );

                    if (!userPermissions) {
                        // Handle case when user permissions are not found in sessionStorage
                        console.error(
                            "User permissions not found in sessionStorage."
                        );
                        next("/unAuth");
                        return;
                    }

                    // Check if user has all required permissions for the route
                    const hasPermissions = to.meta.permissions.every(
                        (permission) => userPermissions.includes(permission)
                    );
                    if (hasPermissions) {
                        // User has permissions, allow access to the route
                        next();
                        console.log("ddd");
                    } else {
                        // User doesn't have required permissions, redirect to unauthorized page or any other action
                        next("/unAuth");
                        console.log("ww");
                    }
                } catch (error) {
                    console.error("Error parsing user permissions:", error);
                    // In case of error, proceed to the route
                    next();
                }
            } else {
                // If the route doesn't have permissions defined, proceed to the route
                next();
                console.log("mm");
            }
        }
    }
});
function findAuthorizedRoute(userPermissions, routes) {
    // Loop through all routes to find the first route that the user has permission to access
    for (const route of routes) {
        if (route.meta && route.meta.permissions) {
            const hasPermissions = route.meta.permissions.some((permission) =>
                userPermissions.includes(permission)
            );
            if (hasPermissions) {
                return route;
            }
        }
        if (route.children) {
            const childAuthorizedRoute = findAuthorizedRoute(
                userPermissions,
                route.children
            );
            if (childAuthorizedRoute) {
                return childAuthorizedRoute;
            }
        }
    }
    return null;
}

export default router;
