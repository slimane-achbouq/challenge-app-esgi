<template>
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
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
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
                  <div class="font-semibold text-left">Nombre d'objet</div>
                </th>
                <th class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
                  <div class="font-semibold">Nbr location</div>
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
  </template>
  
<script>
  import { ref, watch,onMounted } from 'vue'
  import Customer from './UsersTableItem.vue'
  import { useStore } from 'vuex';
  import { mapGetters } from 'vuex';
  import axios from 'axios'
  
  
  
  export default {
    name: 'UsersTable',
    components: {
      Customer,
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
        const response = await axios.get(`${import.meta.env.VITE_API_URL}/users`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        customers.value = response.data["hydra:member"];
      } catch (error) {
        console.error(error)
      }
    }

  
      
    onMounted(fetchUsers)
      
  
      return {
        selectAll,
        selected,
        checkAll,
        customers,
        onEdit
      }
    }
  }
  </script>