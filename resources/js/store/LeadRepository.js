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
            // lab payment
            mainLabCreatePaymentDialog: ref(false),
            labIdForPayment: ref(""),
            // lead
            leads: reactive([]),
            lead: reactive([]),
            leadSearch: ref(""),
            leadCategoriesFor: reactive([]),
            leadStageFor: reactive([]),
            // appointments
            appointmentSearch: ref(""),
            appointments: reactive([]),
            appointment: reactive([]),
            patientsForApp: reactive([]),
            doctorsForApp: reactive([]),
            userForApp: reactive([]),
            // pay salary
            paySalarySearch: ref(""),
            paySalaries: reactive([]),
            paySalary: reactive([]),
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
        async leadStages(item, id) {
            const response = await axios.get("stages");
            this.leadStageFor = response.data.data;
        },
       async bulkDeleteLead(data) {
    console.log(data);
    try {
        const config = {
            method: "DELETE",
            url: "leadBulkDelete",
            data: data,
        };

        const response = await axios(config); // ✅ Make the request

        // ✅ Correct the way you access response data
        this.leads = response.data.data;

        // ✅ Re-fetch the updated list of leads
        this.FetchLeads({
            page: this.page,
            itemsPerPage: this.itemsPerPage,
        });
    } catch (err) {
        console.error(err);
        this.error = err;
    }
},
        async FetchLeads({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `leads?page=${page}&perPage=${itemsPerPage}&name=${this.leadSearch}`
            );
            this.leads = response.data.data;
            // this.totalItems = response.data.meta.total;
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
                this.FetchLeads({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
                this.isEditMode = false;
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
            // this.totalItems = response.data.meta.total;
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
                this.isEditMode = false;
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
            // this.totalItems = response.data.meta.total;
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
        // stages
        async fetchPatients() {
            this.loading = true;

            const response = await axios.get(`peoples?type=patient`);
            this.patientsForApp = response.data.data;
            this.loading = false;
        },
        async fetchDoctors() {
            this.loading = true;

            const response = await axios.get(`peoples?type=dentist`);
            this.doctorsForApp = response.data.data;
            this.loading = false;
        },
        async fetchUsers() {
            this.loading = true;

            const response = await axios.get(`users`);
            this.userForApp = response.data.data;
            this.loading = false;
        },
        //
        async FetchAppointments({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `appointments?page=${page}&perPage=${itemsPerPage}&people_id=${this.appointmentSearch}`
            );
            this.appointments = response.data.data;
            // this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchAppointment(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`appointments/${id}`);
                this.appointment = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreateAppointment(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "appointments",
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchAppointments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateAppointment(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `appointments/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchAppointments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });

                this.isEditMode = false;
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteAppointment(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `appointments/${id}`,
                };
                const response = await axios(config);
                this.FetchAppointments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // paySalary
        async FetchPaySalaries({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `salary?page=${page}&perPage=${itemsPerPage}&${this.paySalarySearch}`
            );
            this.paySalaries = response.data.data;
            // this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchPaySalary(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`salary/${id}`);
                this.paySalary = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreatePaySalary(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "salary",
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchPaySalaries({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdatePaySalary(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `salary/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.createDialog = false;
                this.FetchPaySalaries({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });

                this.isEditMode = false;
            } catch (err) {
                this.error = err;
            }
        },
        async DeletePaySalary(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `salary/${id}`,
                };
                const response = await axios(config);
                this.FetchPaySalaries({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    },
});
