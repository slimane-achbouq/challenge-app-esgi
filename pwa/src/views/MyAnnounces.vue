<template>
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>

            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full  mx-auto">

                    <!-- Page header -->
                    <div class="mb-5">

                        <!-- Title -->
                        <h1 v-if="currentRole!=='Admin'" class="text-2xl md:text-3xl text-slate-800 font-bold">My List of announcements ✨</h1>
                        <h1 v-if="currentRole=='Admin'" class="text-2xl md:text-3xl text-slate-800 font-bold">List of announcements of this user </h1>

                    </div>

                    <!-- Page content -->
                    <div
                        class="">

                        <!-- Content -->
                        <div>


                            <div class="text-sm text-slate-500 italic mb-4"></div>

                            <!-- Divider -->
                            <!-- Divider -->
                            <hr class="my-2 border-t border-slate-200" />


                            <!-- Cards 1 (Video Courses) -->
                            <div>
                                <div>
                                    <div class="grid grid-cols-12 gap-6">
                                        <AnnonceCards v-for="announce in announces"
                                                      :key="announce['@id'].match(/\d+/)[0]" v-bind="announce"
                                                      :url="url"
                                                      :src="url + '/uploads/images_annonces/' + announce.image"
                                                      :id="announce['@id'].match(/\d+/)[0]" :currentRole="currentRole"/>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </main>

        </div>

    </div>
</template>

<script>
import {provide, ref} from 'vue'
import Sidebar from '@/partials/Sidebar.vue'
import Header from '@/partials/Header.vue'
import AnnonceSidebar from '@/partials/dashboard/annonce/AnnonceSidebar.vue'
import AnnonceCards from '@/partials/dashboard/annonce/AnnonceCards.vue'
import Pagination from '@/components/Pagination.vue'

export default {
    name: 'MyAnnounces',
    components: {
        Sidebar,
        Header,
        AnnonceSidebar,
        AnnonceCards,
        Pagination,
    },
    data() {
        return {
            announces: null,
            url: "",
            page: 1,
            currentRole: null,
        }
    },
    setup() {

        const sidebarOpen = ref(false)

        return {
            sidebarOpen,
        }
    },
    methods: {
        handleNextPagination(n) {
            this.page += n;
            this.updateData();
            provide('pageChange', this.page)
        },
        handlePreviousPagination(n) {
            if (this.page > 1) {
                this.page -= n;
                this.updateData();
                provide('pageChange', this.page)
            }
        },
        async updateData() {
            let token = this.$store.getters["auth/token"]
            let currentRole = this.$store.getters["auth/role"]
            let urlFetch = "";

            if (currentRole == "Admin") {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?page=" + this.page + "&itemsPerPage=5";
            } else {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?page=" + this.page + "&itemsPerPage=5&status=1";
            }
            const response = await fetch(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            let data = await response.json();
            this.announces = data['hydra:member'];
            this.url = import.meta.env.VITE_API_URL;
            this.currentRole = currentRole;
        }
    },
    async created() {

        let lastname = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        let token = this.$store.getters["auth/token"]
        let email = this.$store.getters["auth/email"]
        let currentRole = this.$store.getters["auth/role"]
        this.currentRole=currentRole
        let urlFetch = "";
        this.url = import.meta.env.VITE_API_URL;

        let response
        if(lastname==="myannouncement"){

            response = await fetch(`https://api.zaidalaahazim.fr/users?email=${email}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        }

        else {
         response = await fetch(`https://api.zaidalaahazim.fr/users?lastName=${lastname}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

    }
        let data = await response.json();
        this.announces = await data["hydra:member"][0].annonces
    }
}
</script>
