import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let useExpenseRepository = defineStore("ExpenseRepository", {
    state() {
        return {
            isEditMode: ref(false),
            
            router: useRouter(),

            search: ref(""),
            serverItems: ref([]),
            loadingTable: ref(true),
            loading: ref(false),
            totalItems: ref(0),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),
            
            createPaymentBill: ref(false),
            ExpenseSearch: ref(""),
            Expenses: reactive([]),
            Expense: reactive([]),
         

            // CREATE ALL EXPENSE
            categories: reactive([]),
            people: reactive([]),
   
            paymentId: ref(""),
 
       
            // Expense Categories
            expenseCategory: reactive([]),
            expenseCategories: reactive([]),
            expenseCatSearch: ref(""),
            createExpenseCatDialog: ref(""),
            updateExpenseCatDialog: ref(""),
            ShowExpensePayment: ref(false),
            // ownerPickups
            ownerPickups: reactive([]),
            ownerPickupSearch: ref(""),
            ownerPickup: reactive([]),
            owners:reactive([]),
         
            // expenseProduct
            expenseProductSearch: ref(""),
            expenseProducts: reactive([]),
            expenseProduct: reactive([]),
            // Supplier
            suppliersFor:reactive([]),
           
            // bill expense
            billExpenseSearch: ref(""),
            billExpenses: reactive([]),
            billExpense: reactive([]),
            billExpenseId: ref(0),
            expenseAllData: reactive([]),
            searchFetch: reactive([]),
            expenseProduct: reactive([]),
            symbol: ref(""),
            // bill expense payment
            billExpensePayment: reactive([]),
            billExpensesPayments: reactive([]),
            billExpensePaymentUpdate: reactive([]),
            moneyAccsFor:reactive([]),
            account:reactive([]),

          
        };
    },
    actions: {
        setEditMode(editMode) {
            console.log(editMode, "wee");
            this.isEditMode = editMode; // set the value directly
        },
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },

        async bulkDeleteExpense(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "expensesBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.expenses = response.data.data;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async fetchExpensesData({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `expenses?page=${page}&perPage=${itemsPerPage}&search=${this.ExpenseSearch}`
            );
            this.Expenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchExpense(id) {
            // this.error = null;
            try {
                const response = await axios.get(`expenses/${id}`);

                this.Expense = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateExpense(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "expenses/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateExpense(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "expenses",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteExpense(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "expenses/" + id,
                };

                const response = await axios(config);

                // this.Expenses = response.data.data;
                this.fetchExpensesData({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        //   this is data fro ALL EXPENSE FETCH
        async Categories() {
            const config = {
                url: "expenseCategories",
            };
            const response = await axios(config);
            this.categories = response.data.data;
        },
        async People() {
            const config = {
                url: "peoples",
            };
            const response = await axios(config);
            this.people = response.data.data;
            // console.log(this.people);
        },
        async Suppliers() {
            const config = {
                url: "suppliers",
            };
            const response = await axios(config);
            this.suppliersFor = response.data.data;
            // console.log(this.people);
        },
 
        // expense category data
        async FetchExpenseCats({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `expenseCategories?page=${page}&perPage=${itemsPerPage}&search=${this.expenseCatSearch}`
            );
            this.expenseCategories = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchExpenseCat(id) {
            // this.error = null;
            try {
                const response = await axios.get(`expenseCategories/${id}`);

                this.expenseCategory = response.data.data;
                console.log(this.expenseCategory);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateExpenseCat(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "expenseCategories",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateExpenseCat(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: "expenseCategories/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteExpenseCat(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "expenseCategories/" + id,
                };

                const response = await axios(config);

                this.expenseCategory = response.data.data;
                this.FetchExpenseCats({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },

        // the people data=========
        async fetchOwners() {
            this.loading = true;
            const response = await axios.get(
                `owners`
            );
            this.owner = response.data.data;
            console.log(this.owner);
            // this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchOwnersPickup({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `ownerPickups?page=${page}&perPage=${itemsPerPage}&search=${this.ownerPickupSearch}`
            );
            this.ownerPickups = response.data.data;
            console.log(this.ownerPickups);
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchOwnerPickup(id) {
            // this.error = null;
            try {
                const response = await axios.get(`ownerPickups/${id}`);

                this.ownerPickup = response.data.data;
                console.log(this.ownerPickup,'man');
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateOwnerPickup(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "ownerPickups/" + id,
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchOwnersPickup({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateOwnerPickup(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "ownerPickups",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchOwnersPickup({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteOwnerPickup(id) {
            this.isLoading = true;
            this.setting = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "ownerPickups/" + id,
                };

                const response = await axios(config);

                // this.setting = response.data.data;
                this.fetchOwnersPickup({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // expense_products
        async FetchExpenseProducts({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `products?page=${page}&perPage=${itemsPerPage}&search=${this.expenseProductSearch}`
            );
            this.expenseProducts = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchExpenseProduct(id) {
            // this.error = null;
            try {
                const response = await axios.get(`products/${id}`);

                this.expenseProduct = response.data.data;
                console.log(this.expenseProduct);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateExpenseProduct(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "products",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateExpenseProduct(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `products/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteExpenseProduct(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "products/" + id,
                };

                const response = await axios(config);

                this.expenseProduct = response.data.data;
                this.FetchExpenseProducts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // supplier
        async FetchSuppliers({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `suppliers?page=${page}&perPage=${itemsPerPage}&search=${this.supplierSearch}`
            );
            this.suppliers = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchSupplier(id) {
            // this.error = null;
            try {
                const response = await axios.get(`suppliers/${id}`);

                this.supplier = response.data.data;
                console.log(this.supplier);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateSupplier(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "suppliers",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateSupplier(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `suppliers/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteSupplier(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "suppliers/" + id,
                };

                const response = await axios(config);

                this.supplier = response.data.data;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // bill expense
        // entigrating data for create Earnings
       
        async SearchFetchData() {
            console.log(this.billExpenseSearch);
            this.loading = true;

            const response = await axios.get(
                `products?&search=${this.billExpenseSearch}`
            );
            this.searchFetch = response.data.data;
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchProduct(id, isUpdate = false) {
       
            try {
                const response = await axios.get(`products/${id}`);
                const productData = response.data.data;
        
                if (isUpdate) delete productData.id;
        
                // Only add if it doesn’t already exist
                if (!this.expenseProduct.some(item => item.id === productData.id)) {
                    this.expenseProduct.push(productData);
                    this.billExpense.expenseDetails.push(productData);
                }
                this.searchFetch = [];
            } catch (err) {
                // this.error = err.message;
            }
        },
        // 
        async bulkDeleteBillExpense(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "billExpenseBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.expenses = response.data.data;
                this.fetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async fetchBillExpenses({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `billExpenses?page=${page}&perPage=${itemsPerPage}&search=${this.billExpenseSearch}`
            );
            this.billExpenses = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchBillExpense(id) {
            this.expenseProduct = []; // Clear array to prevent duplicates

            try {
                const response = await axios.get(`billExpenses/${id}`);
                this.billExpense = response.data.data;  
            
                // Use Map to remove any duplicates based on product ID
                // this.expenseDetails = response.data.data.expenseDetails;
                this.expenseProduct = Array.from(
                    new Map(
                        this.billExpense.expenseDetails.map((item) => [item.id, item])
                    ).values()
                );
            
            } catch (err) {
                // Handle error (e.g., display error message)
            }
        },
        async CreateBillExpense(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "billExpenses",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.router.push("/billExpense");

                this.fetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateBillExpense(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `billExpenses/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);

                this.router.push("/billExpense");

                this.fetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteBillExpense(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "billExpenses/" + id,
                };

                const response = await axios(config);

                this.supplier = response.data.data;
                this.fetchBillExpenses({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // create payment
        // payments
        async fetchMoneyAccountsFor( ) {
            this.loading = true;

            const response = await axios.get(
                `moneyAccount`
            );
            this.moneyAccsFor = response.data.data;
            this.loading = false;
        },
        async FetchBillExpensesPayments(expenseId) {
            this.loading = true;

            const response = await axios.get(
                `payments?expense=${expenseId}`
            );
            this.billExpensesPayments = response.data.data;
            console.log(this.billExpensesPayments, "this is the data i want ");

            this.loading = false;
        },
        async FetchBillExpensePayment(id) {
            // this.error = null;
            try {
                const response = await axios.get(`payments/${id}`);

                this.billExpensePayment = response.data.data;
                console.log(billExpensePayment, "this is the data i want ");
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateBillExpensePayment(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "payments",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                // this.router.push("/billExpense");

                this.FetchBillExpensesPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
                this.fetchBillExpenses({
                    page: this.page,
                    itemsPerPage:this.itemsPerPage,
                })
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateBillExpensePayment(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `payments/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;

                this.FetchBillExpensesPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteBillExpensePayment(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "payments/" + id,
                };

                const response = await axios(config);

                this.FetchBillExpensesPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
               // part for the change account
               async fetchAccountDataForCreate() {
                const response = await axios.get('/moneyAccount');
                this.account = response.data.data;
                console.log(this.account);
            },
    },
});
