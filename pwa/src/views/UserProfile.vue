<template>
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-white">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>


            <main>

                <div class="lg:relative lg:flex">
                    <!-- Content -->
                    <div class="px-4 sm:px-6 lg:px-8 py-8 lg:grow lg:pr-8 xl:pr-16 2xl:ml-[80px]">
                        <div class="lg:mx-auto">

                            <div role="status" v-if="loading">
                                <svg aria-hidden="true"
                                     class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor"/>
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <Banner type="success" :open="true" v-if="updated">
                                User information updated successfully.
                            </Banner>

                            <!-- Cart items -->
                            <div class="mb-6 lg:mb-0">
                                <header class="mb-6">
                                    <!-- Title -->
                                    <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2">User
                                        informations✨</h1>
                                </header>
                                <!-- Billing Information -->
                                <div>
                                    <div class="mb-4 flex justify-between">
                                        <div class="text-slate-800 font-semibold mb-4">Edit Information</div>
                                        <!--                    <router-link :to="{ name: 'userannounces', params: { lastName: user.lastName }}">
                                                              <a class="text-slate-800 font-semibold mb-4">See all announces</a>
                                                            </router-link>-->
                                    </div>

                                    <form>
                                        <div class="space-y-4">
                                            <!-- 1st row -->
                                            <div class="md:flex space-y-4 md:space-y-0 md:space-x-4"
                                                 v-if="user.roles && user.roles.includes('ROLE_INDIVIDUAL')">
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1" for="firstname">First
                                                        Name</label>
                                                    <input id="firstname" class="form-input w-full" type="text"
                                                           v-model="user.firstName"/>
                                                    <div v-if="errors.name" class="text-xs mt-1 text-rose-500">
                                                        {{ errors.name }}
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1" for="lastname">Last
                                                        Name</label>
                                                    <input id="lastname" class="form-input w-full" type="text"
                                                           v-model="user.lastName"/>

                                                    <div v-if="errors.familyName" class="text-xs mt-1 text-rose-500">
                                                        {{ errors.familyName }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:flex space-y-4 md:space-y-0 md:space-x-4"
                                                 v-eles-if="user.roles && user.roles.includes('ROLE_SELF_EMPLOYED')">
                                            </div>
                                            <!-- 2nd row -->
                                            <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1"
                                                           for="address">E-mail:</label>
                                                    <input id="address" class="form-input w-full" type="text"
                                                           v-model="user.email"/>
                                                    <div v-if="errors.email" class="text-xs mt-1 text-rose-500">
                                                        {{ errors.email }}
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1" for="card-city">Phone
                                                        Number</label>
                                                    <input id="card-city" class="form-input w-full"
                                                           v-model="user.phoneNumber" type="text"/>
                                                    <div v-if="error" class="text-xs mt-1 text-rose-500">{{
                                                            error
                                                        }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 3rd row -->
                                            <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                                                <div class="flex-1" v-if="user.profession">
                                                    <label class="block text-sm font-medium mb-1" for="card-country">Profession:
                                                        <span class="text-rose-500">*</span></label>
                                                    <input id="card-state" class="form-input w-full" type="text"
                                                           v-model="user.profession"/>
                                                </div>
                                                <div class="flex-1" v-if="user.associationName">
                                                    <label class="block text-sm font-medium mb-1" for="card-state">Association
                                                        name</label>
                                                    <input id="card-state" class="form-input w-full" type="text"
                                                           v-model="user.associationName"/>
                                                </div>
                                                <div class="flex-1" v-if="user.commercialName">
                                                    <label class="block text-sm font-medium mb-1" for="card-country">Commercial
                                                        name: <span class="text-rose-500">*</span></label>
                                                    <input id="card-state" class="form-input w-full" type="text"
                                                           v-model="user.commercialName"/>
                                                </div>

                                            </div>
                                            <!-- Divider -->
                                            <hr class="my-2 border-t border-slate-200"/>


                                            <!-- Street Address -->
                                            <div>
                                                <label class="block text-sm font-medium mb-1" for="street"
                                                >Edit Address: <span class="text-rose-500">*</span></label
                                                >
                                                <input
                                                    autoComplete='none'
                                                    id="street"
                                                    class="form-input w-full"
                                                    type="text"
                                                    v-model.trim="user.street"
                                                    @input="searchStreet($event)"
                                                />

                                                <div class="" v-if="isAddressLoading">
                                                    <svg class="animate-spin w-4 h-4 fill-current shrink-0"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z"/>
                                                    </svg>
                                                </div>

                                                <div v-else-if="searchedAddresses"
                                                     v-for="searchedAddress in searchedAddresses"
                                                     :key="searchedAddress.properties.id">
                                                    <div
                                                        class="text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                        <button @click="setAddress(searchedAddress)" type="button"
                                                                class="relative inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                                                            {{ searchedAddress.properties.label }}
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- 4th row -->
                                            <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1" for="card-vat">Street
                                                        Address:</label>
                                                    <input id="card-vat" class="form-input w-full cursor-not-allowed"
                                                           type="text" v-model="user.street" disabled/>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1"
                                                           for="card-vat">City</label>
                                                    <input id="card-vat" class="form-input w-full cursor-not-allowed"
                                                           type="text" v-model="user.city" disabled/>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium mb-1" for="card-postcode">Postcode</label>

                                                    <input id="card-postcode"
                                                           class="form-input w-full cursor-not-allowed" type="text"
                                                           v-model="user.postalCode" disabled/>
                                                </div>

                                            </div>

                                            <div class="text-right">
                                                <button
                                                    class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500"
                                                    @click.prevent="updateUser">Edit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Divider -->
                                <hr class="my-6 border-t border-slate-200"/>


                            </div>

                        </div>
                    </div>

                </div>
            </main>

        </div>

    </div>
</template>

<script>
import {ref} from 'vue'
import Sidebar from '@/partials/Sidebar.vue'
import Header from '@/partials/Header.vue'
import Banner from "@/components/Banner.vue"
import axios from 'axios'
import {
    phoneValidation,
    emailValidation,

} from "@/utils/utils-common-function";

export default {
    name: 'UserProfile',
    components: {
        Sidebar,
        Header,
        Banner,

    },
    data() {
        return {
            searchedAddresses: [],
            user: {
                firstName: "",
                lastName: "",
                email: "",
                phoneNumber: "",
                street: "",
                postalCode: "",
                city: "",
                associationName: "",
                commercialName: "",
                profession: "",
                isVerified: false,
                annonces: [],
                id: 0
            },
            isAddressLoading: false,
            errors: {
                associationName: "",
                profession: "",
                comercialName: "",
                name: "",
                familyName: "",
                street: "",
                city: "",
                postalCode: "",
                phoneNumber: "",
                email: "",
                password: "",
            },
            error: null,
            updated: false,
            loading: false,
            basedEmail: ""
        }
    },
    methods: {
        async updateUser() {

            if (this.user.roles.includes("ROLE_INDIVIDUAL")) {
                if (!this.user.firstName) {
                    this.errors.name = "Veuillez revérifier votre nom";
                    return;
                }
                if (!this.user.lastName) {
                    this.errors.familyName = "Veuillez revérifier votre prénom";
                    return;
                }
            }

            if (!emailValidation(this.user.email)) {
                this.errors.email = "Please check your email if it is valid";
                return;
            }

            if (!phoneValidation(this.user.phoneNumber)) {
                this.error =
                    "Please check your phone number if it is valid";
                return;
            }

            this.loading = true

            try {
                let userInformations = {
                    firstName: this.user.firstName,
                    lastName: this.user.lastName,
                    email: this.user.email,
                    phoneNumber: this.user.phoneNumber,
                    associationName: this.user.associationName,
                    commercialName: this.user.commercialName,
                    street: this.user.street,
                    profession: this.user.profession,
                }


                const response = await axios.patch(`${import.meta.env.VITE_API_URL}/users/${this.user.id}`, userInformations, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('esgi-ws-token')}`
                    }
                })
                this.updated = true

            } catch (error) {
                console.error(error)
            }

            if (this.basedEmail != this.user.email) {

                await localStorage.clear();
                this.$router.replace("/login");

            }

            this.loading = false


        },
        async searchStreet(event) {
            this.isAddressLoading = true;
            try {
                const street = event.target.value;
                if (street.length <= 3) {
                    return;
                }
                const response = await fetch(`https://api.zaidalaahazim.fr/address/` + new URLSearchParams(street));

                if (response.ok) {
                    const data = await response.json();
                    const parsedData = await JSON.parse(data);
                    this.searchedAddresses = parsedData.features;
                }
            } catch (error) {
                this.error = error.message
            }

            this.isAddressLoading = false;
        },

        setAddress(address) {
            this.user.city = address.properties.city;
            this.user.postalCode = address.properties.postcode;
            this.user.street = address.properties.name;
            this.searchedAddresses = [];
        },

    },
    async created() {
        this.loading = true
        let token = this.$store.getters["auth/token"]
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]
        this.basedEmail = this.useremail

        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        const response = await fetch(`${import.meta.env.VITE_API_URL}/users/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json();
        this.user = await data
        console.log(data.roles)
        this.loading = false
    }
}
</script>
