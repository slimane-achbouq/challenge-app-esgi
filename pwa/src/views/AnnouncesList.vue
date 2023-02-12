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
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('electromenager')">Électroménager</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('informatique')">Informatique</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('livre')">Livre</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('vetements')">Vêtements</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('jardinage')">Jardinage</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('meuble')">Meuble</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('Vehicule')">Véhicule</a>
                                    </li>
                                    <li>
                                        <a class="text-slate-600 hover:text-slate-700" href="#0" @click="filterTerm('alimentaire')">Alimentaire</a>
                                    </li>
                                    </ul>
                                </div>
                                <!-- Price Range -->
                                <div>
                                    <div class="text-sm text-slate-800 font-semibold mb-3">Price Range</div>
                                    <label class="sr-only">Price</label>
                                    <select class="form-select w-full" @change="handleChange($event)" >
                                        <option value="0..20">Less than $20</option>
                                        <option value="20..40">$20 - $40</option>
                                        <option value="40..80">$40 - $80</option>
                                        <option value="gt">More than $80</option>
                                    </select>
                                </div>
                                <!-- Group 4 -->
                                <div>
                                    <div class="text-sm text-slate-800 font-semibold mb-3">Sort By Rating</div>
                                    <ul class="space-y-2">
                                    <li>
                                        <!-- Rating button -->
                                        <button class="flex items-center space-x-2 mr-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                        </div>
                                        <div class="inline-flex text-sm text-slate-500 italic"><span class="sr-only">4 Stars</span> And up</div>
                                        </button>
                                    </li>
                                    <li>
                                        <!-- Rating button -->
                                        <button class="flex items-center space-x-2 mr-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                        </div>
                                        <div class="inline-flex text-sm text-slate-500 italic"><span class="sr-only">3 Stars</span> And up</div>
                                        </button>
                                    </li>
                                    <li>
                                        <!-- Rating button -->
                                        <button class="flex items-center space-x-2 mr-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                        </div>
                                        <div class="inline-flex text-sm text-slate-500 italic"><span class="sr-only">2 Stars</span> And up</div>
                                        </button>
                                    </li>
                                    <li>
                                        <!-- Rating button -->
                                        <button class="flex items-center space-x-2 mr-2">
                                        <!-- Stars -->
                                        <div class="flex space-x-1">
                                            <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                            <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                            <path d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z" />
                                            </svg>
                                        </div>
                                        <div class="inline-flex text-sm text-slate-500 italic"><span class="sr-only">1 Stars</span> And up</div>
                                        </button>
                                    </li>
                                    </ul>
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


                            <div class="text-sm text-slate-500 italic mb-4">67.975 Items</div>

                            <div class="mb-5">
                                <!-- Start -->
                                <form>
                                    <label class=" block text-sm font-medium mb-1" for="form-search"></label>
                                    <div class="relative">
                                        <input id="form-search" class="form-input w-full pl-9" type="search" v-model="searchTerm" @input="searchCustomers"/>
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
            searchTerm:""
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
        },

        async searchCustomers () {
            let token = this.$store.getters["auth/token"]
            let urlFetch = import.meta.env.VITE_API_URL + "/annonces?title=" + this.searchTerm;
            console.log(urlFetch)
            const response = await fetch(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json()
        this.announces=data['hydra:member']
        console.log(data['hydra:member'])
             return ;
            
        },
        async filterTerm(term){
            let token = this.$store.getters["auth/token"]
            let currentRole = this.$store.getters["auth/role"]
            let urlFetch

            if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?category=" + term;
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?category=" + term+"&status=1";
        }
            

            console.log(urlFetch)
            const response = await fetch(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json()
        this.announces=data['hydra:member']
        console.log(data['hydra:member'])
             return ;
        },

        async handleChange(event) {
        let token = this.$store.getters["auth/token"]
        let currentRole = this.$store.getters["auth/role"]
        console.log("ok")
        var selectedValue = event.target.value;
        let urlFetch
        
        if (selectedValue != "gt"){

        if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[between]=" + selectedValue;
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[between]=" + selectedValue+"&status=1";
        }

        }
        else {
            if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[gt]=80";
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?price[gt]=80"+"&status=1";
        }

        }
        const response = await fetch(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json()
        this.announces=data['hydra:member']
        console.log(data['hydra:member'])
             return ;
        
    },

    async onNewest(){
        let currentRole = this.$store.getters["auth/role"]
        var date = new Date();

        date.setTime(date.getTime() - 24 * 60 * 60 * 1000);

        var fullDate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();


        console.log(fullDate)
        let token = this.$store.getters["auth/token"]

        let urlFetch
        
        if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?createdAt[after]=" + fullDate+"&status=1";
        }

        console.log(urlFetch)
        const response = await fetch(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json()
        this.announces=data['hydra:member']
        console.log(data['hydra:member'])
             return ;
    },

    async onPrice(status){

        let currentRole = this.$store.getters["auth/role"]
        let token = this.$store.getters["auth/token"]
        let urlFetch;
    
        if (currentRole == "Admin") {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status
        } else {
            urlFetch = import.meta.env.VITE_API_URL + "/annonces?isPerHour=" + status+"&status=1";
        }
        const response = await fetch(urlFetch, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json()
        this.announces=data['hydra:member']
        console.log(data['hydra:member'])
             return ;
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
}
</script>
