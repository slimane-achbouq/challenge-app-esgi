<template>
    <div class="flex h-screen overflow-hidden">

        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>
        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

                    <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16" v-if="dispute">
                        <!-- Content -->
                        <div>
                            <header class="mb-4 flex justify-between">
                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2 ">Announce
                                    <span class="text-indigo-500">{{ dispute.annonce.title }}</span></h1>
                            </header>

                            <!-- Meta -->
                            <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
                                <!-- Author -->
                                <div class="flex items-center sm:mr-4">
                                    <span class="block text-sm font-semibold text-slate-800 whitespace-nowrap"
                                          href="#0">
                                    </span>
                                </div>
                            </div>

                            <div class="text-sm font-semibold text-indigo-500 uppercase mb-2"></div>
                            <!-- Image -->
                            <figure class="mb-6">
                                <img class="w-full rounded-sm"
                                     :src="src"
                                     width="640" height="360" alt="Product"/>
                            </figure>

                            <!-- Product content -->
                            <div>
                                <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Description</h2>
                                <p class="mb-6">{{ dispute.annonce.description }}</p>
                            </div>

                            <hr class="my-6 border-t border-slate-200"/>
                        </div>
                        <div class="float-right">
                            <header class="mb-4 flex justify-between">
                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2 ">Dispute details</h1>
                            </header>
                            <div>
                                <div v-if="dispute.image">
                                    <figure class="mb-6">
                                        <img class="rounded-sm"
                                             :src="disputeSrc"
                                             width="640" height="360" alt="Product"/>
                                    </figure>
                                </div>
                                <div>
                                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Reason</h2>
                                    <p class="mb-6">{{ dispute.raison }}</p>
                                </div>
                                <div>
                                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Description</h2>
                                    <p class="mb-6">{{ dispute.description }}</p>
                                </div>
                                <div>
                                    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Disputed by</h2>
                                    <p class="mb-6">{{ dispute.locataire.email }} <br> {{ dispute.locataire.phoneNumber}}</p>
                                </div>
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
import Header from '../partials/Header.vue';
import Sidebar from '../partials/Sidebar.vue';
import ModalBasic from '../components/Modal.vue';
import {StripeCheckout} from "@vue-stripe/vue-stripe";

export default {
    name: 'Litige',
    components: {
        Header,
        ModalBasic,
        Sidebar,
    },
    data() {
        return {
            dispute: null,
            src: "",
            disputeSrc: "",
        }
    },
    methods: {
        submit: function () {
            this.$refs.checkoutRef.redirectToCheckout();
        },
    },
    setup() {
        return {}
    },
    async created() {
        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        let token = this.$store.getters["auth/token"]
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]
        console.log(id)
        const response = await fetch(`${import.meta.env.VITE_API_URL}/litiges/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let res = await response.json();
        let date = new Date(res.createdAt);
        res.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();

        this.dispute = res;
        this.src = import.meta.env.VITE_API_URL + '/uploads/images_annonces/' + res.annonce.image;
        this.disputeSrc = import.meta.env.VITE_API_URL + '/uploads/images_litiges/' + res.image;
        console.log(res)
    }
}
</script>
