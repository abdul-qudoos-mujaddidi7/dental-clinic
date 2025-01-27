import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";
import Patients from "../pages/people/patients/Patients.vue";
import { data } from "autoprefixer";

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
        // async fetchProduct(id, isUpdate = false) {

        //     try {
        //         // Fetch product data from the backend
        //         const response = await axios.get(`services/${id}`);
        //         const productData = response.data.data;
        
        //         // // If updating, remove the `id` field to avoid duplication issues
        //         // if (isUpdate) {
        //         //     delete productData.id;
        //         // }
        
        //         // Check if the product already exists in the services array
        //         const exists = this.services.some(item => item.id === productData.id);
        //         if (!exists) {
                  
        //             this.services.push(productData);
        //             this.cure.servicesDetails.push(productData);
        //         } else {
        //             console.warn(`Product with ID ${productData.id} already exists.`);
        //         }
        
        //         // Clear the search results after processing
        //         this.searchFetch = [];
        //     } catch (error) {
        //         console.error("Error fetching product:", error);
        //     }
        // },
         
        async fetchProduct(id, isUpdate = false) {
            try {
                const response = await axios.get(`services/${id}`);
                const productData = response.data.data;
        
                // Check if the product already exists in `servicesDetails`
                const existingIndex = this.servicesDetails.findIndex(
                    (item) => item.id === productData.id
                );
        
                if (existingIndex !== -1) {
                    // If updating, replace the existing entry
                    if (isUpdate) {
                        this.servicesDetails.splice(existingIndex, 1, {
                            ...this.servicesDetails[existingIndex],
                            ...productData,
                        });
                    } else {
                        console.warn(`Product with ID ${productData.id} already exists.`);
                    }
                } else {
                    // If not found, push new data
                    this.servicesDetails.push(productData);
                }
        
                // Update `services` array as well
                const serviceIndex = this.services.findIndex(
                    (item) => item.id === productData.id
                );
                if (serviceIndex !== -1) {
                    this.services.splice(serviceIndex, 1, {
                        ...this.services[serviceIndex],
                        ...productData,
                    });
                } else {
                    this.services.push(productData);
                }
        
                // Clear search results
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
        // async FetchCure(id) {
        //     // this.loading = true;
        //     console.log(id);
        //     try {
        //         const response = await axios.get(`cures/${id}`);
        //         this.cure = response.data.data;
        //         this.services.response.data.data.servicesDetails;
        //         this.services = this.services.map((data)=>{
        //             return{...data, name: data.services.name}
        //         })
        //         console.log(this.cure,'fetch cure ');
        //         console.log(this.services,'services in the fetch cure  ');
        //     } catch (err) {
        //         this.error = err;
        //     }
        // },
       
        async FetchCure(id) {
            try {
                const response = await axios.get(`cures/${id}`);
                this.cure = response.data.data;
        
                // Safely map `servicesDetails` and update the table
                this.servicesDetails = this.cure.servicesDetails.map((data) => ({
                    ...data,
                    name: data.services?.name || "Unnamed Service", // Fallback for undefined names
                }));
        
                console.log(this.cure, "fetch cure");
                console.log(this.servicesDetails, "services in the fetch cure");
            } catch (err) {
                console.error("Error fetching cure:", err);
            }
        }
,        
        
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
        async FetchCurePayments(id) {
            this.loading = true;

            const response = await axios.get(
                `curePayments?cure=${id}`
            );
            this.curePayments = response.data.data;
            console.log(this.curePayments, "this is the data i want ");

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

                this.FetchCurePayments(this.cureId);
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

                console.log(this.cureId)
                this.FetchCurePayments(this.cureId);
                this.FetchCures({
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
            // this.Expenses = [];
            this.error = null;

            console.log(id, 'payment id')
            try {
                const config = {
                    method: "DELETE",
                    url: "curePayments/" + id,
                };

                const response = await axios(config);

                this.FetchCurePayments(this.cureId);
                this.FetchCures({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },


    },
});
