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
                <DeleteButton :selectedItems="selectedItems" />       
              </div>
  
            </div>
            
            <!-- Search form -->
            <div class="max-w-xl mb-5">
                    <form class="relative">
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
                            <label class="block text-sm font-medium mb-1" for="name">Nom <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full px-2 py-1" type="text" required :value="selectedItems.name"/>
                          </div>
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Prenom <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full px-2 py-1" type="text"  :value="selectedItems.name"/>
                          </div>
                         </div>

                         <div class="grid grid-cols-2 gap-4" >
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Code postal <span class="text-rose-500">*</span></label>
                            <input id="name" class="form-input w-full px-2 py-1" type="text" required :value="selectedItems.location"/>
                          </div>
                          <div class="col-span-1">
                            <label class="block text-sm font-medium mb-1" for="name">Status <span class="text-rose-500">*</span></label>
                            <select class="form-select">
                                <option>Active</option>
                                <option>Banned</option>
                            </select>
                          </div>
                         </div>

                          <div>
                            <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-rose-500">*</span></label>
                            <input id="email" class="form-input w-full px-2 py-1" type="email" required :value="selectedItems.email"/>
                          </div>
                        </div>
                      </div>
                      <!-- Modal footer -->
                      <div class="px-5 py-4 border-t border-slate-200">
                        <div class="flex flex-wrap justify-end space-x-2">
                          <button class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600" @click.stop="modalOpen=false">Cancel</button>
                          <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white">Edit</button>
                        </div>
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
  
      const updateSelectedItems = (selected) => {
        selectedItems.value = selected
      }
      
      function onOpenModal (selected){
        modalOpen.value=true
        selectedItems.value = selected
      }
  
      return {
        sidebarOpen,
        selectedItems,
        modalOpen,
        updateSelectedItems,
        onOpenModal
      }  
    }
  }
  </script>