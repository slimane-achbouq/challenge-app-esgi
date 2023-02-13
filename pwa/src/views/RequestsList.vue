<template>
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>

            <main>

                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">


                    <!-- Page header -->
                    <div class="sm:flex sm:justify-between sm:items-center mb-8">


                        <!-- Left: Title -->
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Requests ✨</h1>
                        </div>


                        <!-- Right: Actions  -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                            <!-- Delete button -->
                        </div>

                    </div>

                    <!-- Table -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 relative">
                        <header class="px-5 py-4">
                            <h2 class="font-semibold text-slate-800">Requests <span class="text-slate-400 font-medium" v-if="nbDemandes">{{ nbDemandes }}</span>
                            </h2>
                        </header>
                        <div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-center">
                                    <thead
                                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                    <tr>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Status
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Created by
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Announce</th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Created At
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Starting
                                            date
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Ending date
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="demandes" class="text-sm divide-y divide-slate-200">
                                    <tr v-for="demande in demandes" v-bind:key="demande.id">
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <span
                                                v-if="demande.status == 0 && demande.annonce.owner.email === useremail"
                                                class="text-blue-500">
                                                You have to respond
                                            </span>
                                            <span
                                                v-else-if="demande.status == 0 && demande.locataire.email === useremail"
                                                class="text-orange-500">
                                                Wait for the seller to respond
                                            </span>
                                            <span
                                                v-else-if="demande.status == 1 && demande.locataire.email === useremail && !demande.isPaid"
                                                class="text-green-500">
                                                Confirmed. You have to pay.
                                            </span>
                                            <span
                                                v-else-if="demande.status == 1 && demande.annonce.owner.email === useremail && !demande.isPaid"
                                                class="text-green-500">
                                                Confirmed. Wait for the renter to pay.
                                            </span>
                                            <span
                                                v-else-if="demande.status == 2 && demande.annonce.owner.email === useremail"
                                                class="text-orange-500">
                                                Wait for the renter to respond
                                            </span>
                                            <span
                                                v-else-if="demande.status == 2 && demande.locataire.email === useremail"
                                                class="text-blue-500">
                                                You have to respond
                                            </span>
                                            <span v-else-if="demande.status == 3" class="text-red-500">
                                                Refused
                                            </span>
                                            <span v-else-if="demande.status == 1 && demande.isPaid"
                                                  class="text-green-500">
                                                Confirmed.
                                            </span>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ demande.locataire.email }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <router-link :to="{ name: 'announce', params: { id: demande.annonce.id }}">
                                                <span class="text-blue-500">{{ demande.annonce.title }}</span>
                                            </router-link>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ demande.createdAt }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ demande.dateStart }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ demande.dateEnd }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <button class="btn bg-green-700 text-white" style="margin-right: 10px"
                                                    v-if="demande.status == 0 && demande.annonce.owner.email === useremail"
                                                    @click="onOpenModal(demande)">
                                                Respond
                                            </button>
                                            <button class="btn bg-green-700 text-white" style="margin-right: 10px"
                                                    v-else-if="demande.status == 2 && demande.locataire.email === useremail"
                                                    @click="onOpenModal(demande)">
                                                Respond
                                            </button>

                                            <router-link
                                                :to="{ name: 'show-request', params: { id: demande.id }}">
                                                <button class="btn bg-green-600 text-white" style="margin-right: 10px"
                                                        v-if="demande.status == 1 && demande.locataire.email === useremail && !demande.isPaid">
                                                    Pay
                                                </button>
                                                <button class="btn bg-green-600 text-white" style="margin-right: 10px"
                                                        v-if="demande.status == 1 && demande.isPaid">
                                                    View
                                                </button>
                                            </router-link>
                                            <router-link
                                                :to="{ name: 'show-demande-histories', params: { id: demande.id }}">
                                                <button class="btn bg-blue-600 text-white">
                                                    History
                                                </button>
                                            </router-link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <ModalBasic v-if="validatingDemande" id="feedback-modal" :modalOpen="modalOpen"
                                @close-modal="onModalClose"
                                :title="'Request : ' + validatingDemande.annonce.title + ' by ' + validatingDemande.locataire.email">
                        <!-- Modal content -->
                        <div class="px-5 py-4">
                            <div class="space-y-3 ">
                                <div v-if="validatingDemande">
                                    <p class="text-center">
                                        From <br>
                                        <span class="text-blue-500">{{ validatingDemande.dateStart }}</span> <br>
                                        To <br>
                                        <span class="text-blue-500">{{ validatingDemande.dateEnd }}</span>
                                    </p>
                                </div>
                                <div v-if="modifyRequest" class="text-center">
                                    From
                                    <div>
                                        <input type="datetime-local" id="newDateStart" name="newDateStart"
                                               v-model="newDateStart">
                                    </div>
                                    To
                                    <div>
                                        <input type="datetime-local" id="newDateEnd" name="newDateEnd"
                                               v-model="newDateEnd">
                                    </div>
                                    <div v-if="dateError">
                                        <span class="text-red-500">{{ dateError }}</span>
                                    </div>

                                    <div style="margin-top: 20px">
                                        <button class="btn bg-red-500 text-white" @click="cancelModifyRequest"
                                                style="margin-right: 10px">
                                            Cancel
                                        </button>
                                        <button class="btn bg-indigo-500 text-white"
                                                @click="submitModifyRequest(validatingDemande.id, validatingDemande.status)">
                                            Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="px-5 py-4 border-t border-slate-200">
                            <div class="flex flex-wrap justify-end space-x-2">
                                <button class="btn-sm bg-red-500 hover:bg-red-600 text-white"
                                        @click="handleRefuseRequest(validatingDemande.id)">
                                    Refuse
                                </button>
                                <button class="btn-sm bg-orange-500 hover:bg-orange-600 text-white"
                                        @click="handleModifyRequest">
                                    Give other dates
                                </button>
                                <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                        @click="handleSubmitRequest(validatingDemande.id)">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </ModalBasic>



                </div>
            </main>

        </div>

    </div>
