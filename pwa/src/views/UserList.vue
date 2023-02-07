<template>
    <div class="flex h-screen overflow-hidden">
  
      <!-- Sidebar -->
      <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />
  
      <!-- Content area -->
      <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
        
        <!-- Site header -->
        <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
  
        <main>
            
          <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            

            
            <!-- Page header -->
            <div class="sm:flex sm:justify-between sm:items-center mb-8">
                
             
              <!-- Left: Title -->
              <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Users ✨</h1>
              </div>
              
              

              <!-- Right: Actions  -->
              <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
  
                <!-- Delete button -->
                <DeleteButton :selectedItems="selectedItems" @click="modaDeletelOpen=true"/>       
              </div>
  
            </div>
            
            <!-- Search form -->
            <div class="max-w-xl mb-5">
                    <form class="relative"      >
                    <label for="app-search" class="sr-only">Search</label>
                    <input id="app-search" class="form-input w-full pl-9 py-3 focus:border-slate-300" type="search" placeholder="Search…" />
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                    </form>
            </div>
            <!-- Table -->
            <CustomersTable @change-selection="updateSelectedItems($event)" @edit="onOpenModal"/>
            
            <ModalBasic id="feedback-modal" :modalOpen="modalOpen" @close-modal="onModalClose" title="Edit User">
                      <!-- Modal content -->
                      <div class="px-5 py-4">
                        <div class="space-y-3 ">

                         <div class="grid grid-cols-2 gap-4" >
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">First Name<span class="text-rose-500">*</span></label>
                            <input v-model="selectedItems.firstName" id="name" class="form-input w-full px-2 py-1" type="text" required />
                          </div>
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Last Name <span class="text-rose-500">*</span></label>
                            <input  v-model="selectedItems.lastName" id="name" class="form-input w-full px-2 py-1" type="text" />
                          </div>
                         </div>

                         <div class="grid grid-cols-2 gap-4" >
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Mobile <span class="text-rose-500">*</span></label>
                            <input v-model="selectedItems.phoneNumber" id="name" class="form-input w-full px-2 py-1" type="text" required />
                          </div>
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Status <span class="text-rose-500">*</span></label>
                            <select class="form-select" v-model="isVerifiedv">
                                <option value="true">Actived</option>
                                <option value="false">Not Actived</option>
                            </select>
                          </div>
                         </div>

                          <div>
                            <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-rose-500">*</span></label>
                            <input v-model="selectedItems.email" id="email" class="form-input w-full px-2 py-1" type="email" required />
                          </div>
                        </div>
                      </div>
                      <!-- Modal footer -->
                      <div class="px-5 py-4 border-t border-slate-200">
                        <div class="flex flex-wrap justify-end space-x-2">
                          <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click.stop="modalOpen=false">Cancel</button>
                          <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" @click="updateUser">Edit</button>
                        </div>
                      </div>
            </ModalBasic>


            <ModalBasic id="danger-modal" :modalOpen="modaDeletelOpen" >
                      <div class="p-5 flex w-full space-x-4">
                        <!-- Icon -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-rose-100">
                          <svg class="w-4 h-4 shrink-0 fill-current text-rose-500" viewBox="0 0 16 16">
                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 12c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm1-3H7V4h2v5z" />
                          </svg>
                        </div>
                        <!-- Content -->
                        <div>
                          <!-- Modal header -->
                          <div class="mb-2">
                            <div class="text-lg font-semibold text-slate-800">Delete 1 customer?</div>
                          </div>
                          <!-- Modal content -->
                          <div class="text-sm mb-10">
                            <div class="">
                              <p>Are you sure you want to delete user(s) ?</p>
                            </div>
                          </div>
                          <!-- Modal footer -->
                          
                        </div>

                        
                      </div>

                      <div class="flex flex-wrap justify-end space-x-2 m-6">
                            <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click.stop="modaDeletelOpen=false">Cancel</button>
                            <button class="btn-sm bg-rose-500 hover:bg-rose-600 text-white">Yes, Delete it</button>
                      </div>
                    </ModalBasic>


            <!-- Pagination -->
            <div class="mt-8">
                <Pagination />
            </div>          
  
          </div>
        </main>
  
      </div> 
  
    </div>
  </template>
  
<script>
  import { ref } from 'vue'
  import Sidebar from '../partials/Sidebar.vue'
  import Header from '../partials/Header.vue'
  import DeleteButton from '../components/DeleteButton.vue'
  import CustomersTable from '../partials/dashboard/users/UsersTable.vue'
  import Pagination from '../components/Pagination.vue'
  import ModalBasic from '../components/Modal.vue'
  import axios from 'axios'

  
  export default {
    name: 'UserList',
    components: {
      Sidebar,
      Header,
      CustomersTable,
      Pagination,
      DeleteButton,
      ModalBasic
    },
    setup() {
  
      const sidebarOpen = ref(false)
      const selectedItems = ref([])
      const modalOpen = ref(false)
      const modaDeletelOpen = ref(false)
      const isVerifiedv=ref(false)
  
      const updateSelectedItems = (selected) => {
        selectedItems.value = selected
      }
      
      function onOpenModal (selected){
        modalOpen.value=true
        selectedItems.value = selected
      }

      function updateUser(){
          
          // Get the form data from the inputs
          //const name = this.$refs.name.value
          //const prenom = this.$refs.prenom.value
          //const location = this.$refs.location.value
          //const status = this.$refs.status.value
          try {
          // Get the form data from the inputs
          
          console.log(isVerifiedv["_value"])
          const data = { 
            email: this.selectedItems.email,
            firstName: this.selectedItems.firstName,
            lastName: this.selectedItems.lastName,
            isVerified: isVerifiedv["_value"] ? true:false,
            phoneNumber: this.selectedItems.phoneNumber  }
          console.log(data)
          const response = axios.patch(`${import.meta.env.VITE_API_URL}/users/${this.selectedItems.id}`,  data , {
              headers: {
                  'Authorization': `Bearer ${localStorage.getItem('esgi-ws-token')}`
              }
          })
          modalOpen.value = false
          console.log(response)
          
      } catch (error) {
          console.error(error)
      }
          
      
  }

  
      return {
        sidebarOpen,
        selectedItems,
        modalOpen,
        updateSelectedItems,
        onOpenModal,
        modaDeletelOpen,
        updateUser,
        isVerifiedv
      }  
    }
  }
  </script>