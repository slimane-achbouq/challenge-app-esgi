<template>
    <main class="bg-white">
  
      <div class="relative flex">
  
        <!-- Content -->
        <div class="w-full md:w-1/2">
          <div class="min-h-screen h-full flex flex-col after:flex-1">
  
            <div class="flex-0">
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
              <h1 class="text-3xl text-slate-800 font-bold mb-6">Contact Us</h1>
              <Banner type="error" :open="!!error">
                {{ error }}
              </Banner>
              <!-- Form -->
              <form @submit.prevent="submitForm">
                <div class="space-y-4">
                    <div>
                        <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="name"
                        >Name: <span class="text-rose-500">*</span></label
                        >
                        <input
                        id="name"
                        class="form-input w-full"
                        type="text"
                        v-model.trim="name"
                        required
                        />
                        <div v-if="errors.name" class="text-xs mt-1 text-rose-500">
                        {{ errors.name }}
                        </div>
                    </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1" for="familyName"
                    >Family Name: <span class="text-rose-500">*</span></label
                    >
                    <input
                    id="familyName"
                    class="form-input w-full"
                    type="text"
                    v-model.trim="familyName"
                    required
                    />
                    <div v-if="errors.familyName" class="text-xs mt-1 text-rose-500">
                    {{ errors.familyName }}
                    </div>
                </div>
                </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email Address: <span class="text-rose-500">*</span></label>
                        <input id="email" class="form-input w-full" type="email" required v-model.trim="email" />
                    </div>
                    <div>
                    <label class="block text-sm font-medium mb-1" for="message"
                    >Your message: <span class="text-rose-500">*</span></label>                  
                     <textarea id="message" rows="4" class="form-input w-full" placeholder="Write your thoughts here..." required v-model.trim="message"></textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                  <button v-if="isLoading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed shadow-none" disabled>
                    <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                      <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
                    </svg>
                    <span class="ml-2">Loading</span>
                  </button>
                  <button v-else class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3" type="submit" >Send</button>
                </div>
              </form>
            </div>
  
          </div>
        </div>
  
        <!-- Image -->
        <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
          <img class="object-cover object-center w-full h-full" src="../images/contactUs.png" width="500" height="1024" alt="Authentication" />
          <!-- <img class="absolute top-1/4 left-0 -translate-x-1/2 ml-8 hidden lg:block" src="../images/auth-decoration.png" width="218" height="224" alt="Authentication decoration" /> -->
        </div>
  
      </div>
  
    </main>
  </template>
  
  <script>
  import { emailValidation } from "@/utils/utils-common-function";
  import Banner from '@/components/Banner.vue'
  
  export default {
      components: {
        Banner
      },
      data() {
          return {
              email: '',
              name: '',
              familyName: '',
              message: '',
              formIsValid: true,
              isLoading: false,
              error: null,
              errors: {
                name: "",
                familyName: "",
                email: "",
                message: "",
             },
          }
      },
      methods: {
          async submitForm() {
              this.formIsValid = true;
              this.error = null;
              this.isLoading = true;

              if (!emailValidation(this.email)) {
                this.formValid = false;
                this.errors.email = "Veuillez revérifier votre email s'il est valide";
                return;
              }
              if (this.name.length < 2) {
                this.formValid = false;
                this.errors.name = "Veuillez revérifier votre nom";
                return;
                }
                if (this.familyName.length < 2) {
                this.formValid = false;
                this.errors.familyName = "Veuillez revérifier votre prénom";
                return;
            
            }
              const actionPayload = {
                  name: this.name,
                  familyName: this.familyName,
                  email: this.email,
                  message: this.message
              };

              console.log(actionPayload);
  
              try {
                  // await this.$store.dispatch('contact', actionPayload);
              } catch (error) {
                  this.error = error.message || 'Failed to authenticated, try later.';
              }
  
              this.isLoading = false;
          }
      }
  }
  </script>
  