</template>

<script>
import Sidebar from '@/partials/Sidebar.vue'
import Header from '@/partials/Header.vue'
import Pagination from '@/components/Pagination.vue'
import ModalBasic from '@/components/Modal.vue'
import CustomersTable from "@/partials/dashboard/users/UsersTable.vue";
import {ref} from "vue";


export default {
    name: 'RequestsList',
    components: {
        Sidebar,
        Header,
        Pagination,
        ModalBasic,
        CustomersTable,
    },
    data() {
        return {
            demandeHistories: null,
            src: "",
            demandes: null,
            useremail: "",
            modifyRequest: false,
            newDateStart: null,
            newDateEnd: null,
            dateError: null,
            nbDemandes: 0,
        }
    },
    methods: {
        handleRefuseRequest: async function (id) {
            let token = localStorage.getItem('esgi-ws-token');

            const request = await fetch(`${import.meta.env.VITE_API_URL}/demandes/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    status: 3
                })
            });

            const response = await request.json();

            await this.updateDemandeData();
            this.modalOpen = false;
        },
        handleModifyRequest: async function () {
            this.modifyRequest = true;
        },
        handleSubmitRequest: async function (id) {
            let token = localStorage.getItem('esgi-ws-token');
            const request = await fetch(`${import.meta.env.VITE_API_URL}/demandes/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    status: 1
                })
            });

            const response = await request.json();

            await this.updateDemandeData();
            this.modalOpen = false;
        },
        cancelModifyRequest: function () {
            this.modifyRequest = false;
        },
        submitModifyRequest: async function (id, actualStatus) {
            let token = localStorage.getItem('esgi-ws-token');

            this.dateError = null;
            if (!this.newDateStart || !this.newDateEnd) {
                this.dateError = "Please select two dates.";
            }
            if (this.newDateStart && this.newDateEnd && this.newDateStart > this.newDateEnd) {
                this.dateError = "Please choose a starting date earlier than the ending date";
            }

            if (this.newDateStart && this.newDateEnd && this.newDateStart <= this.newDateEnd) {
                const request = await fetch(`${import.meta.env.VITE_API_URL}/demandes/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        dateStart: this.newDateStart,
                        dateEnd: this.newDateEnd,
                        status: actualStatus == 2 ? 0 : 2
                    })
                });

                const response = await request.json();

                await this.updateDemandeData();
                this.modalOpen = false;

                let formData = new FormData();
                formData.append('owner', this.useremail);
                formData.append('demand', id);
                const request2 = await fetch(`${import.meta.env.VITE_API_URL}/demande_histories`, {
                    method: 'POST',
                    headers: {
                        // 'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                const response2 = await request2.json();
            }
        },
        updateDemandeData: async function () {
            let token = this.$store.getters["auth/token"]
            this.role = this.$store.getters["auth/role"]
            this.useremail = this.$store.getters["auth/email"]

            const response = await fetch(`${import.meta.env.VITE_API_URL}/demandes`, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            let res = await response.json();
            let data = res['hydra:member'];
            this.annonce = data.annonce;
            this.locataire = data.locataire;
            this.demandeHistories = data.demandeHistories;

            let finalDemandes = [];
            let count = 0;
            for (let demande of data) {
                let date = new Date(demande.createdAt);
                demande.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
                date = new Date(demande.dateStart);
                demande.dateStart = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
                date = new Date(demande.dateEnd);
                demande.dateEnd = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
                if (demande.annonce.owner.email === this.useremail || this.role == "Admin") {
                    finalDemandes.push(demande);
                    count++;
                }
                else if(demande.locataire.email == this.useremail) {
                    finalDemandes.push(demande);
                    count++;
                }
            }
            this.demandes = finalDemandes;
            this.nbDemandes = count;
        }
    },
    setup() {
        const modalOpen = ref(false);
        const validatingDemande = ref(null);

        function onOpenModal(e) {
            validatingDemande.value = e;
            modalOpen.value = true
        }

        return {
            onOpenModal,
            modalOpen,
            validatingDemande
        }
    },
    async created() {
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        let token = this.$store.getters["auth/token"]
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]

        const response = await fetch(`${import.meta.env.VITE_API_URL}/demandes`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let res = await response.json();
        let data = res['hydra:member'];
        this.annonce = data.annonce;
        this.locataire = data.locataire;
        this.demandeHistories = data.demandeHistories;

        let finalDemandes = [];
        let count = 0;
        for (let demande of data) {
            let date = new Date(demande.createdAt);
            demande.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
            date = new Date(demande.dateStart);
            demande.dateStart = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
            date = new Date(demande.dateEnd);
            demande.dateEnd = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
            if (demande.annonce.owner.email === this.useremail || this.role == "Admin") {
                finalDemandes.push(demande);
                count++;
            }
            else if(demande.locataire.email == this.useremail) {
                finalDemandes.push(demande);
                count++;
            }
        }
        this.demandes = finalDemandes;
        this.nbDemandes = count;
    }
}
</script>
