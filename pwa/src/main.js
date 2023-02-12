import { createApp } from 'vue'
import App from './App.vue'
import router from './router/router'
import store from '@/store/index.js'

import './css/style.css'

const app = createApp(App)


const token = store.state.auth.token
const routes = ["/login","/register","/dashboard/users","/userannounces/myannouncement","/announces/new","/dashboard","/dashboard/announces","/dashboard/announces","/dashboard/announces","dashboard/requests","dashboard/disputes","/pagnotfound"]

router.beforeEach((to,from)=>{

    if (!routes.includes(to.fullPath)){
        console.log("404")
        router.push('/pagnotfound')}

    console.log(store.state.auth.roles[0])
    if (!token){
        if (to.fullPath!="/login") router.push('login')
    }

    else {
        const role = store.state.auth.roles[0]


        if (to.fullPath=="/login" || to.fullPath=="/register" ) router.push('dashboard')

        if(to.fullPath=="/dashboard/users" && role!="ROLE_ADMIN") router.push('dashboard')

        else if ((to.fullPath=="/userannounces/myannouncement" || to.fullPath=="/announces/new") && role=="ROLE_ADMIN"){
            router.push('dashboard')
        }
        
    }
    console.log(store.state.auth)
    console.log(to)
    console.log(from)
    return true
})

app.use(router);

app.use(store);

app.mount('#app');
