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

                    </div>

                    <!-- Page content -->
                    <div
                        class="flex flex-col space-y-10 sm:flex-row sm:space-x-6 sm:space-y-0 md:flex-col md:space-x-0 md:space-y-10 xl:flex-row xl:space-x-6 xl:space-y-0 mt-9">

                        <!-- Sidebar -->
                        <div>
                            <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5 min-w-60">
                                <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-6">
                                    <!-- Group 1 -->
                                    <div>
                                        <ul class="text-sm font-medium space-y-2">
                                            <li>
                                                <a class="text-indigo-500" href="#0">View All</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('electromenager')">Home appliance</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('informatique')">Computer/Smartphone/Console</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('livre')">Book</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('vetements')">Clothing</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('jardinage')">Gardening</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('meuble')">Furniture</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('Vehicule')">Véhicule</a>
                                            </li>
                                            <li>
                                                <a class="text-slate-600 hover:text-slate-700" href="#0"
                                                   @click="filterTerm('alimentaire')">Alimentary</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Price Range -->
                                    <div>
                                        <div class="text-sm text-slate-800 font-semibold mb-3">Price Range</div>
                                        <label class="sr-only">Price</label>
                                        <select class="form-select w-full" @change="handleChange($event)">
                                            <option value="0..20">Less than €20</option>
                                            <option value="20..40">€20 - €40</option>
                                            <option value="40..80">€40 - €80</option>
                                            <option value="gt">More than $80</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                    <li class="m-1" @click="onNewest()">
                                        <button
                                            class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Newest
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button @click="onPrice('true')"
                                                class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Per Hour
                                        </button>
                                    </li>
                                    <li class="m-1">
                                        <button @click="onPrice('false')"
                                                class="inline-flex items-center justify-center text-sm font-medium leading-5 rounded-full px-3 py-1 border border-slate-200 hover:border-slate-300 shadow-sm bg-white text-slate-500 duration-150 ease-in-out">
                                            Price Fix
                                        </button>
                                    </li>
                                </ul>
                            </div>


                            <div class="mb-5">
                                <!-- Start -->
                                <form>
                                    <label class=" block text-sm font-medium mb-1" for="form-search"></label>
                                    <div class="relative">
                                        <input id="form-search" class="form-input w-full pl-9" type="search"
                                               v-model="searchTerm" @input="searchCustomers"/>
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
                            <div class="mt-8">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
                                        <ul class="flex justify-center">
                                            <li class="ml-3 first:ml-0">
                                                <a class="btn bg-white border-slate-200 "
                                                   :class="{ 'text-slate-300 cursor-not-allowed': page === 1,'hover:border-slate-300 text-indigo-500': page != 1}"
                                                   @click.prevent="handlePreviousPagination">&lt;- Previous</a>
                                            </li>
                                            <li class="ml-3 first:ml-0">
                                                <a class="btn bg-white border-slate-200 "
                                                   :class="{ 'text-slate-300 cursor-not-allowed': page >= lastPage,'hover:border-slate-300 text-indigo-500': page < lastPage}"
                                                   @click.prevent="handleNextPagination">Next -&gt;</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="text-sm text-slate-500 text-center sm:text-left">
                                        Showing <span class="font-medium text-slate-600">{{ page }}</span> to <span
                                        class="font-medium text-slate-600">{{ lastPage }}</span> of <span
                                        class="font-medium text-slate-600">{{ totalResult }}</span> results
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
import axios from 'axios'

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
            page: 1,
            currentRole: null,
            searchTerm: "",
            perPage: 5,
            lastPage: 0,
            totalResult: 0,
            basedURL: null
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
            if (this.page < this.lastPage) {
                this.page++
                this.fetchData()
            }
        },
        handlePreviousPagination(n) {
            if (this.page > 0) {
                this.page--
                this.fetchData()
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
            this.basedURL = urlFetch
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
        },

        async searchCustomers() {
            this.page = 1
            let token = this.$store.getters["auth/token"]
            let urlFetch = import.meta.env.VITE_API_URL + "/annonces?title=" + this.searchTerm + "&page=" + this.page;
            this.basedURL = import.meta.env.VITE_API_URL + "/annonces?title=" + this.searchTerm + "&page="
            const response = await axios.get(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }

        },
        async filterTerm(term) {
            this.page = 1
            let token = this.$store.getters["auth/token"]
            let currentRole = this.$store.getters["auth/role"]
            let urlFetch

            if (currentRole == "Admin") {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?category=" + term + "&page=" + this.page;
                this.basedURL = import.meta.env.VITE_API_URL + "/annonces?category=" + term
            } else {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?category=" + term + "&status=1" + "&page=" + this.page;
                this.basedURL = urlFetch = import.meta.env.VITE_API_URL + "/annonces?category=" + term + "&status=1"
            }

            const response = await axios.get(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }
        },

        async handleChange(event) {
            this.page = 1
            let token = this.$store.getters["auth/token"]
            let currentRole = this.$store.getters["auth/role"]
            var selectedValue = event.target.value;
            let urlFetch

            if (selectedValue != "gt") {

                if (currentRole == "Admin") {
                    urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[between]=" + selectedValue + "&page=" + this.page;
                } else {
                    urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[between]=" + selectedValue + "&status=1" + "&page=" + this.page;
                }

            } else {
                if (currentRole == "Admin") {
                    urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[gt]=80" + "&page=" + this.page;
                } else {
                    urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[gt]=80" + "&status=1" + "&page=" + this.page;
                }

            }


            const response = await axios.get(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }
            return;

        },

        async onNewest() {
            this.page = 1
            let currentRole = this.$store.getters["auth/role"]
            var date = new Date();

            date.setTime(date.getTime() - 24 * 60 * 60 * 1000);

            var fullDate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();


            let token = this.$store.getters["auth/token"]

            let urlFetch

            if (currentRole == "Admin") {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate + "&page=" + this.page
                this.basedURL = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate
            } else {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate + "&status=1" + "&page=" + this.page;
                this.basedURL = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate + "&status=1"
            }

            const response = await axios.get(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }


            return;
        },

        async onPrice(status) {

            this.page = 1
            let currentRole = this.$store.getters["auth/role"]
            let token = this.$store.getters["auth/token"]
            let urlFetch;

            if (currentRole == "Admin") {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status + "&page=" + this.page
                this.basedURL = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status + "&page="
            } else {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status + "&status=1" + "&page=" + this.page;
                this.basedURL = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status + "&status=1" + "&page="
            }

            const response = await axios.get(urlFetch, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }

            return;
        },

        async fetchData() {
            if (!this.$store.getters["auth/isAuthenticated"]) {
                this.$router.push('/');
            }

            let token = this.$store.getters["auth/token"]
            let currentRole = this.$store.getters["auth/role"]

            let urlFetch = "";

            if (currentRole == "Admin") {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?page=" + this.page
            } else {
                urlFetch = import.meta.env.VITE_API_URL + "/annonces?status=1&page=" + this.page;
            }


            if (this.basedURL) this.basedURL = this.basedURL + "&page=" + this.page
            else this.basedURL = urlFetch
            const response = await axios.get(this.basedURL, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if (response.data["hydra:member"]) {

                let data = await response.data;
                this.announces = data['hydra:member'];
                this.totalResult = await response.data["hydra:totalItems"];
            }
            if (response.data["hydra:view"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }

            this.url = import.meta.env.VITE_API_URL;
            this.currentRole = currentRole;

        }

    },
    async created() {
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        let token = this.$store.getters["auth/token"]
        let currentRole = this.$store.getters["auth/role"]
        let urlFetch = "";

        if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces";
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?status=1";
        }
        const response = await axios.get(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        if (response.data["hydra:member"]) {

            let data = await response.data;
            this.announces = data['hydra:member'];
            this.totalResult = await response.data["hydra:totalItems"];
        }
        if (response.data["hydra:view"]) {
            if (response.data["hydra:view"]["hydra:last"]) {
                this.lastPage = await response.data["hydra:view"]["hydra:last"].split("page=")[1];
            }
        }

        this.url = import.meta.env.VITE_API_URL;
        this.currentRole = currentRole;
    }
}
</script>
