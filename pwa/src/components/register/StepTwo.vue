<template>
  <div class="space-y-4 mb-8">
    <!-- Nom de l'association Code -->
    <div v-if="state == 'association'">
      <label class="block text-sm font-medium mb-1" for="associationName"
        >Association name: <span class="text-rose-500">*</span></label
      >
      <input
        id="associationName"
        class="form-input w-full"
        type="text"
        v-model.trim="associationName"
        required
      />
    </div>
    <div v-if="errors.associationName" class="text-xs mt-1 text-rose-500">
      {{ errors.associationName }}
    </div>

    <!-- Profession Comercial Name Code -->
    <div
      class="flex space-x-4"
      v-if="state == 'company' || state == 'self-employed/independent'"
    >
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="profession"
          >Profession: <span class="text-rose-500">*</span></label
        >
        <input
          id="profession"
          class="form-input w-full"
          type="text"
          v-model.trim="profession"
          required
        />
        <div v-if="errors.profession" class="text-xs mt-1 text-rose-500">
          {{ errors.profession }}
        </div>
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="comercialName"
          >Commercial name: <span class="text-rose-500">*</span></label
        >
        <input
          id="comercialName"
          class="form-input w-full"
          type="text"
          v-model.trim="comercialName"
          required
        />
        <div v-if="errors.comercialName" class="text-xs mt-1 text-rose-500">
          {{ errors.comercialName }}
        </div>
      </div>
    </div>

    <!-- Name and FamilyName Code -->
    <div class="flex space-x-4" v-if="state == 'individual'">
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="name"
          >Name: <span class="text-rose-500">*</span></label
        >
        <input
          id="name"
          class="form-input w-full"
          type="text"
          v-model.trim="name"
          required
        />
        <div v-if="errors.name" class="text-xs mt-1 text-rose-500">
          {{ errors.name }}
        </div>
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="familyName"
          >Family Name: <span class="text-rose-500">*</span></label
        >
        <input
          id="familyName"
          class="form-input w-full"
          type="text"
          v-model.trim="familyName"
          required
        />
        <div v-if="errors.familyName" class="text-xs mt-1 text-rose-500">
          {{ errors.familyName }}
        </div>
      </div>
    </div>

    <!-- Street Address -->
    <div>
      <label class="block text-sm font-medium mb-1" for="street"
        >Street Address: <span class="text-rose-500">*</span></label
      >
      <input
        autoComplete='none'
        id="street"
        class="form-input w-full"
        type="text"
        v-model.trim="street"
        @input="searchStreet($event)"
      />
      <div class="" v-if="isAddressLoading">
          <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
              <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
          </svg>
      </div>
      <div v-else-if="searchedAddresses" v-for="searchedAddress in searchedAddresses" :key="searchedAddress.properties.id">
        <div class="text-gray-900 bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
          <button @click="setAddress(searchedAddress)" type="button" class="relative inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
              {{ searchedAddress.properties.label }}
          </button>
        </div>
      </div>

      <div v-if="errors.street" class="text-xs mt-1 text-rose-500">
        {{ errors.street }}
      </div>
    </div>

    <!-- City and Postal Code -->

    <div class="flex space-x-4">
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="city"
          >City: <span class="text-rose-500">*</span></label
        >
        <input
          id="disabled"
          class="form-input w-full disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
          type="text"
          :value="city"
          disabled
        />
      </div>
      <div class="flex-1">
        <label class="block text-sm font-medium mb-1" for="postalCode"
          >Postal Code: <span class="text-rose-500">*</span></label
        >
        <input
          id="disabled"
          class="form-input w-full disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed"
          type="text"
          :value="postalCode"
          disabled
        />
        <div v-if="errors.postalCode" class="text-xs mt-1 text-rose-500">
          {{ errors.postalCode }}
        </div>
      </div>
    </div>

    <!-- Phone number Code -->
    <div>
      <label class="block text-sm font-medium mb-1" for="phoneNumber"
        >Phone number: <span class="text-rose-500">*</span></label
      >
      <input
        id="phoneNumber"
        class="form-input w-full"
        type="tel"
        v-model.trim="phoneNumber"
        required
      />
      <div v-if="errorEmail" class="text-xs mt-1 text-rose-500">{{ e }}</div>
    </div>

    <!-- Email Code -->
    <div>
      <label class="block text-sm font-medium mb-1" for="email"
        >E-mail: <span class="text-rose-500">*</span></label
      >
      <input
        id="email"
        class="form-input w-full"
        type="text"
        v-model.trim="email"
        required
      />
      <div v-if="errors.email" class="text-xs mt-1 text-rose-500">
        {{ errors.email }}
      </div>
    </div>

    <!-- Password Code -->
    <div>
      <label class="block text-sm font-medium mb-1" for="password"
        >Password: <span class="text-rose-500">*</span></label
      >
      <input
        id="password"
        class="form-input w-full"
        type="password"
        v-model.trim="password"
        required
      />
    </div>
    <div v-if="errors.password" class="text-xs mt-1 text-rose-500">
      {{ errors.password }}
    </div>
    <p v-if="error">{{error}}</p>
    <div class="flex items-center justify-between">
        <a class="text-sm underline hover:no-underline"  @click="back()">&lt;- Back</a>
                <button v-if="isLoading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed shadow-none" disabled>
                      <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                        <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
                      </svg>
                      <span class="ml-2">Loading</span>
                </button>
                <button v-else class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-auto" @click="submitRegister">Register</button>
    </div>
  </div>
