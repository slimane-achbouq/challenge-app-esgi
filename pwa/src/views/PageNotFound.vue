<template>
    <div class="flex h-screen overflow-hidden">
  
  
      <!-- Content area -->
      <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-white">
        
  
        <main>
          <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
  
            <div class="max-w-2xl m-auto mt-16">
  
              <div class="text-center px-4">
                <div class="inline-flex mb-8">
                  <img src="https://www.seekpng.com/png/detail/825-8254341_404-error-not-found.png" width="176" height="176" alt="404 illustration" />
                </div>
                <div class="mb-6">Hmm...this page doesn’t exist. Try searching for something else!</div>
              </div>
  
            </div>
  
          </div>        
        </main>
  
      </div> 
  
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import Sidebar from '@/partials/Sidebar.vue'
  import Header from '@/partials/Header.vue'
  
  export default {
    name: 'PageNotFound',
    components: {
      Sidebar,
      Header,
    },
    setup() {
  
      const sidebarOpen = ref(false)
  
      return {
        sidebarOpen,
      }  
    }
  }
  </script>