import { defineStore } from "pinia";
import { reactive,ref } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";


export let usePeopleRepository =defineStore("PeopleRepository",{
    state(){
        return{
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
            // patents
            patients:reactive([]),
            patient:reactive([]),
            patientSearch:ref(""),
        }
    },
    actions:{
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
        // patient
        async bulkDeletePatient(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "patentsBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.patients = response.data.data;
                this.fetchPatients({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async fetchPatients({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `patients?page=${page}&perPage=${itemsPerPage}&search=${this.patientSearch}`
            );
            this.patients = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchPatient(id) {
            // this.error = null;
            try {
                const response = await axios.get(`patients/${id}`);

                this.patient = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdatePatient(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "patients/" + id,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchPatients({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreatePatient(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "patients",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchPatients({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeletePatient(id) {
            this.isLoading = true;
            this.patients = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "patients/" + id,
                };

                const response = await axios(config);

                // this.patients = response.data.data;
                this.fetchPatients({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    }


})