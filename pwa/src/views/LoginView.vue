<template>
  <main class="bg-white">

    <div class="relative flex">

      <!-- Content -->
      <div class="w-full md:w-1/2">
        <div class="min-h-screen h-full flex flex-col after:flex-1">

          <div class="flex-1">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
              <!-- Logo -->
              <router-link class="block" to="/">
                <svg width="32" height="32" viewBox="0 0 32 32">
                  <defs>
                    <linearGradient x1="28.538%" y1="20.229%" x2="100%" y2="108.156%" id="logo-a">
                      <stop stop-color="#A5B4FC" stop-opacity="0" offset="0%" />
                      <stop stop-color="#A5B4FC" offset="100%" />
                    </linearGradient>
                    <linearGradient x1="88.638%" y1="29.267%" x2="22.42%" y2="100%" id="logo-b">
                      <stop stop-color="#38BDF8" stop-opacity="0" offset="0%" />
                      <stop stop-color="#38BDF8" offset="100%" />
                    </linearGradient>
                  </defs>
                  <rect fill="#6366F1" width="32" height="32" rx="16" />
                  <path d="M18.277.16C26.035 1.267 32 7.938 32 16c0 8.837-7.163 16-16 16a15.937 15.937 0 01-10.426-3.863L18.277.161z" fill="#4F46E5" />
                  <path d="M7.404 2.503l18.339 26.19A15.93 15.93 0 0116 32C7.163 32 0 24.837 0 16 0 10.327 2.952 5.344 7.404 2.503z" fill="url(#logo-a)" />
                  <path d="M2.223 24.14L29.777 7.86A15.926 15.926 0 0132 16c0 8.837-7.163 16-16 16-5.864 0-10.991-3.154-13.777-7.86z" fill="url(#logo-b)" />
                </svg>
              </router-link>
            </div>
          </div>

          <div class="max-w-sm mx-auto px-4 py-8">
            <h1 class="text-3xl text-slate-800 font-bold mb-6">Welcome back! ✨</h1>
            <Banner type="error" :open="!!error">
              {{ error }}
            </Banner>
            <!-- Form -->
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium mb-1" for="email">Email Address</label>
                  <input id="email" class="form-input w-full" type="email" required v-model.trim="email" />
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1" for="password">Password</label>
                  <input id="password" class="form-input w-full" type="password" autoComplete="on" required v-model.trim="password" />
                </div>
              </div>
              <div class="flex items-center justify-between mt-6">
                <div class="mr-1">
                  <router-link class="text-sm underline hover:no-underline" to="/reset-password">Forgot Password?</router-link>
                </div>
                <button v-if="isLoading" class="btn bg-indigo-500 hover:bg-indigo-600 text-white disabled:border-slate-200 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed shadow-none" disabled>
                  <svg class="animate-spin w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                    <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
                  </svg>
                  <span class="ml-2">Loading</span>
                </button>
                <button v-else class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3" type="submit" >Sign In</button>

              </div>
            </form>
            <!-- Footer -->
            <div class="pt-5 mt-6 border-t border-slate-200">
              <div class="text-sm">
                Don’t you have an account? <router-link class="font-medium text-indigo-500 hover:text-indigo-600" to="/register">Sign Up</router-link>
              </div>
              <!-- Warning -->
              <div class="mt-5">
                <div class="bg-amber-100 text-amber-600 px-3 py-2 rounded">
                  <svg class="inline w-3 h-3 shrink-0 fill-current mr-2" viewBox="0 0 12 12">
                    <path d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z" />
                  </svg>
                  <span class="text-sm">
                    To support you during the pandemic super pro features are free until March 31st.
                  </span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Image -->
      <div class="hidden md:block absolute top-0 bottom-0 right-0 md:w-1/2" aria-hidden="true">
        <img class="object-cover object-center w-full h-full" src="../images/auth-image.png" width="500" height="1024" alt="Authentication" />
        <!-- <img class="absolute top-1/4 left-0 -translate-x-1/2 ml-8 hidden lg:block" src="../images/auth-decoration.png" width="218" height="224" alt="Authentication decoration" /> -->
      </div>

    </div>

  </main>
</template>

<script>
import Banner from '@/components/Banner.vue'

export default {
    components: {
      Banner
    },
    data() {
        return {
            email: '',
            password: '',
            formIsValid: true,
            isLoading: false,
            error: null
        }
    },
    methods: {
        async submitForm() {
            this.formIsValid = true;
            this.error = null;
            if (this.email === '' || !this.email.includes('@') || this.password.length < 4) {
                this.formIsValid = false;
                return;
            }

            this.isLoading = true;

            const actionPayload = {
                email: this.email,
                password: this.password
            };

            try {
                await this.$store.dispatch('auth/login', actionPayload);
                const redirectUrl = '/' + (this.$route.query.redirect || 'dashboard');
                this.$router.replace(redirectUrl);
            } catch (error) {
                this.error = error.message || 'Failed to authenticated, try later.';
            }

            this.isLoading = false;
        }
    }
}
</script>
