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
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">My List of announcements ✨</h1>

                    </div>

                    <!-- Page content -->
                    <div
                        class="">

                        <!-- Content -->
                        <div>


                            <div class="text-sm text-slate-500 italic mb-4">67.975 Items</div>

                            <div class="mb-5">
                                <!-- Start -->
                                <form>
                                    <label class=" block text-sm font-medium mb-1" for="form-search"></label>
                                    <div class="relative">
                                        <input id="form-search" class="form-input w-full pl-9" type="search"/>
                                        <button class="absolute inset-0 right-auto group" type="submit"
                                                aria-label="Search">
                                            <svg
                                                class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2"
                                                viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z"/>
                                                <path
                                                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <!-- End -->
                            </div>


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
                            <div class="mt-6">
                                <Pagination @increasePage="handleNextPagination"
                                            @decreasePage="handlePreviousPagination" :page="page"/>
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
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'
import AnnonceSidebar from '../partials/dashboard/annonce/AnnonceSidebar.vue'
import AnnonceCards from '../partials/dashboard/annonce/AnnonceCards.vue'
import Pagination from '../components/Pagination.vue'

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
        console.log(lastname)       
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        let token = this.$store.getters["auth/token"]
        let email = this.$store.getters["auth/email"]
        let currentRole = this.$store.getters["auth/role"]
        let urlFetch = "";

        const response = await fetch(`${import.meta.env.VITE_API_URL}/users?lastName=${lastname}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json();
        this.announces = await data["hydra:member"][0].annonces
    }
}
</script>
