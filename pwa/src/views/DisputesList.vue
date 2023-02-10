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
                            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Disputes ✨</h1>
                        </div>


                        <!-- Right: Actions  -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                            <!-- Delete button -->
                        </div>

                    </div>

                    <!-- Search form -->
                    <div class="max-w-xl mb-5">
                        <form class="relative">
                            <label for="app-search" class="sr-only">Search</label>
                            <input id="app-search" class="form-input w-full pl-9 py-3 focus:border-slate-300"
                                   type="search" placeholder="Search…"/>
                            <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                                <svg
                                    class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                                    viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z"/>
                                    <path
                                        d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <!-- Table -->
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 relative">
                        <header class="px-5 py-4">
                            <h2 class="font-semibold text-slate-800">Disputes <span class="text-slate-400 font-medium">248</span>
                            </h2>
                        </header>
                        <div>

                            <!-- Table -->
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-center">
                                    <thead
                                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                    <tr>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Reason
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Announce</th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Created at
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="litiges" class="text-sm divide-y divide-slate-200">
                                    <tr v-for="litige in litiges" v-bind:key="litige.id">
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ litige.raison }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <router-link :to="{ name: 'announce', params: { id: litige.annonce.id }}">
                                                <span class="text-blue-500">{{ litige.annonce.title }}</span>
                                            </router-link>
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ litige.createdAt }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            <router-link :to="{name: 'show-dispute', params: {id: litige.id}}">
                                                <button class="btn bg-indigo-500 text-white">View</button>
                                            </router-link>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        <Pagination/>
                    </div>

                </div>
            </main>

        </div>

    </div>
</template>

<script>
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'
import Pagination from '../components/Pagination.vue'
import ModalBasic from '../components/Modal.vue'
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
            src: "",
            useremail: "",
            litiges: null
        }
    },
    methods: {
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

            let finalDisputes = [];
            for (let litige of data) {
                console.log(litige);
                let date = new Date(litige.createdAt);
                litige.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
                date = new Date(litige.dateStart);
                if (litige.annonce.owner.email === this.useremail || this.role == "Admin") {
                    finalDisputes.push(litige);
                } else if (litige.locataire.email == this.useremail) {
                    finalDisputes.push(litige);
                }
            }
            this.litiges = finalDisputes;
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
        let token = this.$store.getters["auth/token"]
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]

        const response = await fetch(`${import.meta.env.VITE_API_URL}/litiges`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let res = await response.json();
        let data = res['hydra:member'];
        console.log(data)

        let finalDisputes = [];
        for (let litige of data) {
            let date = new Date(litige.createdAt);
            litige.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
            if (litige.annonce.owner.email === this.useremail || this.role == "Admin") {
                finalDisputes.push(litige);
            } else if (litige.locataire.email == this.useremail) {
                finalDisputes.push(litige);
            }
        }
        this.litiges = finalDisputes;
    }
}
</script>
