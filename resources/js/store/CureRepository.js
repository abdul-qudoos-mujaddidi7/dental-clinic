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
                const response = await axios.get(`services/${id}`);
                const productData = response.data.data;
        
                if (isUpdate) delete productData.id;
        
                // Only add if it doesn’t already exist
                if (!this.services.some(item => item.id === productData.id)) {
                    this.services.push(productData);
                    this.billExpense.expenseDetails.push(productData);
                }
                this.searchFetch = [];
            } catch (err) {
                // this.error = err.message;
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

    },
});
