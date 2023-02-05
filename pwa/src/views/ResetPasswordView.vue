<template>
    <main class="bg-white">
  
      <div class="relative flex" v-if="!isSuccess">
  
        <!-- Content -->
        <div class="w-full md:w-1/2">
          <div class="min-h-screen h-full flex flex-col after:flex-1">
  
            <div class="flex-1">
              <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                <!-- Logo -->
                <router-link class="block" to="/">
                  <svg width="32" height="32" viewBox="0 0 32 32">
                    <defs>
                      <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                        <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                        <stop stop-color="#A5B4FC" offset="100%" />
                      </linearGradient>
                      <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                        <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                        <stop stop-color="#38BDF8" offset="100%" />
                      </linearGradient>
                    </defs>
                    <rect fill="#6366F1" width="32" height="32" rx="16" />
                    <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
                    <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
                    <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
                  </svg>
                </router-link>
              </div>
            </div>          
  
            <div class="max-w-sm mx-auto px-4 py-8">
              <h1 class="text-3xl text-slate-800 font-bold mb-6">Reset your Password ✨</h1>
                <Banner type="error" :open="!!error">
                    {{ error }}
                </Banner>
              <!-- Form -->
              <form @submit.prevent="sendMail">
                <div class="space-y-4">
                  <div>
                    <label class="block text-sm font-medium mb-1" for="email">Email Address: <span class="text-rose-500">*</span></label>
                    <input id="email" class="form-input w-full" type="email" v-model.trim="email"/>
                  </div>
                </div>
                <div class="flex justify-end mt-6">
                <button v-if="isLoading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed shadow-none" disabled>
                <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
                </svg>
                <span class="ml-2">Loading</span>
                </button>
                  <button v-else type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white whitespace-nowrap">Send Reset Link</button>
                </div>
              </form>
            </div>
  
          </div>
        </div>
  
        <!-- Image -->
        <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
          <img class="object-cover object-center w-full h-full" src="../images/reset-password-background.jpg" width="760" height="1024" alt="Authentication" />
        </div>
  
      </div>
      <div v-if="isSuccess">
          <successMessageView :message='successMesage'></successMessageView>
      </div>
  
    </main>
  </template>
  
<script>
import Banner from '@/components/Banner.vue';
import successMessageView from './successMessageView.vue';



export default {
  name: 'ResetPassword',
  data() {
      return {
          email: '',
          isLoading: false,
          error: null,
          isSuccess: false,
          successMesage: ''
      }
  },
  methods: {
      async sendMail() {
        this.isLoading = true;
        this.isSuccess = false;
        this.error = null;


          // TODO: we need to create function that validate if the email is valide, We imported from utils!

          try {
            await fetch('https://localhost/reset/password', {
                headers: {
                    'Content-Type': 'application/json',
                },
                method: 'POST',
                body: JSON.stringify({
                    email: this.email,
                }),
            });

            this.isSuccess = true;
            this.successMesage = 'Veuillez vérifier votre boite mail.'

          } catch (ex) {
              this.error = new Error(ex || 'Failed to send email. Check you have already an compte.');
              throw error;
          }
      }
  }, 
  components: {
      Banner,
      successMessageView
  }
}
</script>