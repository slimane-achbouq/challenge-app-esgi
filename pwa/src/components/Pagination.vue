<template>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <nav class="mb-4 sm:mb-0 sm:order-1" role="navigation" aria-label="Navigation">
            <ul class="flex justify-center">
                <li class="ml-3 first:ml-0">
                    <span>{{page}}</span>
                    <button v-if="page == 1" class="btn bg-white border-slate-200 text-slate-300 cursor-not-allowed" disabled
                            @click="$emit('decreasePage', 1)">&lt;- Previous
                    </button>
                    <button v-else class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500"
                            @click="$emit('decreasePage', 1)">&lt;- Previous
                    </button>
                </li>
                <li class="ml-3 first:ml-0">
                    <button class="btn bg-white border-slate-200 hover:border-slate-300 text-indigo-500"
                            @click="$emit('increasePage', 1)">Next -&gt;
                    </button>
                </li>
            </ul>
        </nav>
        <div class="text-sm text-slate-500 text-center sm:text-left">
            Showing <span class="font-medium text-slate-600">1</span> to <span
            class="font-medium text-slate-600">10</span> of <span class="font-medium text-slate-600">467</span> results
        </div>
    </div>
</template>

<script>
import {inject} from "vue";

export default {
    name: 'Pagination',
    data() {
        return {
            page: 1,
        }
    },
    updated() {
        this.page = inject('pageChange')
    }
}
</script>
