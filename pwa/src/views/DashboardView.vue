<template>
    <div className="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>

        <!-- Content area -->
        <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>

            <main>
                <div className="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

                    <!-- Welcome banner -->
                    <WelcomeBanner/>

                    <!-- Dashboard actions -->
                    <div className="sm:flex sm:justify-between sm:items-center mb-8">
                        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

<!-- Sections -->
<div class="space-y-8">

  <!-- Popular Topics -->
  <div>
    <div class="mb-5">
      <h2 class="text-xl text-slate-800 font-bold">Popular Topics</h2>
    </div>
    <!-- Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 lg:sidebar-expanded:grid-cols-2 xl:sidebar-expanded:grid-cols-4 gap-6">

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon1-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                  <path d="M19.236 21.995h-3.333c-.46 0-.833.352-.833.786v9.428c0 .434.373.786.833.786h4.167V22.78c0-.434-.374-.786-.834-.786Z" fill="#4F46E5" opacity=".88" />
                  <path d="M34.234 20.073a2.393 2.393 0 0 0-.735-.116h-5v-2.609c0-3.325-2.157-4.297-3.298-4.347a.828.828 0 0 0-.611.24.888.888 0 0 0-.257.63v4.032L21 22.077v10.924h10.19c1.1.005 2.073-.744 2.392-1.842l2.308-7.826a2.711 2.711 0 0 0-.181-1.988 2.528 2.528 0 0 0-1.475-1.272Z" fill="url(#icon1-a)" transform="translate(-.93 -.005)" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Announces</h3>
            <div class="text-sm">Here you will find all the ads on our site.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/dashboard/announces">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5" v-if="role == 'Client'">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon4-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                  <path d="M34.327 18.194H10.12c-.495 0-.897.358-.897.798v14.404c0 .44.402.798.897.798h24.207c.495 0 .896-.357.896-.798V18.992c0-.44-.401-.798-.896-.798Z" fill="#4F46E5" opacity=".88" />
                  <path d="M29.09 0H4.883c-.494 0-.896.357-.896.798v14.404c0 .44.402.798.896.798H29.09c.495 0 .897-.357.897-.798V.798c0-.44-.402-.798-.897-.798Z" fill="url(#icon4-a)" transform="rotate(-8 126.748 -40.297)" />
                  <path d="M25.194 25.777a3 3 0 1 1-.835-5.942 3 3 0 0 1 .835 5.942Z" fill="#6366F1" opacity=".72" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">My announces</h3>
            <div class="text-sm">You will find here all your ads.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/userannounces/myannouncement">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5" v-if="role == 'Client'">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon3-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                  <circle fill="url(#icon3-a)" cx="30.5" cy="17.5" r="4.5" />
                  <circle fill="#4F46E5" opacity=".88" cx="17.5" cy="17.5" r="4.5" />
                  <circle fill="#4F46E5" opacity=".88" cx="30.5" cy="30.5" r="4.5" />
                  <circle fill="url(#icon3-a)" cx="17.5" cy="30.5" r="4.5" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Create Announce</h3>
            <div class="text-sm">Here you can create an ad.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/announces/new">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon2-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                  <path d="M26.5 19c4.695 0 8.5 3.184 8.5 7.111 0 1.597-.638 3.067-1.7 4.253V35l-4.108-2.148a10 10 0 0 1-2.692.37c-4.695 0-8.5-3.184-8.5-7.11C18 22.183 21.805 19 26.5 19Z" fill="#4F46E5" opacity=".88" />
                  <path d="M23 13c-5.523 0-10 3.582-10 8 0 1.797.75 3.45 2 4.785V31l4.833-2.416c.996.266 2.059.416 3.167.416 5.523 0 10-3.582 10-8s-4.477-8-10-8Z" fill="url(#icon2-a)" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Disputes</h3>
            <div class="text-sm">Here you can consult the list of disputes.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/dashboard/disputes">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5" v-if="role == 'Admin'">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 -6 25 40" xmlns="http://www.w3.org/2000/svg">
                <defs>

                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon5-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                    <path class="fill-current text-slate-400" :class=" 'text-indigo-500'" d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                    <path class="fill-current text-slate-200" :class=" 'text-indigo-300'" d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1" >Users</h3>
            <div class="text-sm">Here you can consult the list of users.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/dashboard/users">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="-4 -5 25 30" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon6-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                    <path class="fill-current text-slate-200" :class=" 'text-indigo-300'" d="M12.311 9.527c-1.161-.393-1.85-.825-2.143-1.175A3.991 3.991 0 0012 5V4c0-2.206-1.794-4-4-4S4 1.794 4 4v1c0 1.406.732 2.639 1.832 3.352-.292.35-.981.782-2.142 1.175A3.942 3.942 0 001 13.26V16h14v-2.74c0-1.69-1.081-3.19-2.689-3.733zM6 4c0-1.103.897-2 2-2s2 .897 2 2v1c0 1.103-.897 2-2 2s-2-.897-2-2V4zm7 10H3v-.74c0-.831.534-1.569 1.33-1.838 1.845-.624 3-1.436 3.452-2.422h.436c.452.986 1.607 1.798 3.453 2.422A1.943 1.943 0 0113 13.26V14z"/>
                 </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">My profile</h3>
            <div class="text-sm">Here you can access your profile information.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" :to="{ name: 'user-profile', params: { id: user.id }}">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

      <!-- Item -->
      <div class="bg-slate-100 rounded-sm text-center p-5" v-if="role == 'Client'">
        <div class="flex flex-col h-full">
          <div class="grow mb-2">
            <!-- Icon -->
            <div class="inline-flex w-12 h-12 rounded-full bg-indigo-400">
              <svg class="w-12 h-12" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="icon8-a">
                    <stop stop-color="#FFF" offset="0%" />
                    <stop stop-color="#A5B4FC" offset="100%" />
                  </linearGradient>
                </defs>
                <g fill-rule="nonzero" fill="none">
                  <path d="M18.648 35.069c.232.217.46.322.798.31.337-.012.558-.132.775-.365l1.95-2.094c1.028.414 2.504.813 4.076.758 1.798-.063 3.688-.692 5.426-2.441 3.686-3.956 4.05-12.862 4.038-13.199-.012-.337-.136-.67-.368-.888-.233-.217-.574-.317-.91-.306-.338.012-9.405 1.23-12.875 4.953-2.168 2.327-2.41 5.037-1.883 7.27l6.61-3.946-7.804 8.378a1.206 1.206 0 0 0 .167 1.57Z" fill="#554FE8" />
                  <path d="M.353 17.663c.225.224.45.337.787.337s.562-.113.786-.337l2.024-2.026c1.011.45 2.473.9 4.046.9 1.799 0 3.71-.562 5.508-2.25C17.326 10.462 18 1.575 18 1.237c0-.337-.112-.675-.337-.9C17.438.113 17.1 0 16.763 0c-.337 0-9.441.9-13.038 4.5-2.248 2.25-2.585 4.95-2.136 7.2l6.744-3.712-8.093 8.1a1.206 1.206 0 0 0 .113 1.575Z" fill="url(#icon8-a)" transform="rotate(13 -42.427 83.827)" />
                </g>
              </svg>
            </div>
            <!-- Content -->
            <h3 class="text-lg font-semibold text-slate-800 mb-1">Contact Us</h3>
            <div class="text-sm">Here you can contact us.</div>
          </div>
          <!-- Link -->
          <div>
            <router-link class="text-sm font-medium text-indigo-500 hover:text-indigo-600" to="/contact">Explore -&gt;</router-link>
          </div>
        </div>
      </div>

          </div>
        </div>
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
import WelcomeBanner from '@/partials/dashboard/WelcomeBanner.vue'
import DashboardAvatars from '@/partials/dashboard/DashboardAvatars.vue'
import FilterButton from '@/components/DropdownFilter.vue'
import Datepicker from '@/components/Datepicker.vue'

