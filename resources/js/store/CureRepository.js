import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";
import Patients from "../pages/people/patients/Patients.vue";

export let useCureRepository = defineStore("CureRepository", {
    state() {
        return {
            isEditMode: ref(false),
            router: useRouter(),
            search: ref(""),
            serverItems: ref(""),
            loadingTable: ref(true),
            loading: ref(true),
            totalItems: ref(5),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),
            ShowCurePaymentDialog:ref(false),
            cureId:ref(''),
            paymentId:ref(''),

            // lead
            cures: reactive([]),
            cure: reactive([]),
            leadSearch: ref(""),
            patientsFor: reactive([]),
            doctorFor:reactive([]),
            searchFetch: reactive([]),
            services: reactive([]),
            leadStageFor:reactive([]),
        };
    },
    actions: {
        setEditMode(EditMode) {
            console.log(EditMode, "editMode");
            this.EditMode = EditMode;
        },
        getTodaysDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, "0");
            const day = String(today.getDay()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },
        // cure
        async leadStagesFor() {
            const response = await axios.get("stages");
            this.leadStageFor = response.data.data;
        },
        async SearchFetchData() {
            console.log(this.billExpenseSearch);
            this.loading = true;

            const response = await axios.get(
                `services?&search=${this.billExpenseSearch}`
            );
            this.searchFetch = response.data.data;
            this.loading = false;
            // this.searchFetch = "";
        },
        async fetchProduct(id, isUpdate = false) {
            try {
                // Fetch product data from the backend
                const response = await axios.get(`services/${id}`);
                const productData = response.data.data;
        
                // If updating, remove the `id` field to avoid duplication issues
                if (isUpdate) {
                    delete productData.id;
                }
        
                // Check if the product already exists in the services array
                const exists = this.services.some(item => item.id === productData.id);
                if (!exists) {
                    // Add the product to the services list and bill expense details
                    this.services.push(productData);
                    this.billExpense.expenseDetails.push(productData);
                } else {
                    console.warn(`Product with ID ${productData.id} already exists.`);
                }
        
                // Clear the search results after processing
                this.searchFetch = [];
            } catch (error) {
                console.error("Error fetching product:", error);
            }
        },
         
        async Patients() {
            const response = await axios.get("patients");
            this.patientsFor = response.data.data;
        },
        async Doctor() {
            const response = await axios.get("dentists");
            this.doctorFor = response.data.data;
        },
        async bulkDeleteLead(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "leadsBulkDelete",
                    data: data,
                };
                const response = response.data.data;
            } catch (err) {
                this.error = err;
            }
        },
        async FetchCures({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `cures?page=${page}&perPage=${itemsPerPage}&${this.curesSearch}`
            );
            this.cures = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchCure(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`cures/${id}`);
                this.cure = response.data.data;
                console.log(this.cure,'fetch cure ');
            } catch (err) {
                this.error = err;
            }
        },
        async CreateCure(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "cures",
                    data: formData,
                };
                const response = await axios(config);
               this.router.push("/cure")
                this.FetchCures({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateCure(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `cures/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                
                this.router.push("/cure");
                this.FetchCures({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteCure(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `cures/${id}`,
                };
                const response = await axios(config);
                this.FetchCures({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateLeadStages(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `cures/stage/${id}`,
                    data: formData,
                };
                const response = await axios(config);
             
            } catch (err) {
                this.error = err;
            }
        },
        // /leads/stage/{lead}
        // curePayments
        async FetchCurePayments(expenseId) {
            this.loading = true;

            const response = await axios.get(
                `curePayments?cure=${expenseId}`
            );
            this.curePayments = response.data.data;
            console.log(this.billExpensesPayments, "this is the data i want ");

            this.loading = false;
        },
        async FetchCurePayment(id) {
            // this.error = null;
            try {
                const response = await axios.get(`curePayments/${id}`);

                this.curePayment = response.data.data;
                console.log(curePayments, "this is the data i want ");
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateCurePayment(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "curePayments",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                // this.router.push("/billExpense");

                this.FetchCurePayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
                this.FetchCures({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateCurePayment(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `curePayments/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;

                this.FetchCurePayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteCurePayment(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "curePayments/" + id,
                };

                const response = await axios(config);

                this.FetchCurePayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },


    },
});
