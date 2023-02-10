<template>
    <div class="space-y-4 mb-8" v-if="token && token == userTokenCheck" style="margin-top: 100px">
        <div class="text-center">
            <div class="success-checkmark">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                    <div class="icon-circle"></div>
                    <div class="icon-fix"></div>
                </div>
            </div>
            <h1 class="text-3xl text-slate-800 font-bold mb-8">Payment successful !</h1>
            <p>
                Transaction number : <span class="text-indigo-500" v-if="transactionId">{{ transactionId }}€</span> <br><br>
                Total amount : <span class="text-indigo-500" v-if="annonce">{{ annonce.price }}€</span>
            </p>
            <router-link class="btn bg-indigo-500 hover:bg-indigo-600 text-white" style="margin-top: 50px"
                         to="/dashboard">
                Go back to the homepage -&gt;
            </router-link>
        </div>
    </div>
    <div v-else>
        <div class="text-center" style="margin-top: 100px">
            <h1 class="text-3xl text-slate-800 font-bold mb-8">You seem lost.. !</h1>
            <router-link class="btn bg-indigo-500 hover:bg-indigo-600 text-white" to="/dashboard">Go back to the
                homepage
                -&gt;
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "PaymentSuccess",
    data() {
        return {
            owner: null,
            demande: null,
            annonce: null,
            src: "",
            token: null,
            userTokenCheck: null,
            user: null,
            id: null
        }
    },
    methods: {},
    setup() {
        return {}
    },
    async created() {
        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        this.id = id;
        let token = document.URL.split('/')[7];
        let userToken = this.$store.getters["auth/token"]

        console.log(token)

        this.userTokenCheck = userToken;
        this.token = token;
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
        this.demande = res;
        this.annonce = res.annonce;
        const data = new FormData();
        data.append('annonce', this.annonce.id);
        data.append('montant', this.annonce.price);
        data.append('locataire', this.useremail);
        data.append('idDemande', this.demande.id);
        const request = await fetch(`${import.meta.env.VITE_API_URL}/paiements`, {
            method: 'POST',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
            body: data
        });

        let res2 = await request.json();
        console.log(res2);

        const req = await fetch(`${import.meta.env.VITE_API_URL}/demandes/${this.demande.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                isPaid: true
            })
        });

        let resp2 = await req.json();
        console.log(resp2);
    }
}
</script>

<style scoped>

</style>
