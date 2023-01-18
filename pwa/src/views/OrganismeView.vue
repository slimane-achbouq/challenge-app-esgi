<template>
        <!-- Content -->
        <div class="w-full md:w-1/2">
  
          <div class="min-h-screen h-full flex flex-col after:flex-1">
  
            <div class="flex-1">

<!-- Header -->
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
  <div class="text-sm">
    Have an account? <router-link class="font-medium text-indigo-500 hover:text-indigo-600" to="/login">Sign In</router-link>
  </div>
</div>

<!-- Progress bar -->
<div class="px-4 pt-12 pb-8">
  <div class="max-w-md mx-auto w-full">
    <div class="relative">
      <div class="absolute left-0 top-1/2 -mt-px w-full h-0.5 bg-slate-200" aria-hidden="true"></div>
      <ul class="relative flex justify-between w-full">
        <li>
          <a class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold bg-indigo-500 text-white">1</a>
        </li>
        <li>
          <a class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold bg-indigo-500 text-white">2</a>
        </li>
        <li>
          <a class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">3</a>
        </li>
      </ul>
    </div>
  </div>
</div>
</div>
  
            <div class="px-4 py-8">
              <div class="max-w-md mx-auto">
                <h1 class="text-3xl text-slate-800 font-bold mb-6">Information</h1>
                <!-- Form -->
                <form @submit.prevent="submitForm">
                  <div class="space-y-4 mb-8">
                    <!-- Nom de l'association Code -->
                    <div v-if="state == 'Association'">
                        <label class="block text-sm font-medium mb-1" for="associationName">Association name: <span class="text-rose-500">*</span></label>
                        <input id="associationName" class="form-input w-full" type="text" v-model.trim="associationName" required/>
                    </div>

                    <!-- Profession Comercial Name Code -->
                    <div class="flex space-x-4" v-if="state == 'Company' || state == 'SelfEmployed'">
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="profession">Profession: <span class="text-rose-500">*</span></label>
                        <input id="profession" class="form-input w-full" type="text" v-model.trim="profession" required/>
                      </div>
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="comercialName">Commercial name: <span class="text-rose-500">*</span></label>
                        <input id="comercialName" class="form-input w-full" type="text" v-model.trim="comercialName" required/>
                      </div>
                    </div>

                    <!-- Name and FamilyName Code -->
                    <div class="flex space-x-4" v-if="state == 'Particular'">
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="name">Name:  <span class="text-rose-500">*</span></label>
                        <input id="name" class="form-input w-full" type="text" v-model.trim="name" required/>
                      </div>
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="familyName">Family Name: <span class="text-rose-500">*</span></label>
                        <input id="familyName" class="form-input w-full" type="text" v-model.trim="familyName" required/>
                      </div>
                    </div>

                    <!-- Street Address -->
                    <div>
                      <label class="block text-sm font-medium mb-1" for="street">Street Address: <span class="text-rose-500">*</span></label>
                      <input id="street" class="form-input w-full" type="text" v-model.trim="street" required/>
                    </div>

                    <!-- City and Postal Code -->
                    <div class="flex space-x-4">
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="city">City: <span class="text-rose-500">*</span></label>
                        <input id="city" class="form-input w-full" type="text" v-model.trim="city" required/>
                      </div>
                      <div class="flex-1">
                        <label class="block text-sm font-medium mb-1" for="postalCode">Postal Code: <span class="text-rose-500">*</span></label>
                        <input id="postalCode" class="form-input w-full" type="text" v-model.trim="postalCode" required/>
                      </div>
                    </div>

                    <!-- Phone number Code -->
                    <div>
                      <label class="block text-sm font-medium mb-1" for="phoneNumber">Phone number: <span class="text-rose-500">*</span></label>
                      <input id="phoneNumber" class="form-input w-full" type="tel" v-model.trim="phoneNumber" required/>
                    </div>

                    <!-- Email Code -->
                    <div>
                      <label class="block text-sm font-medium mb-1" for="email">E-mail: <span class="text-rose-500">*</span></label>
                      <input id="email" class="form-input w-full" type="text" v-model.trim="email" required/>
                    </div>

                    <!-- Password Code -->
                    <div>
                      <label class="block text-sm font-medium mb-1" for="password">Password: <span class="text-rose-500">*</span></label>
                      <input id="password" class="form-input w-full" type="password" v-model.trim="password" required/>
                    </div>
                  </div>
                  <div class="flex items-center justify-between">
                    <a class="text-sm underline hover:no-underline"  @click="back()">&lt;- Back</a>
                    <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-auto" type="submit">Next Step -&gt;</button>
                  </div>
                </form>
  
              </div>
            </div>
  
          </div>
  
        </div>
  
        <!-- Image -->
        <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
            <img class="object-cover object-center w-full h-full" src="../images/registerBackGound.jpg" width="760" height="1024" alt="Onboarding" />
        </div>
  </template>
  
  <script>
  import { phoneValidation, passwordValidation, emailValidation } from '../utils/utils-common-function'

  
  export default {
    props: ['state'],
    data(){
      return {
        associationName: '',
        profession: '',
        comercialName: '',
        name: '',
        familyName: '',
        street: '',
        city: '',
        postalCode: '',
        phoneNumber: '',
        email: '',
        password: '',
      }
    },
    methods: {
      back() {
        this.$emit('back', '');
      },
      toggleErrors() {
        if (Object.keys(this.formErrors).length === 0) {
          this.formErrors = this.errors;
        } else {
          this.formErrors = {};
        }
      },
      async submitForm() {
      }
    }
  }
  </script>