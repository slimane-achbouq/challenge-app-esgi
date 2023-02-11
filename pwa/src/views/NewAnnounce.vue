<template>


    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false"/>

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen"/>

            <main>

                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

                    <!-- Page header -->
                    <div class="mb-8">
                        <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Create new announce ✨</h1>
                    </div>

                    <div class="border-t border-slate-200">

                        <div>
                            <div class="md:grid md:grid-cols-4 md:gap-3">
                                <div class="md:col-span-1">
                                    <div class="px-4 sm:px-0">
                                        <br>
                                        <h3 class="text-lg font-medium leading-6 text-gray-900">Annouce
                                            information</h3>
                                        <p class="mt-1 text-sm text-gray-600">Note : The announce will be published only
                                            when an administrator verifies it.</p>
                                    </div>
                                </div>


                                <div class="mt-5 md:col-span-2 md:mt-0">
                                    <form @submit.prevent="submitForm" enctype="multipart/form-data" method="post">
                                        <div class="overflow-hidden shadow sm:rounded-md">
                                            <div class="bg-white px-4 py-5 sm:p-6">
                                                <div>
                                                    <label class="block text-sm font-medium mb-1" for="mandatory">Title
                                                        <span class="text-rose-500">*</span></label>
                                                    <input id="mandatory" class="form-input w-full" type="text"
                                                           v-model.trim="title"
                                                           required/>
                                                </div>
                                                <br>
                                                <div class="col-span-6 sm:col-span-4">
                                                    <label for="message"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description
                                                        <span class="text-rose-500">*</span></label>
                                                    <textarea id="message" rows="4" v-model.trim="description" required
                                                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                              placeholder="Write the description here..."></textarea>
                                                </div>
                                                <br>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="country"
                                                           class="block text-sm font-medium text-gray-700">Flexible
                                                        price</label>
                                                    <select id="country" name="country" autocomplete="country-name"
                                                            v-model.trim="isPerHour"
                                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                        <option value="true">Per hour (flexible)</option>
                                                        <option value="false">Fixed</option>
                                                    </select>
                                                </div>

                                                <br>

                                                <div>
                                                    <label for="price" class="block text-sm font-medium text-gray-700">Price
                                                        <span class="text-rose-500">*</span></label>
                                                    <div class="relative mt-1 rounded-md shadow-sm">
                                                        <div
                                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                            <span class="text-gray-500 sm:text-sm">€</span>
                                                        </div>
                                                        <input type="number" name="price" id="price" min="0" step="0.01"
                                                               v-model.trim="price"
                                                               required
                                                               class="block w-full rounded-md border-gray-300 pl-7 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                               placeholder="0.00">
                                                        <div class="absolute inset-y-0 right-0 flex items-center">

                                                        </div>
                                                    </div>
                                                </div>

                                                <br>


                                                <div class="flex items-center justify-center w-full"
                                                     v-if="!hideImageField">
                                                    <label for="dropzone-file"
                                                           class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                        <div
                                                            class="flex flex-col items-center justify-center pt-5 pb-6">
                                                            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400"
                                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                            </svg>
                                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                                <span class="font-semibold">Click to upload</span> or
                                                                drag and drop</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                PNG, JPG or JPEG</p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                REQUIRED</p>
                                                        </div>
                                                        <input id="dropzone-file" type="file" class="hidden" required
                                                               @change="handleFile"/>
                                                    </label>
                                                </div>
                                                <div class="flex items-center justify-center w-full"
                                                     v-if="hideImageField">
                                                    <img :src="previewSrc" alt="Preview image" id="previewImg">
                                                </div>


                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                                <button type="submit"
                                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </main>

        </div>

    </div>

</template>

<script>
import Header from '@/partials/Header.vue'
import Sidebar from '../partials/Sidebar.vue'

export default {
    name: 'NewAnnounce',
    components: {
        Header,
        Sidebar
    },
    data() {
        return {
            title: '',
            description: '',
            price: null,
            isPerHour: false,
            file: null,
            hideImageField: false,
            previewSrc: "",
        }
    },
    methods: {
        handleFile(event) {
            this.file = event.target.files[0];
            this.previewSrc = URL.createObjectURL(event.target.files[0]);
            this.hideImageField = true;
        },
        submitForm: async function () {
            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('isPerHour', this.isPerHour);
            formData.append('price', this.price);
            formData.append('file', this.file);
            formData.append('isAvailable', 0);

            let token = this.$store.getters["auth/token"]
            try {
                const response = await fetch(`${import.meta.env.VITE_API_URL}/annonces`, {
                    method: 'POST',
                    headers: {
                        // 'Content-Type': 'multipart/form-data',
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData,
                });

                const responseData = await response.json();
                this.$router.replace('/announces/' + responseData['id']);
            } catch (e) {
                console.log(e.message)
            }
        }
    },
    setup() {
        return {}
    }
}
</script>
