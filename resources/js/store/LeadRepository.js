import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let useLeadRepository = defineStore("LeadRepository", {
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
            leads: reactive([]),
            lead: reactive([]),
            leadSearch: ref(""),
            leadCategoriesFor: reactive([]),
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
        // leads
        async leadCategories() {
            const response = await axios.get("categories");
            this.leadCategoriesFor = response.data.data;
        },
        async leadStages(item,id) {
            const response = await axios.get("stages");
            this.leadStageFor = response.data.data;
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
        async FetchLeads({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `leads?page=${page}&perPage=${itemsPerPage}&${this.leadSearch}`
            );
            this.leads = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchLead(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`leads/${id}`);
                this.lead = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreateLead(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "leads",
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchLeads({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateLead(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `leads/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteLead(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `leads/${id}`,
                };
                const response = await axios(config);
                this.FetchLeads({
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
                    url: `leads/stage/${id}`,
                    data: formData,
                };
                const response = await axios(config);
             
            } catch (err) {
                this.error = err;
            }
        },
        // /leads/stage/{lead}
        // category
        async FetchCategories({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `categories?page=${page}&perPage=${itemsPerPage}&${this.categorySearch}`
            );
            this.categories = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchCategory(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`categories/${id}`);
                this.category = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreateCategory(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "categories",
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateCategory(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `categories/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteCategory(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `categories/${id}`,
                };
                const response = await axios(config);
                this.FetchCategories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // stages 
        async FetchStages({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `stages?page=${page}&perPage=${itemsPerPage}&${this.stageSearch}`
            );
            this.stages = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchStage(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`stages/${id}`);
                this.stage = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreateStage(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "stages",
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchStages({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateStage(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `stages/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchStages({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteStage(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `stages/${id}`,
                };
                const response = await axios(config);
                this.FetchStages({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    },
});
