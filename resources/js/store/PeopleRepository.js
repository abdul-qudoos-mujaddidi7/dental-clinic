import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let usePeopleRepository = defineStore("PeopleRepository", {
    state() {
        return {
            isEditMode: ref(false),

            router: useRouter(),
            peopleIDForSalary: ref(""),
            labIdForPayment: ref(""),
            peopleId: ref(""),

            search: ref(""),
            serverItems: ref([]),
            loadingTable: ref(true),
            loading: ref(false),
            totalItems: ref(0),
            selectedItems: ref([]),
            itemsPerPage: ref(5),
            createDialog: ref(false),
            generatePayslipDialog: ref(false),
            PaySalaryDialog: ref(false),
            // lab payments
            labCreatePaymentDialog: ref(false),
            // patents
            patients: reactive([]),
            patient: reactive([]),
            patientSearch: ref(""),
            // owners
            owners: reactive([]),
            owner: reactive([]),
            ownerSearch: ref(""),
            // doctors
            doctors: reactive([]),
            doctor: reactive([]),
            doctorSearch: ref(""),
            // supplier
            suppliers: reactive([]),
            supplier: reactive([]),
            supplierSearch: ref(""),
            // users
            users: reactive([]),
            user: reactive([]),
            userSearch: ref(""),
            roleForUser: reactive([]),
            // employee
            employeeSearch: ref(""),
            employees: reactive([]),
            employee: reactive([]),
            // laboratory
            laboratorySearch: ref(""),
            laboratories: reactive([]),
            laboratory: reactive([]),
            dentalsFor: reactive([]),
            suppliersFor: reactive([]),
            searchFetch: reactive([]),
            cureProduct: reactive([]),
            services: [],
            leadStageFor: reactive([]),
            labId: ref(""),
            // customer
            customerSearch: ref(""),
            customers: reactive([]),
            customer: reactive([]),
            // people account
            peopleAccSearch: ref(""),
            peopleAccounts: reactive([]),
            peopleAccount: reactive([]),
            moneyAccsFor: reactive([]),
            AccsForCreate:reactive([]),
            idForCreatePayment: ref(""),
            patientIdForView:ref(""),
            account: reactive([]),
            // pay salary
            paySalarySearch: ref(""),
            paySalaries: reactive([]),
            paySalary: reactive([]),
            // generate pay slip
            generatePayslipSearch: ref(""),
            generatePayslips: reactive([]),
            generatePayslip: reactive([]),
            // payment lab
            PaymentLabSearch: ref(""),
            paymentLabs: reactive([]),
            paymentLab: reactive([]),
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
        async fetchRoleForUser() {
            this.loading = true;

            const response = await axios.get(`role_permissions`);
            this.roleForUser = response.data.data;

            this.loading = false;
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
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.patientSearch}&type=patient`
            );
            this.patients = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchPatient(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

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
                    url: "peoples/" + id,

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
                    url: "peoples",

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
                    url: "peoples/" + id,
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
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.ownerSearch}&type=owner`
            );
            this.owners = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchOwner(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

                this.owner = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateOwner(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "peoples/" + id,
                    // headers: {
                    //     "Content-Type": "multipart/form-data",
                    // },

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
                    url: "peoples",
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
                    url: "peoples/" + id,
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
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.doctorSearch}&type=dentist`
            );
            this.doctors = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchDoctor(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

                this.doctor = response.data.data;
                console.log(this.Expense);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async UpdateDoctor(id, data) {
            try {
                const config = {
                    method: "PUT",
                    url: "peoples/" + id,
                    // headers: {
                    //     "Content-Type": "multipart/form-data",
                    // },
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
                    url: "peoples",
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
                    url: "peoples/" + id,
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
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.supplierSearch}&type=supplier`
            );
            this.suppliers = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchSupplier(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

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
                    url: "peoples",

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
                    url: `peoples/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
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
        async DeleteSupplier(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "peoples/" + id,
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
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
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
                    method: "POST",
                    url: `users/updateUsers/${id}`,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
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
        // employee
        async FetchEmployees({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.employeeSearch}&type=employee`
            );
            this.employees = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchEmployee(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

                this.employee = response.data.data;
                console.log(this.supplier);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateEmployee(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "peoples",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchEmployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateEmployee(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `peoples/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchEmployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteEmployee(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "peoples/" + id,
                };

                const response = await axios(config);

                // this.supplier = response.data.data;
                this.FetchEmployees({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // laboratories
        async FetchSuppliersFor() {
            this.loading = true;

            const response = await axios.get(`peoples?type=supplier`);
            this.suppliersFor = response.data.data;
            this.loading = false;
        },
        async leadStagesFor() {
            const response = await axios.get("stages");
            this.leadStageFor = response.data.data;
        },
        async SearchFetchData() {
            console.log(this.labSearch);
            this.loading = true;

            const response = await axios.get(
                `tooths?&search=${this.labSearch}`
            );
            this.searchFetch = response.data.data;
            this.loading = false;
            // this.searchFetch = "";
        },
        // async fetchProduct(id, isUpdate = false) {
        //     try {
        //         const response = await axios.get(`tooths/${id}`);
        //         const productData = response.data.data;

        //         if (isUpdate) delete productData.id;

        //         // Only add if it doesn’t already exist
        //         if (!this.services.some((item) => item.id === productData.id)) {
        //             this.services.push(productData);
        //             // this.cure.services.push(productData);
        //             // this.billExpense.expenseDetails.push(productData);
        //         }

        //         console.log(response.data.data, "fetchProduct");

        //         // Avoid duplication in `cureProduct`
        //         if (
        //             !this.cureProduct.some((item) => item.id === productData.id)
        //         ) {
        //             this.cureProduct.push(productData);
        //         }

        //         // Avoid duplication in `servicesDetails`
        //         if (
        //             !this.laboratory.tooths.some(
        //                 (item) => item.id === productData.id
        //             )
        //         ) {
        //             this.laboratory.tooths.push(productData);
        //         }

        //         // Clear search results
        //         this.searchFetch = [];
        //     } catch (error) {
        //         console.error("Error fetching product:", error);
        //     }
        // },
        async FetchDentals() {
            this.loading = true;

            const response = await axios.get(`tooths`);
            this.dentalsFor = response.data.data;

            this.loading = false;
            console.log(this.dentalsFor);
        },
        async FetchLaboratories({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `outboundLab?page=${page}&perPage=${itemsPerPage}&issue_at=${this.laboratorySearch}&type=out`
            );
            this.laboratories = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchLaboratory(id) {
            // this.error = null;
            try {
                const response = await axios.get(`outboundLab/${id}`);

                this.laboratory = response.data.data;
                console.log(this.laboratory);
            } catch (err) {
                // this.error = err.message;
            }
        },
        // async FetchCure(id) {
        //     try {
        //         const response = await axios.get(`cures/${id}`);
        //         this.cure = response.data.data;
        //         this.cureProduct = response.data.data.servicesDetails;
        //         this.cureProduct = this.cureProduct.map((data) => {
        //             return {
        //                 ...data,
        //                 name:
        //                     data.cureProduct.serviceName ||
        //                     data.cureProduct.name,
        //             };
        //         });
        //         console.log(this.cure, "fetch cure");
        //         console.log(this.servicesDetails, "services in the fetch cure");
        //         console.log(this.cureProduct, "services in the fetchProduct");
        //     } catch (err) {
        //         console.error("Error fetching cure:", err);
        //     }
        // },
        async CreateLaboratory(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "outboundLab",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.router.push("/laboratory");
                this.FetchLaboratories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateLaboratory(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `outboundLab/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.router.push("/laboratory");

                this.FetchLaboratories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteLaboratory(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "outboundLab/" + id,
                };

                const response = await axios(config);
                this.FetchLaboratories({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
                // If there's an error, set the error in the stor
            }
        },
        // Customer
        async FetchCustomers({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `peoples?page=${page}&perPage=${itemsPerPage}&search=${this.customerSearch}&type=customer`
            );
            this.customers = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchCustomer(id) {
            // this.error = null;
            try {
                const response = await axios.get(`peoples/${id}`);

                this.customer = response.data.data;
                console.log(this.customer);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreateCustomer(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "peoples",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchCustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdateCustomer(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `peoples/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchCustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeleteCustomer(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "peoples/" + id,
                };

                const response = await axios(config);

                // this.Customer = response.data.data;
                this.FetchCustomers({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
           async MoneyAccountsForCreate() {
            this.loading = true;
            const response = await axios.get(`moneyAccount`);
            this.AccsForCreate = response.data.data;
            this.loading = false;
        },
        // peopleAccount
        async fetchMoneyAccountsFor() {
            this.loading = true;
            const response = await axios.get(`moneyAccount`);
            this.moneyAccsFor = response.data.data;
            this.loading = false;
        },
        async FetchPeopleAccounts({ page, itemsPerPage }, id) {
            this.loading = true;
            try {
                const response = await axios.get(`peopleAccountTransaction`, {
                    params: {
                        people_id: id,
                        page,
                        perPage: itemsPerPage,
                        search: this.peopleAccSearch,
                    },
                });

                // const response = await axios.get(
                //     `peopleAccountTransaction/${id}?page=${page}&perPage=${itemsPerPage}&search=${this.peopleAccSearch}`
                // );
                this.peopleAccounts = response.data.data;
                this.totalItems = response.data?.meta?.total;
                this.loading = false;
                console.log(this.peopleAccounts, "data i need ");
             } catch (error) {
                    console.error("FetchPeopleAccounts error:", error); // Show the actual error
                  }
                  
        },
        async FetchPeopleAccount(id) {
            // this.error = null;
            try {
                const response = await axios.get(
                    `peopleAccountTransaction/${id}`
                );

                this.peopleAccount = response.data.data;
                console.log(this.customer);
            } catch (err) {
                // this.error = err.message;
            }
        },
        async CreatePeopleAccount(formData) {
            console.log(formData);
            try {
                // Adding a custom header to the Axios request
                const config = {
                    method: "POST",
                    url: "peopleAccountTransaction",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchPeopleAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async UpdatePeopleAccount(id, data) {
            console.log(data);
            try {
                const config = {
                    method: "PUT",
                    url: `peopleAccountTransaction/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.createDialog = false;
                this.FetchPeopleAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                // If there's an error, set the error in the stor
            }
        },
        async DeletePeopleAccount(id) {
            this.isLoading = true;
            this.Expenses = [];
            this.error = null;

            try {
                const config = {
                    method: "DELETE",
                    url: "peopleAccountTransaction/" + id,
                };

                const response = await axios(config);

                // this.Customer = response.data.data;
                this.FetchPeopleAccounts({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // part for the change account
        async fetchAccountDataForCreate() {
            const response = await axios.get("/moneyAccount");
            this.account = response.data.data;
            console.log(this.account);
        },
        // ============
        // paySalary
        async FetchPaySalaries({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `paySalary?page=${page}&perPage=${itemsPerPage}&${this.paySalarySearch}`
            );
            this.paySalaries = response.data.data;
            // this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchPaySalary(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`paySalary/${id}`);
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
                    url: "paySalary",
                    data: formData,
                };
                const response = await axios(config);
                this.PaySalaryDialog = false;
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
                    url: `paySalary/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.PaySalaryDialog = false;
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
                    url: `paySalary/${id}`,
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

        // ============
        // generate payslip
        async FetchGeneratePayslips({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `generatePaySlip?page=${page}&perPage=${itemsPerPage}&${this.generatePayslipSearch}`
            );
            this.generatePayslips = response.data.data;
            // this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async fetchPaySalary(id) {
            // this.loading = true;
            console.log(id);
            try {
                const response = await axios.get(`generatePaySlip/${id}`);
                this.generatePayslip = response.data.data;
                console.log(this.lead);
            } catch (err) {
                this.error = err;
            }
        },
        async CreateGeneratePayslip(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "generatePaySlip",
                    data: formData,
                };
                const response = await axios(config);
                this.generatePayslipDialog = false;
                this.FetchGeneratePayslips({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateGeneratePayslip(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `generatePaySlip/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.generatePayslipDialog = false;
                this.FetchGeneratePayslips({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });

                this.isEditMode = false;
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteGeneratePayslip(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `generatePaySlip/${id}`,
                };
                const response = await axios(config);
                this.FetchGeneratePayslips({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        // create Lab Payment
        async FetchLabPayments({ page, itemsPerPage }) {
            this.loading = true;
            const response = await axios.get(
                `outBoundLabPayment?page=${page}&perPage=${itemsPerPage}&${this.PaymentLabSearch}`
            );
            this.paymentLabs = response.data.data;
            // this.totalItems = response.data.meta.total;
            console.log(this.paymentLabs, "data fo index from repository ");
            this.loading = false;
        },
        async FetchLabPayment(id) {
            // this.loading = true;
            console.log(id, "id in repository");
            try {
                const response = await axios.get(`outBoundLabPayment/${id}`);
                this.paymentLab = response.data.data;
                console.log(this.paymentLab, "data of lab");
            } catch (err) {
                this.error = err;
            }
        },
        async CreateLabPayment(formData) {
            console.log(formData);
            try {
                const config = {
                    method: "POST",
                    url: "outBoundLabPayment",
                    data: formData,
                };
                const response = await axios(config);
                this.labCreatePaymentDialog = false;
                this.FetchLabPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
        async UpdateLabPayment(id, formData) {
            console.log(formData, id, "Update ");
            try {
                const config = {
                    method: "PUT",
                    url: `outBoundLabPayment/${id}`,
                    data: formData,
                };
                const response = await axios(config);
                this.labCreatePaymentDialog = false;
                this.FetchLabPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });

                this.isEditMode = false;
            } catch (err) {
                this.error = err;
            }
        },
        async DeleteLabPayment(id) {
            try {
                const config = {
                    method: "DELETE",
                    url: `outBoundLabPayment/${id}`,
                };
                const response = await axios(config);
                this.FetchLabPayments({
                    page: this.page,
                    itemsPerPage: this.itemsPerPage,
                });
            } catch (err) {
                this.error = err;
            }
        },
    },
});
