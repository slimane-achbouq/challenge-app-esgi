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
                                    <p class="mb-6">{{ dispute.locataire.email }} <br>
                                        {{ dispute.locataire.phoneNumber }}</p>
                                </div>
                                <hr class="my-6 border-t border-slate-200"/>
                                <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Final decision</h2>
                                <span v-if="dispute.status == 0">Wait for an admin to take a decision.</span>
                                <span v-else class="text-indigo-500">{{ dispute.decision }}</span>
                                <p v-if="dispute.status != 0">
                                    Further explanation given :
                                    <span v-if="dispute.decisionExplanation" class="text-indigo-500">{{ dispute.decisionExplanation }}</span>
                                    <span v-else class="text-indigo-500">None.</span>
                                </p>
                                <button v-if="dispute.status == 0 && this.role == 'Admin'"
                                        class="btn bg-indigo-500 text-white"
                                        @click="onOpenModal">Take a decision
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <router-link to="/dashboard/requests">
                            <button class="btn bg-indigo-500 text-white" style="margin-top: 30px">Go back</button>
                        </router-link>
                    </div>
                </div>

                <ModalBasic id="feedback-modal" :modalOpen="modalOpen" @close-modal="onModalClose"
                            title="Edit dispute">
                    <!-- Modal content -->
                    <div class="px-5 py-4">
                        <div class="space-y-3 ">

                            <div class="col-span-1">
                                <label class="block text-sm font-medium mb-1" for="mandatory">Choose a decision<span
                                    class="text-rose-500">*</span></label>
                                <select id="mandatory" name="mandatory" class="form-select w-full" v-model="decision"
                                        required>
                                    <option value="No special decision.">No follow-up</option>
                                    <option value="The owner will be refunded.">Refund the owner</option>
                                    <option value="The renter will be refunded.">Refund the renter</option>
                                    <option value="The renter will be banned.">Owner ban</option>
                                    <option value="The renter will be banned.">Renter ban</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="detail"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Explanation
                                    (optional)</label>
                                <textarea id="detail" name="detail" rows="3" v-model.trim="explanation"
                                          class="form-textarea w-full text-gray-900 dark:text-gray-300 dark:bg-gray-800"
                                          placeholder="Additional precisions."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="px-5 py-4 border-t border-slate-200">
                        <div class="flex flex-wrap justify-end space-x-2">
                            <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                                    @click.stop="modalOpen=false">Cancel
                            </button>
                            <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white"
                                    @click.prevent="handleSubmitDecision">
                                Submit decision
                            </button>
                        </div>
                    </div>
                </ModalBasic>
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
            modalOpen: false,
            role: "",
            decision: null,
            explanation: null,
            renterBanned: false,
            ownerBanned: false,
        }
    },
    methods: {
        onOpenModal() {
            this.modalOpen = true
        },
        handleSubmitDecision: async function () {
            let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
            let token = this.$store.getters["auth/token"]
            this.role = this.$store.getters["auth/role"]
            this.useremail = this.$store.getters["auth/email"]

            const response = await fetch(`${import.meta.env.VITE_API_URL}/litiges/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    decision: this.decision,
                    decisionExplanation: this.explanation,
                    status: 1,
                })
            });

            const res = await response.json();
            this.modalOpen = false
            await this.updateData();
        },
        updateData: async function () {
            let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
            let token = this.$store.getters["auth/token"]
            this.role = this.$store.getters["auth/role"]
            this.useremail = this.$store.getters["auth/email"]

            const response = await fetch(`${import.meta.env.VITE_API_URL}/litiges/${id}`, {
                method: 'GET',
                headers: {
                    // 'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${token}`
                },
            });

            if(response.status == 404) {
                this.$router.push('/dashboard/disputes');
            }

            let res = await response.json();
            if (this.role != "Admin") {
                if (this.useremail != res.annonce.owner.email) {
                    if (this.useremail != res.locataire.email) {
                        this.$router.push('/dashboard/disputes');
                    }
                }
            }

            let date = new Date(res.createdAt);
            res.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();

            this.dispute = res;
            this.src = import.meta.env.VITE_API_URL + '/uploads/images_annonces/' + res.annonce.image;
            this.disputeSrc = import.meta.env.VITE_API_URL + '/uploads/images_litiges/' + res.image;
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

        const response = await fetch(`${import.meta.env.VITE_API_URL}/litiges/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        if(response.status == 404) {
            this.$router.push('/dashboard/disputes');
        }

        let res = await response.json();
        if (this.role != "Admin") {
            if (this.useremail != res.annonce.owner.email) {
                if (this.useremail != res.locataire.email) {
                    this.$router.push('/dashboard/disputes');
                }
            }
        }

        let date = new Date(res.createdAt);
        res.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();

        this.dispute = res;
        console.log(res)
        this.src = import.meta.env.VITE_API_URL + '/uploads/images_annonces/' + res.annonce.image;
        this.disputeSrc = import.meta.env.VITE_API_URL + '/uploads/images_litiges/' + res.image;
    }
}
</script>
