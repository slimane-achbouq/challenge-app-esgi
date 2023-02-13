<template>
    <div class="flex h-screen overflow-hidden">

        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>
        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

                    <div class="sm:flex sm:justify-between sm:items-center mb-8">


                        <!-- Left: Title -->
                        <div class="mb-4 sm:mb-0">
                            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Request history ✨</h1>
                        </div>


                        <!-- Right: Actions  -->
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

                            <!-- Delete button -->
                        </div>

                    </div>
                    <div class="bg-white shadow-lg rounded-sm border border-slate-200 relative">
                        <!-- Page content -->
                        <!-- Content -->
                        <div>
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full text-center">
                                    <thead
                                        class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
                                    <tr>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Created by
                                        </th>
                                        <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">Created At
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="demandeHistories" class="text-sm divide-y divide-slate-200">
                                    <tr v-for="dh in demandeHistories" v-bind:key="dh.id">
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ dh.owner.email }}
                                        </td>
                                        <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                                            {{ dh.createdAt }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
                        <router-link to="/dashboard/requests">
                            <button class="btn bg-indigo-500 text-white" style="margin-top: 30px">Go back</button>
                        </router-link>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import Header from '@/partials/Header.vue'
import Sidebar from '@/partials/Sidebar.vue'
import ModalBasic from '@/components/Modal.vue'

let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
export default {
    name: 'DemandeHistory',
    components: {
        Header,
        ModalBasic,
        Sidebar
    },
    data() {
        return {
            owner: null,
            demande: null,
            createdAt: null,
            demandeHistories: null
        }
    },
    methods: {},
    setup() {
        return {}
    },
    async created() {
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }

        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        let token = this.$store.getters["auth/token"]
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]

        const response = await fetch(`${import.meta.env.VITE_API_URL}/demandes/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let res = await response.json();
        let data = res.demandeHistories
        let finalDemandesHistory = [];
        for (let demandeHistory of data) {
            let date = new Date(demandeHistory.createdAt);
            demandeHistory.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
            finalDemandesHistory.push(demandeHistory);
        }
        this.demandeHistories = finalDemandesHistory;
    }
}
</script>
