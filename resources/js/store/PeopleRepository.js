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
            // owners 
            owners:reactive([]),
            owner:reactive([]),
            ownerSearch:ref(""),
            // doctors
            doctors:reactive([]),
            doctor:reactive([]),
            doctorSearch:ref(""),
            // supplier 
            suppliers:reactive([]),
            supplier:reactive([]),
            supplierSearch:ref(""),
            // users
            users:reactive([]),
            user:reactive([]),
            userSearch:ref(""),


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
        // fetch owners 
        async fetchOwners({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `owners?page=${page}&perPage=${itemsPerPage}&search=${this.ownerSearch}`
            );
            this.owners = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchOwner(id) {
            // this.error = null;
            try {
                const response = await axios.get(`owners/${id}`);
                

                this.owner = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateOwner(id, data) {
            try {
                const config = {
                    method: "POST",
                    url: "owners/updateOwners/" + id,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchOwners({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateOwner(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "owners",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchOwners({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteOwner(id) {
            this.isLoading = true;
            this.owners = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "owners/" + id,
                };

                const response = await axios(config);

                // this.patients = response.data.data;
                this.fetchOwners({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // doctors
        async bulkDeleteDoctor(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "dentistBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.doctors = response.data.data;
                this.fetchDoctors({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async fetchDoctors({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `dentists?page=${page}&perPage=${itemsPerPage}&search=${this.doctorSearch}`
            );
            this.doctors = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchDoctor(id) {
            // this.error = null;
            try {
                const response = await axios.get(`dentists/${id}`);

                this.doctor = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateDoctor(id, data) {
            try {
                const config = {
                    method: "POST",
                    url: "dentists/updateDentist/" + id,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchDoctors({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async CreateDoctor(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "dentists",
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.fetchDoctors({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteDoctor(id) {
            this.isLoading = true;
            this.dentists = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "dentists/" + id,
                };

                const response = await axios(config);

                // this.patients = response.data.data;
                this.fetchDoctors({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // supplier
        async bulkDeleteSupplier(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "supplierBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.doctors = response.data.data;
                this.fetchPatients({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
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

                // this.supplier = response.data.data;
                this.FetchSuppliers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // user 
        async CreateForSwitch(status, id) {
            console.log(status, "man", id);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "PUT",
                    url: "users/status/" + id,

                    data: status,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                console.log(status, "man", id);
                this.FetchUsers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });

            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async bulkDeleteUser(data) {
            console.log(data);
            try {
                const config = {
                    method: "DELETE",
                    url: "userBulkDelete",
                    data: data,
                };

                const response = await axios(config);

                this.doctors = response.data.data;
                this.FetchUsers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async FetchUsers({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `users?page=${page}&perPage=${itemsPerPage}&search=${this.userSearch}`
            );
            this.users = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchUser(id) {
            // this.error = null;
            try {
                const response = await axios.get(`users/${id}`);

                this.user = response.data.data;
                console.log(this.supplier);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateUser(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "users",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchUsers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateUser(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `users/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.updateDialog = false;
                this.FetchUsers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the store
                this.error = err;
            }
        },
        async DeleteUser(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "users/" + id,
                };

                const response = await axios(config);

                // this.supplier = response.data.data;
                this.FetchUsers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    }


})