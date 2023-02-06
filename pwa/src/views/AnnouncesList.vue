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
                    <div class="mb-5">

                        <!-- Title -->
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">List of announcements ✨</h1>
                        <router-link to="/newannounce">
                            <span class="text-indigo-500">Create Announce</span>
                        </router-link>
                    </div>

                    <!-- Page content -->
                    <div
                        class="flex flex-col space-y-10 sm:flex-row sm:space-x-6 sm:space-y-0 md:flex-col md:space-x-0 md:space-y-10 xl:flex-row xl:space-x-6 xl:space-y-0 mt-9">

                        <!-- Sidebar -->
                        <AnnonceSidebar/>

                        <!-- Content -->
                        <div>

                            <!-- Filters -->
                            <div class="mb-5">
                                <ul class="flex flex-wrap -m-1">
                                    <li class="m-1">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-transparent shadow-sm bg-indigo-500 text-white duration-150 ease-in-out">
                                            View All
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Featured
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Newest
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Price - Low To High
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Price - High to Low
                                        </button>
                                    </li>
                                </ul>
                            </div>


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
                            <div v-for="announce in announces" :key="announce['@id'].match(/\d+/)[0]">
                                <div>
                                    <div class="grid grid-cols-12 gap-6">
                                        <AnnonceCards v-bind="announce" :url="url"
                                                      :src="url + '/uploads/images_annonces/' + announce.image"
                                                      :id="announce['@id'].match(/\d+/)[0]"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <Pagination @increasePage="handleNextPagination" @decreasePage="handlePreviousPagination" :page="page"/>
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
    name: 'AnnouncesList',
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
            page: 1
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
            console.log(this.page)
            provide('pageChange', this.page)
        },
        handlePreviousPagination(n) {
            if (this.page > 1) {
                this.page -= n;
                this.updateData();
                console.log(this.page)
                provide('pageChange', this.page)
            }
        },
        async updateData() {
            let token = this.$store.getters["auth/token"]

            const response = await fetch(`${import.meta.env.VITE_API_URL}/annonces?page=${this.page}`, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            let data = await response.json();
            this.announces = data['hydra:member'];
        }
    },
    async created() {
        let token = this.$store.getters["auth/token"]

        const response = await fetch(`${import.meta.env.VITE_API_URL}/annonces?page=${this.page}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json();
        this.announces = data['hydra:member'];
        this.url = import.meta.env.VITE_API_URL;
    }
}
</script>
