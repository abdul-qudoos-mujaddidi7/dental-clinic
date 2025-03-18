import { defineStore } from "pinia";
import { ref, reactive } from "vue";
import { axios } from "../axios";
import { useRouter } from "vue-router";

export let useLaboratoryRepository = defineStore("LaboratoryRepository", {
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

            laboratorySearch: ref(""),
            laboratories: reactive([]),
            laboratory: reactive([]),
            dentalsFor:reactive([]),
            searchFetch: reactive([]),
            cureProduct: reactive([]),
            services: [],
            // services: JSON.parse(localStorage.getItem("labServices")) || [],
            leadStageFor: reactive([]),
            labId: ref(""),
            doctorsFor: reactive([]),
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
        // laboratories
        async Doctors() {
            this.loading = true;

            const response = await axios.get(`peoples?type=dentist`);
            this.doctorsFor = response.data.data;
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
        async fetchProduct(id, isUpdate = false) {
            try {
                const response = await axios.get(`tooths/${id}`);
                const productData = response.data.data;

                if (isUpdate) delete productData.id;

                // Only add if it doesn’t already exist
                if (!this.services.some((item) => item.id === productData.id)) {
                    this.services.push(productData);
                    // this.cure.services.push(productData);
                    // this.billExpense.expenseDetails.push(productData);
                }

                console.log(response.data.data, "fetchProduct");

                // Avoid duplication in `cureProduct`
                if (
                    !this.cureProduct.some((item) => item.id === productData.id)
                ) {
                    this.cureProduct.push(productData);
                }

                // Avoid duplication in `servicesDetails`
                if (
                    !this.laboratory.tooths.some(
                        (item) => item.id === productData.id
                    )
                ) {
                    this.laboratory.tooths.push(productData);
                }

                // Clear search results
                this.searchFetch = [];
            } catch (error) {
                console.error("Error fetching product:", error);
            }
        },
        async FetchDentals() {
            this.loading = true;

            const response = await axios.get(`tooths`);
            this.dentalsFor = response.data.data;

            this.loading = false;
            console.log(this.dentalsFor)
        },
        // ======================

        // addService(service) {
        //     this.services.push(service);
        //     localStorage.setItem("labServices", JSON.stringify(this.services));
        // },
        // removeService(serviceId) {
        //     this.services = this.services.filter((s) => s.id !== serviceId);
        //     localStorage.setItem("labServices", JSON.stringify(this.services));
        // },
        // clearServices() {
        //     this.services = [];
        //     localStorage.removeItem("labServices");
        // },
        // =======================
        async FetchLaboratories({ page, itemsPerPage }) {
            this.loading = true;

            const response = await axios.get(
                `laboratories?page=${page}&perPage=${itemsPerPage}&search=${this.laboratorySearch}&type=in`
            );
            this.laboratories = response.data.data;
            this.totalItems = response.data.meta.total;
            this.loading = false;
        },
        async FetchLaboratory(id) {
            // this.error = null;
            try {
                const response = await axios.get(`laboratories/${id}`);

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
                    url: "laboratories",

                    data: formData,
                };

                // Using Axios to make a GET request with async/await and custom headers
                const response = await axios(config);
                this.router.push("/mainLaboratory");
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
                    url: `laboratories/${id}`,

                    data: data,
                };

                // Using Axios to make a post request with async/await and custom headers
                const response = await axios(config);
                this.router.push("/mainLaboratory");

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
                    url: "laboratories/" + id,
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
    },
});
