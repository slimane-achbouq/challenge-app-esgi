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


    <div class="bg-white shadow-lg rounded-sm border border-slate-200 relative">
      <header class="px-5 py-4">
        <h2 class="font-semibold text-slate-800">All Users <span class="text-slate-400 font-medium">248</span></h2>
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
  import Pagination from '../../../components/Pagination.vue'
  
  
  
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
      const perPage = ref(2)
      const page = ref(1)
      const searchTerm = ref([])
  
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
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/users?page=${page.value}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        customers.value = response.data["hydra:member"];
        customersList.value=customers.value
        totalResult.value=response.data["hydra:totalItems"];
        lastPage.value=response.data["hydra:view"]["hydra:last"].split("page=")[1];;
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
        customersList
      }
    }

    
  }
  </script>