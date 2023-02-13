<template>
    <div class="flex h-screen overflow-hidden">

        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>
        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

                    <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16" v-if="demande">
                        <!-- Content -->
                        <div>
                            <header class="mb-4 flex justify-between">
                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2 ">Request : Announce
                                    "{{ annonce.title }}"</h1>
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
                                <p class="mb-6">{{ annonce.description }}</p>
                            </div>

                            <hr class="my-6 border-t border-slate-200"/>
                        </div>
                        <div class="float-right">
                            <header class="mb-4 flex justify-between">
                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2 ">Request details</h1>
                            </header>
                            <div>
                                <p>
                                    Definitive dates <br><br>
                                    From : <span class="text-blue-500">{{ demande.dateStart }}</span> <br>
                                    To : <span class="text-blue-500">{{ demande.dateEnd }}</span>

                                    <br><br>

                                    Total price :
                                    <span v-if="annonce.isPerHour" class="text-blue-500">
                                        {{ pricePerHour }}€
                                    </span>
                                    <span v-else class="text-blue-500">
                                        {{ annonce.price }}€
                                    </span>
                                </p>

                                <div v-if="sessionId && !demande.isPaid">
                                    <stripe-checkout
                                        ref="checkoutRef"
                                        :pk="publishableKey"
                                        :sessionId="sessionId"
                                    />
                                    <button class="btn bg-green-700 text-white inline"
                                            style="margin-top: 50px"
                                            @click="submit">
                                        Proceed to checkout
                                    </button>
                                </div>
                                <div v-else style="margin-top: 50px">
                                    <span class="text-green-500">Currently renting</span>

                                    <div style="margin-top: 40px">
                                        <router-link :to="{ name: 'new-dispute', params: {id: demande.annonce.id}}">
                                            <button class="btn bg-red-500 text-white">File a dispute</button>
                                        </router-link>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div>


            <h2 class="text-slate-800 font-semibold mb-2" v-if="isLocataire && demande.isPaid">Recover the article at the address</h2>
            <div class="bg-white p-4 border border-slate-200 rounded-sm shadow-sm" v-if=" isLocataire && demande.isPaid">
              <ul class="space-y-3">

                <!-- Item -->
                <li class="sm:flex sm:items-center sm:justify-between">
                  <div class="sm:grow flex items-center text-sm">
                    <!-- Icon -->
                    <div class="w-8 h-8 rounded-full shrink-0 bg-amber-500 my-2 mr-3 p-0.2">
                        <svg class="w-8 h-6 mt-1 fill-current text-amber-50 " viewBox="0 0 16 16">
                            <path d="M8 8.992a2 2 0 1 1-.002-3.998A2 2 0 0 1 8 8.992Zm-.7 6.694c-.1-.1-4.2-3.696-4.2-3.796C1.7 10.69 1 8.892 1 6.994 1 3.097 4.1 0 8 0s7 3.097 7 6.994c0 1.898-.7 3.697-2.1 4.996-.1.1-4.1 3.696-4.2 3.796-.4.3-1 .3-1.4-.1Zm-2.7-4.995L8 13.688l3.4-2.997c1-1 1.6-2.198 1.6-3.597 0-2.798-2.2-4.996-5-4.996S3 4.196 3 6.994c0 1.399.6 2.698 1.6 3.697 0-.1 0-.1 0 0Z" />
                        </svg>
                    </div>
                    <!-- Position -->
                    <div>
                      <div class="font-medium text-slate-800">Address : </div>
                      <div class="flex flex-nowrap items-center space-x-2 whitespace-nowrap">
                        <div>{{this.annonce.owner.street}}</div>
                        <div class="text-slate-600">·</div>
                        <div>{{this.annonce.owner.city}}</div>
                        <div class="text-slate-600">·</div>
                        <div>{{this.annonce.owner.postalCode}}</div>
                        <div class="text-slate-600">·</div>
                      </div>
                    </div>
                  </div>
                </li>

              </ul>
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
import Header from '@/partials/Header.vue';
import Sidebar from '@/partials/Sidebar.vue';
import ModalBasic from '@/components/Modal.vue';
import {StripeCheckout} from "@vue-stripe/vue-stripe";

export default {
    name: 'Request',
    components: {
        Header,
        ModalBasic,
        Sidebar,
        StripeCheckout,
    },
    data() {
        return {
            publishableKey: "pk_test_51MZYljHiiKajDgAsKTAGtexDySSMf7qJ1VxyjEIebTMcEcttRWeCGMnXtXgtCdEf0iN5k60WuXQxGlAva3xG0Yvo00ImgD98YH",
            sessionId: null,
            owner: null,
            demande: null,
            annonce: null,
            src: "",
            isLocataire:false,
            pricePerHour:null,
        }
    },
    methods: {
        getStripeSession: async function () {
            let token = localStorage.getItem('esgi-ws-token');
            let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);

            const formData = new FormData();
            formData.append('title', this.annonce.title);
            if (this.annonce.isPerHour) {
                formData.append('price', this.pricePerHour);
            }
            else {
                formData.append('price', this.annonce.price);
            }
            formData.append('image', this.annonce.image);
            formData.append('token', token);
            formData.append('request_id', id);
            const request = await fetch(`${import.meta.env.VITE_API_URL}/stripe/getSession`, {
                method: 'POST',
                headers: {
                    // 'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: formData
            });

            const response = await request.json();
            this.sessionId = response.id;
        },
        submit: function () {
            this.$refs.checkoutRef.redirectToCheckout();
        },
    },
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

        if(response.status == 404) {
            this.$router.push('/dashboard/requests');
        }

        let res = await response.json();
        if (this.role != "Admin") {
            if (this.useremail != res.annonce.owner.email) {
                if (this.useremail != res.locataire.email) {
                    this.$router.push('/dashboard/requests');
                }
                else{
                    this.isLocataire=true
                }
            }
        }

        let date = new Date(res.dateStart);
        res.dateStart = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
        let date2 = new Date(res.dateEnd);
        res.dateEnd = date2.toLocaleDateString() + " at " + date2.toLocaleTimeString();

        if (res.annonce.isPerHour) {
            let diff =(date2.getTime() - date.getTime()) / 1000;
            // diff /= (60 * 60);
            diff = Math.abs(date - date2) / 36e5;
            this.pricePerHour = Math.round(diff * res.annonce.price);
        }

        this.demande = res;
        this.annonce =  res.annonce;
        this.src = import.meta.env.VITE_API_URL + '/uploads/images_annonces/' + res.annonce.image;

        await this.getStripeSession();
    }
}
</script>