export default {
    name: 'Dashboard',
    components: {
        Sidebar,
        Header,
        WelcomeBanner,
        DashboardAvatars,
        FilterButton,
        Datepicker,
    },
    data() {
      this.role = this.$store.getters["auth/role"]
      this.isAuth = this.$store.getters["auth/isAuthenticated"];
    return {
      role:null,
      user:{id:1},
      isAuth: null
      }
    },
    mounted (){
      (function(d, m){
          var kommunicateSettings = {"appId":"3a909ff33ce0deab616101d01dac149ea","popupWidget":true,"automaticChatOpenOnNavigation":true};
          var s = document.createElement("script"); s.type = "text/javascript"; s.async = true;
          s.src = "https://widget.kommunicate.io/v2/kommunicate.app";
          var h = document.getElementsByTagName("head")[0]; h.appendChild(s);
          window.kommunicate = m; m._globals = kommunicateSettings;
    })(document, window.kommunicate || {});
    console.log(document.getElementById('mck-sidebox-ft'));
      },
    setup() {

        const sidebarOpen = ref(false)

        return {
            sidebarOpen,
            isAuth: null,
            role:null,
        }
    },
    async created() {
      this.isAuth = this.$store.getters["auth/isAuthenticated"];
      const response = await fetch(`${import.meta.env.VITE_API_URL}/users?email=${this.$store.getters["auth/email"]}`, {
          method: 'GET',
          headers: {
              // 'Content-Type': 'multipart/form-data',
              'Authorization': `Bearer ${this.$store.getters["auth/token"]}`
          },
      });

      let data = await response.json();
      if(data["hydra:member"]){
        this.user = await data["hydra:member"][0];
      }
  }
}
</script>
