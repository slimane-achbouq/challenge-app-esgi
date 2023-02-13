import { createApp } from 'vue'
import App from './App.vue'
import router from './router/router'
import store from '@/store/index.js'

import './css/style.css'

const app = createApp(App)


const token1 = store.state.auth.token
const routes = ["/login","/register","/dashboard/users","/userannounces/myannouncement","/announces/new","/dashboard","/dashboard/announces","/dashboard/announces","/dashboard/announces","dashboard/requests","dashboard/disputes","/pagnotfound","/organisme","/announces/","/account-verification/","/reset-password","/demandes","/requests","/disputes","/userprofile","/userannounces","/signout"]

router.beforeEach((to,from)=>{
    if (to.fullPath!="/signout"){
        return
    }
    let token = token1 
    token =store.state.auth.token
    if (!token){
        if (to.fullPath!="/login") router.push('login')
    }

    else {

        console.log("3")
        if (!routes.some(element => to.fullPath.startsWith(element))){
            router.push('/pagnotfound')
            return;
        
        }
        const role = store.state.auth.roles[0]


        if (to.fullPath=="/login" || to.fullPath=="/register" ) router.push('dashboard')

        if(to.fullPath=="/dashboard/users" && role!="ROLE_ADMIN") router.push('dashboard')

        else if ((to.fullPath=="/userannounces/myannouncement" || to.fullPath=="/announces/new") && role=="ROLE_ADMIN"){
            router.push('dashboard')
        }
        
    }
    return true
})

app.use(router);

app.use(store);

app.mount('#app');