</template>

<script>
import {
  phoneValidation,
  passwordValidation,
  emailValidation,
} from "@/utils/utils-common-function";
import Banner from "@/components/Banner.vue";

export default {
  components: {
      Banner
  },
  data() {
    return {
      state: this.$store.state.register.situation.toLowerCase(),
      isAddressLoading: false,
      searchedAddresses: [],
      associationName: "",
      profession: "",
      comercialName: "",
      name: "",
      familyName: "",
      street: "",
      city: "",
      postalCode: "",
      phoneNumber: "",
      email: "",
      password: "",
      formValid: true,
      isLoading: false,
      error: null,
      errors: {
        associationName: "",
        profession: "",
        comercialName: "",
        name: "",
        familyName: "",
        street: "",
        city: "",
        postalCode: "",
        phoneNumber: "",
        email: "",
        password: "",
      },
    };
  },
  methods: {
    back() {
        this.$emit("back", {
              id: 1,
              label: 'Tell us what’s your situation ✨',
              selectedTab: 'StepOne'
          });
    },
    setAddress(address) {
      this.city = address.properties.city;
      this.postalCode = address.properties.postcode;
      this.street = address.properties.name;
      this.searchedAddresses = [];
    },
    async searchStreet (event) {
      this.isAddressLoading = true;
      try {
        const street = event.target.value;
        if (street.length <= 3) {
          return;
        }
        const response = await fetch(`https://localhost/address/` + new URLSearchParams(street));

        if (response.ok) {
            const data = await response.json();
            const parsedData = await JSON.parse(data);
            this.searchedAddresses = parsedData.features;
		    }
      } catch (error) {
        this.error = error.message || 'Failed to search for the given street';
      }
      this.isAddressLoading = false;
    },
    async submitRegister() {
      this.formValid = true;
      Object.keys(this.errors).forEach((key) => (this.errors[key] = ""));

      if (this.state == "individual") {
        if (this.name.length < 2) {
          this.formValid = false;
          this.errors.name = "Veuillez revérifier votre nom";
          return;
        }
        if (this.familyName.length < 2) {
          this.formValid = false;
          this.errors.familyName = "Veuillez revérifier votre prénom";
          return;
        }
      }

      if (this.state == "self-employed/independent") {
        if (this.profession.length < 2) {
          this.formValid = false;
          this.errors.profession = "Veuillez revérifier le nom de profession";
          return;
        }
      }

      if (this.state == "company") {
        if (this.comercialName.length < 2) {
          this.formValid = false;
          this.errors.comercialName = "Veuillez revérifier le nom d'enreprise";
          return;
        }
      }

      if (this.state == "association") {
        if (this.associationName.length < 2) {
          this.formValid = false;
          this.errors.associationName =
            "Veuillez revérifier le nom de l'association";
          return;
        }
      }

      if (this.city.length < 2) {
        this.formValid = false;
        this.errors.city = "Veuillez revérifier le nom de la city";
        return;
      }

      if (this.street.length < 2) {
        this.formValid = false;
        this.errors.street = "Veuillez revérifier votre adresse";
        return;
      }

      if (this.postalCode.length < 5) {
        this.formValid = false;
        this.errors.postalCode = "Veuillez revérifier votre code postale";
        return;
      }

      if (!passwordValidation(this.password)) {
        this.formValid = false;
        this.errors.password =
          "Veuillez revérifier le mot de passe s'il est valide";
        return;
      }

      if (!emailValidation(this.email)) {
        this.formValid = false;
        this.errors.email = "Veuillez revérifier votre email s'il est valide";
        return;
      }

      if (!phoneValidation(this.phoneNumber)) {
        this.formValid = false;
        this.error =
          "Veuillez revérifier votre numéro de téléphone s'il est valide";
        return;
      }

      this.dataPayload = {
        role: this.$store.state.register.situation.toLowerCase(),
        associationName: this.associationName,
        profession: this.profession,
        comercialName: this.comercialName,
        firstName: this.name,
        lastName: this.familyName,
        street: this.street,
        city: this.city,
        postalCode: this.postalCode,
        phoneNumber: this.phoneNumber,
        email: this.email,
        password: this.password,
      };
      this.isLoading = true;

      try {
                const response = await fetch(`${import.meta.env.VITE_API_URL}/users`, {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                    },
                    body: JSON.stringify(this.dataPayload)
                });

                if (response.ok) {
                    this.$emit('nextStep', {
                        id: 3,
                        label: '',
                        selectedTab: 'StepThreeSuccess'
                      })
		            } else {
                  let responseBody = await response.json();
                  this.error = responseBody['hydra:description'] || 'Failed to register try again later.';
                    this.$emit('nextStep', {
                        id: 3,
                        label: this.error,
                        selectedTab: 'StepThreeError'
                      })
                }
            } catch (error) {
              this.error = error.message || 'Failed to register try again later.';
                    this.$emit('nextStep', {
                        id: 3,
                        label: 'Error',
                        selectedTab: 'StepThreeError'
                      })
      }

      this.isLoading = false;
    },
  },
  components: {
    Banner,
  },
};
</script>
