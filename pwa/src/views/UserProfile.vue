<template>
    <div class="flex h-screen overflow-hidden">
  
      <!-- Sidebar -->
      <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />
  
      <!-- Content area -->
      <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-white">
        
        <!-- Site header -->
        <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
  
        <main>
        <div class="lg:relative lg:flex">

          <!-- Content -->
          <div class="px-4 sm:px-6 lg:px-8 py-8 lg:grow lg:pr-8 xl:pr-16 2xl:ml-[80px]">
            <div class="lg:mx-auto">

              <!-- Cart items -->
              <div class="mb-6 lg:mb-0">
                <header class="mb-6">
                  <!-- Title -->
                  <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2">User informations✨</h1>
                </header>
                <!-- Billing Information -->
                <div>
                  <div class="text-slate-800 font-semibold mb-4">Edit Information</div>
                  <form>
                    <div class="space-y-4">
                      <!-- 1st row -->
                      <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="firstname">First Name</label>
                          <input id="firstname" class="form-input w-full" type="text"  v-model="user.firstName" />
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="lastname">Last Name</label>
                          <input id="lastname" class="form-input w-full" type="text" v-model="user.lastName" />
                        </div>
                      </div>
                      <!-- 2nd row -->
                      <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="address">E-mail:</label>
                          <input id="address" class="form-input w-full" type="text" v-model="user.email"/>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-city">Phone Number</label>
                          <input id="card-city" class="form-input w-full"  v-model="user.phoneNumber" type="text" />
                        </div>
                      </div>
                      <!-- 3rd row -->
                      <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-country">Profession: <span class="text-rose-500">*</span></label>
                          <input id="card-state" class="form-input w-full" type="text" v-model="user.proffesion"/>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-state">Association name</label>
                          <input id="card-state" class="form-input w-full" type="text"  v-model="user.associationname"/>commercialname
                        </div>  
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-country">Commercial name: <span class="text-rose-500">*</span></label>
                          <input id="card-state" class="form-input w-full" type="text"  v-model="user.commercialname"/>
                        </div>
                      </div>
                      <!-- Divider -->
                      <hr class="my-2 border-t border-slate-200" />
                      <!-- 4th row -->
                      <div class="md:flex space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-vat">Street Address:</label>
                          <input id="card-vat" class="form-input w-full" type="text"  v-model="user.streetaddress"/>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-vat">City</label>
                          <input id="card-vat" class="form-input w-full" type="text"  v-model="user.city"/>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium mb-1" for="card-postcode">Postcode</label>
                          <input id="card-postcode" class="form-input w-full" type="text"  v-model="user.postcode"/>
                        </div>
                        
                      </div>
                      <div class="text-right">
                        <button type="submit" class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500">Edit</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- Divider -->
                <hr class="my-6 border-t border-slate-200" />
                
            
              </div>

            </div>
          </div>

        </div>
      </main>
  
      </div> 
  
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import Sidebar from '../partials/SidebarProfile.vue'
  import Header from '../partials/Header.vue'
  
  export default {
    name: 'UserProfile',
    components: {
      Sidebar,
      Header,
    }, 
    data() {
    return {
      user: {
        firstName: "",
        lastName: "",
        email: "",
        phoneNumber: "",
        streetaddress: "",
        postcode: "",
        city:"",
        associationname:"",
        commercialname:"",
        proffesion:""
      }
  }
  }
}
  </script>