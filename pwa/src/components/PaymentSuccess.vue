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
            <p v-if="annonce">
                Total amount :
                <span class="text-indigo-500" v-if="annonce.isPerHour">
                {{ pricePerHour }}€
            </span>
                <span class="text-indigo-500" v-else>
                {{ annonce.price }}€
            </span>
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
            id: null,
            pricePerHour: null
        }
    },
    methods: {},
    setup() {
        return {}
    },
    async created() {
        if (!this.$store.getters["auth/isAuthenticated"]) {
            this.$router.push('/');
        }
        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        this.id = id;
        let token = document.URL.split('/')[7];
        let userToken = this.$store.getters["auth/token"]


        this.userTokenCheck = userToken;
        this.token = token;
        this.role = this.$store.getters["auth/role"]
        this.useremail = this.$store.getters["auth/email"]

        const response = await fetch(`https://api.zaidalaahazim.fr/demandes/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let res = await response.json();
        this.demande = res;
        this.annonce = res.annonce;

        let date = new Date(res.dateStart);
        let date2 = new Date(res.dateEnd);

        if (res.annonce.isPerHour) {
            let diff = (date2.getTime() - date.getTime()) / 1000;
            diff /= (60 * 60);
            this.pricePerHour = Math.round(diff * this.annonce.price);
        }
        const data = new FormData();
        data.append('annonce', this.annonce.id);
        if (this.annonce.isPerHour) {
            data.append('montant', this.pricePerHour);
        } else {
            data.append('montant', this.annonce.price);
        }
        data.append('locataire', this.useremail);
        data.append('idDemande', this.demande.id);
        const request = await fetch(`https://api.zaidalaahazim.fr/paiements`, {
            method: 'POST',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
            body: data
        });

        let res2 = await request.json();

        const req = await fetch(`https://api.zaidalaahazim.fr/demandes/${this.demande.id}`, {
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
    }
}
</script>

<style scoped>

</style>
