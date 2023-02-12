<template>

  <div>

    <!-- Search form -->
    <div class="max-w-xl mb-5">
                    <form class="relative"      >
                    <label for="app-search" class="sr-only" >Search</label>
                    <input id="app-search" class="form-input w-full pl-9 py-3 focus:border-slate-300" type="search" placeholder="Search…" v-model="searchTerm" @input="searchCustomers"/>
                    <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
                        <svg class="w-4 h-4 shrink-0 fill-current text-slate-400 group-hover:text-slate-500 ml-3 mr-2" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                        <path d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
                        </svg>
                    </button>
                    </form>
    </div>

    <div role="status" v-if="loading">
                <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
    </div>


    <div class="bg-white shadow-lg rounded-sm border border-slate-200 relative">
      <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Users <span class="text-slate-400 font-medium"></span></h2>
      </header>
      <div>
  
        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="table-auto w-full">
            <!-- Table header -->
            <thead class="text-xs font-semibold uppercase text-slate-500 bg-slate-50 border-t border-b border-slate-200">
              <tr>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
                  <div class="flex items-center">
                    <label class="inline-flex">
                      <span class="sr-only">Select all</span>
                      <input class="form-checkbox" type="checkbox" v-model="selectAll" @click="checkAll" />
                    </label>
                  </div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap ">
                  <div class="font-semibold text-left">Nom</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold text-left">Email</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold text-left">Location</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold">Mobile</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold text-left">Status</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold text-left">profession</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold">Nassociation Name</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <span class="sr-only">Menu</span>
                </th>
              </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-sm divide-y divide-slate-200">

              
              <Customer
                v-for="customer in customers"
                :key="customer.id"
                :customer="customer"
                v-model:selected="selected"
                :value="customer.id"
                @edit="onEdit"
              />
            </tbody>
          </table>
  
        </div>
        
      </div>

      
    </div>

    <div class="mt-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
            <ul class="flex justify-center">
              <li class="ml-3 first:ml-0">
                <a class="btn bg-white border-slate-200 " :class="{ 'text-slate-300 cursor-not-allowed': page === 1,'hover:border-slate-300 text-indigo-500': page != 1}"  @click.prevent="prevPage">&lt;- Previous</a>
              </li>
              <li class="ml-3 first:ml-0">
                <a class="btn bg-white border-slate-200 " :class="{ 'text-slate-300 cursor-not-allowed': page >= lastPage,'hover:border-slate-300 text-indigo-500': page < lastPage}"  @click.prevent="nextPage">Next -&gt;</a>
              </li>
            </ul>
          </nav>
          <div class="text-sm text-slate-500 text-center sm:text-left">
            Showing <span class="font-medium text-slate-600">{{ page }}</span> to <span class="font-medium text-slate-600">{{lastPage}}</span> of <span class="font-medium text-slate-600">{{totalResult}}</span> results
          </div>
        </div>
    </div>

  </div>
  </template>
  
<script>
  import { ref, watch,onMounted } from 'vue'
  import Customer from './UsersTableItem.vue'
  import { useStore } from 'vuex';
  import { mapGetters } from 'vuex';
  import axios from 'axios'
  import Pagination from '@/components/Pagination.vue'
  
  
  
  export default {
    name: 'UsersTable',
    components: {
      Customer,
      Pagination
    },  
    props: ['selectedItems'],

    data() {
        return {
            users: [],
            
            
        }
    },

    methods:{

    },
    setup(props, { emit }) {

      const store = useStore();
      const  token = localStorage.getItem('esgi-ws-token')
    
      const selectAll = ref(false)
      const selected = ref([])
      const customers = ref([])
      const customersList = ref([])
      const totalResult = ref(0)
      const lastPage = ref(0)
      const perPage = ref(5)
      const page = ref(1)
      const searchTerm = ref([])
      const loading=ref(true)
  
      const checkAll = () => {
        selected.value = []
        if (!selectAll.value) {
          selected.value = customers.value.map(customer => customer.id)
        }
      }

      const onEdit =(user)=>{
        emit('edit', user)
      }
      
      watch(selected, () => {
        selectAll.value = customers.value.length === selected.value.length ? true : false
        emit('change-selection', selected.value)
      })    

      const fetchUsers = async() => {
      try {
        loading.value = true
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/users?page=${page.value}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        if(response.data["hydra:member"]){
          customers.value = await response.data["hydra:member"];
        }
        
        customersList.value= await customers.value
        totalResult.value=await response.data["hydra:totalItems"];
        console.log(response.data)
        if(response.data["hydra:view"]){
          lastPage.value=await response.data["hydra:view"]["hydra:last"].split("page=")[1];;
        }
        loading.value = false
      } catch (error) {
        console.error(error)
      }
    }

    const searchCustomers = async() =>  {

      customers.value=customersList.value
      customers.value=JSON.parse(JSON.stringify(customers.value)).filter(customer =>  customer.email.toLowerCase().includes(searchTerm.value.toLowerCase()))
      return customersV;
    }

    function nextPage() {
        if(page.value < lastPage.value){
          page.value++
          fetchUsers()
        } 
      }
    function prevPage() {
        if (page.value >0 ){
          page.value--
          fetchUsers()
        } 
    }

    

  
      
    onMounted(fetchUsers)
      
  
      return {
        selectAll,
        selected,
        checkAll,
        customers,
        onEdit,
        nextPage,
        prevPage,
        lastPage,
        page,
        totalResult,
        searchTerm,
        searchCustomers,
        customersList,
        loading
      }
    }

    
  }
  </script>