<template>
  <div class="space-y-3 mb-8">
    <label
      v-for="situation in situations"
      :key="situation.id"
      class="relative block cursor-pointer"
    >
      <input
        type="radio"
        @change="setSelectedSituation($event)"
        :value="situation.label"
        name="radio-buttons"
        class="peer sr-only"
        :checked="this.$store.state.register.situation.toLowerCase() == situation.id"
      />
      <div
        class="flex items-center bg-white text-sm font-medium text-slate-800 p-4 rounded border border-slate-200 hover:border-slate-300 shadow-sm duration-150 ease-in-out"
      >
        <svg class="w-6 h-6 shrink-0 fill-current mr-4" viewBox="0 0 24 24">
          <path
            class="text-indigo-500"
            d="m12 10.856 9-5-8.514-4.73a1 1 0 0 0-.972 0L3 5.856l9 5Z"
          />
          <path
            class="text-indigo-300"
            d="m11 12.588-9-5V18a1 1 0 0 0 .514.874L11 23.588v-11Z"
          />
          <path
            class="text-indigo-200"
            d="M13 12.588v11l8.486-4.714A1 1 0 0 0 22 18V7.589l-9 4.999Z"
          />
        </svg>
        <span>{{ situation.label }}</span>
      </div>
      <div
        class="absolute inset-0 border-2 border-transparent peer-checked:border-indigo-400 rounded pointer-events-none"
        aria-hidden="true"
      ></div>
    </label>
    <div class="flex items-center justify-between">
        <button
            class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-auto"
            @click="nextStep()"
        >Next Step -&gt;</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      situations: [
        {
          id: "individual",
          label: "Individual",
        },
        {
          id: "self-employed/independent",
          label: "Self-employed/independent",
        },
        {
          id: "company",
          label: "Company",
        },
        {
          id: "association",
          label: "Association",
        },
      ],
    };
  },
  methods: {
    setSelectedSituation(event) {
      let selectedSituation = event.target.value;
      this.$store.dispatch("register/setSituation", selectedSituation);
    },
    nextStep() {
        this.$emit("nextStep", {
                id: 2,
                label: 'Information',
                selectedTab: 'StepTwo'
        });
    }
  },
};
</script>
