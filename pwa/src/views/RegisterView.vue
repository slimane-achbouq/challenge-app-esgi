<template>
  <main class="bg-white">
    <div class="relative flex">
      <!-- Content -->
      <div class="w-full md:w-1/2">
        <div class="min-h-screen h-full flex flex-col after:flex-1">
          <div class="flex-1">
            <!-- Header -->
            <div
              class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8"
            >
              <!-- Logo -->
              <router-link class="block" to="/">
                <svg width="32" height="32" viewBox="0 0 32 32">
                  <defs>
                    <linearGradient
                      x1="28.538%"
                      y1="20.229%"
                      x2="100%"
                      y2="108.156%"
                      id="logo-a"
                    >
                      <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                      <stop stop-color="#A5B4FC" offset="100%" />
                    </linearGradient>
                    <linearGradient
                      x1="88.638%"
                      y1="29.267%"
                      x2="22.42%"
                      y2="100%"
                      id="logo-b"
                    >
                      <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                      <stop stop-color="#38BDF8" offset="100%" />
                    </linearGradient>
                  </defs>
                  <rect fill="#6366F1" width="32" height="32" rx="16" />
                  <path
                    d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z"
                    fill="#4F46E5"
                  />
                  <path
                    d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z"
                    fill="url(#logo-a)"
                  />
                  <path
                    d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z"
                    fill="url(#logo-b)"
                  />
                </svg>
              </router-link>
              <div class="text-sm">
                Have an account?
                <router-link
                  class="font-medium text-indigo-500 hover:text-indigo-600"
                  to="/signin"
                  >Sign In</router-link
                >
              </div>
            </div>

            <!-- Progress bar -->
            <div class="px-4 pt-12 pb-8">
              <div class="max-w-md mx-auto w-full">
                <div class="relative">
                  <div
                    class="absolute left-0 top-1/2 -mt-px w-full h-0.5 bg-slate-200"
                    aria-hidden="true"
                  ></div>
                  <ul class="relative flex justify-between w-full">
                    <li>
                      <router-link
                        class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold bg-indigo-500 text-white"
                        to="/onboarding-01"
                        >1</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold" :class="step.id >= 2 ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'"
                        to="/onboarding-02"
                        >2</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="flex items-center justify-center w-6 h-6 rounded-full text-xs font-semibold" :class="step.id >= 3 ? 'bg-indigo-500 text-white' : 'bg-slate-100 text-slate-500'"
                        to="/onboarding-03"
                        >3</router-link
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div class="px-4 py-8">
            <div class="max-w-md mx-auto">
              <h1 class="text-3xl text-slate-800 font-bold mb-6">
                {{ step.label }}
              </h1>
                <Banner type="error" :open="!!error">
                  {{ error }}
                </Banner>
              <!-- Form -->
              <form @submit.prevent>
                <component @back="back" @nextStep="nextStep" :is="step.selectedTab" ></component>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Image -->
      <div
        class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2"
        aria-hidden="true"
      >
        <img
          class="object-cover object-center w-full h-full"
          src="../images/registerBackGound.jpg"
          width="760"
          height="1024"
          alt="Onboarding"
        />
      </div>
    </div>
  </main>
</template>

<script>
import Banner from '@/components/Banner.vue';
import StepOne from '@/components/register/StepOne.vue';
import StepTwo from '@/components/register/StepTwo.vue';
import StepThreeSuccess from '@/components/register/StepThreeSuccess.vue';
import StepThreeError from '@/components/register/StepThreeError.vue';

export default {
    components: {
        StepOne,
        StepTwo,
        Banner,
        StepThreeSuccess,
        StepThreeError
    },
    data() {
        return {
          error: null,
          selectedSituation: null,  
          selectedTab: 'StepOne',
          steps: [
            {
                id: 1,
                label: 'Tell us what’s your situation ✨',
                selectedTab: 'StepOne'
            },
            {
                id: 2,
                label: 'Information',
                selectedTab: 'StepTwo'
            }
          ],
          step: {
              id: 1,
              label: 'Tell us what’s your situation ✨',
              selectedTab: 'StepOne'
          },
        }
    },
    methods: {
        back(object) {
          this.step = object;
        },
        nextStep(object) {
            this.error = null;
            try {
                if (this.step.id === 1) {
                    if (!this.$store.state.register.situation) {
                        throw new Error('You have to choose an organization');
                    } else {
                        this.step = object;
                    }
                } else {
                  this.step = object;
                }

            } catch (error) {
                this.error = error.message || 'There is an error !';
            }
        },
    }
  
};
</script>
