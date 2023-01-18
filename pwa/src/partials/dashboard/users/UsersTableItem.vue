<template>
    <tr>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
        <div class="flex items-center">
          <label class="inline-flex">
            <span class="sr-only">Select</span>
            <input :id="customer.id" class="form-checkbox" type="checkbox" :value="value" @change="check" :checked="checked" />
          </label>
        </div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="flex items-center">
          <div class="w-10 h-10 shrink-0 mr-2 sm:mr-3">
            <img class="rounded-full" :src="customer.image" width="40" height="40" :alt="customer.name" />
          </div>
          <div class="font-medium text-slate-800">{{customer.name}}</div>
        </div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-left">{{customer.email}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-left">{{customer.location}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-center">{{customer.mobile}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-center font-medium text-sky-500">{{customer.status}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-center font-medium text-emerald-500">{{customer.nbrObjets}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap">
        <div class="text-center">{{customer.nbLocation}}</div>
      </td>
      <td class="px-2 first:pl-5 last:pr-5 py-3 whitespace-nowrap w-px">
        <!-- Menu button -->
        <button class="text-slate-400 hover:text-slate-500 rounded-full">
          <span class="sr-only">Menu</span>
          <svg class="w-8 h-8 fill-current" viewBox="0 0 32 32">
            <circle cx="16" cy="16" r="2" />
            <circle cx="10" cy="16" r="2" />
            <circle cx="22" cy="16" r="2" />
          </svg>
        </button>
      </td>
    </tr>  
  </template>
  
  <script>
  import { computed } from 'vue'
  
  export default {
    name: 'UsersTableItem',
    props: ['customer', 'value', 'selected'],
    setup(props, context) {
        console.log(props.selected)
      const checked = computed(() => props.selected.includes(props.value))
  
      function check() {
        let updatedSelected = [...props.selected]
        if (this.checked) {
          updatedSelected.splice(updatedSelected.indexOf(props.value), 1)
        } else {
          updatedSelected.push(props.value)
        }
        context.emit('update:selected', updatedSelected)
      }
  
      return {
        check,
        checked,
      }
    },
  }
  </script>