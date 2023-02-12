<template></template>
<script>
export default {
    data(){
        const vuex = localStorage.getItem('vuex');
        const data = JSON.parse(vuex);
        const token = data.auth.token;
        if(token){
            localStorage.clear();
        const redirectUrl = '/' + (this.$route.query.redirect || 'login');
        this.$router.replace(redirectUrl);
        }
        
    }
}
</script>