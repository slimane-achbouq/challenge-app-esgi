<template>
    <!-- Card 1 -->
        <div
            class="col-span-full md:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200 overflow-hidden">
            <div class="flex flex-col h-full">
                <router-link :to="{ name: 'announce', params: { id: id }}">

                <!-- Image -->
                <div class="relative">
                    <img class="w-full" :src="src" width="301" height="226"
                         alt="Application 21"/>
                    <!-- Like button -->
                    <button class="absolute top-0 right-0 mt-4 mr-4">
                        <div class="text-slate-100 bg-slate-900 bg-opacity-60 rounded-full">
                            <span class="sr-only">Like</span>
                            <svg class="h-8 w-8 fill-current" viewBox="0 0 32 32">
                                <path
                                    d="M22.682 11.318A4.485 4.485 0 0019.5 10a4.377 4.377 0 00-3.5 1.707A4.383 4.383 0 0012.5 10a4.5 4.5 0 00-3.182 7.682L16 24l6.682-6.318a4.5 4.5 0 000-6.364zm-1.4 4.933L16 21.247l-5.285-5A2.5 2.5 0 0112.5 12c1.437 0 2.312.681 3.5 2.625C17.187 12.681 18.062 12 19.5 12a2.5 2.5 0 011.785 4.251h-.003z"/>
                            </svg>
                        </div>
                    </button>
                    <!-- Special Offer label -->

                </div>
                <!-- Card Content -->
                <div class="grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="grow">
                        <header class="mb-2">
                            <a href="#0">
                                <h3 class="text-lg text-slate-800 font-semibold mb-1">{{ title }}</h3>
                                <div v-if="currentRole == 'Admin' && status == 0" class="float-right">
                                    <span class="text-sm text-orange-600">Pending to review</span>
                                </div>
                            </a>
                            <div class="text-sm">{{ description }}</div>
                        </header>
                    </div>
                    <!-- Rating and price -->
                    <div class="flex flex-wrap justify-between items-center">
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mr-2">
                            <!-- Stars -->
                            <div class="flex space-x-1">
                                <button>
                                    <span class="sr-only">1 star</span>
                                    <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                        <path
                                            d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"/>
                                    </svg>
                                </button>
                                <button>
                                    <span class="sr-only">2 stars</span>
                                    <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                        <path
                                            d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"/>
                                    </svg>
                                </button>
                                <button>
                                    <span class="sr-only">3 stars</span>
                                    <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                        <path
                                            d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"/>
                                    </svg>
                                </button>
                                <button>
                                    <span class="sr-only">4 stars</span>
                                    <svg class="w-4 h-4 fill-current text-amber-500" viewBox="0 0 16 16">
                                        <path
                                            d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"/>
                                    </svg>
                                </button>
                                <button>
                                    <span class="sr-only">5 stars</span>
                                    <svg class="w-4 h-4 fill-current text-slate-300" viewBox="0 0 16 16">
                                        <path
                                            d="M10 5.934L8 0 6 5.934H0l4.89 3.954L2.968 16 8 12.223 13.032 16 11.11 9.888 16 5.934z"/>
                                    </svg>
                                </button>
                            </div>
                            <!-- Rate -->
                            <div class="inline-flex text-sm font-medium text-amber-600">4.7</div>
                        </div>
                        <!-- Price -->
                        <div>
                            <div
                                class="inline-flex text-sm font-medium bg-rose-100 text-rose-600 rounded-full text-center px-2 py-0.5">
                                {{ price }} €
                            </div>
                        </div>
                    </div>
                </div>
                </router-link>
            </div>
        </div>

</template>

<script>
import announce from "@/views/Announce.vue";

export default {
    name: 'AnnonceCards',
    computed: {
        announce() {
            return announce
        }
    },
    props: ['@id', 'id', '@type', 'title', 'description', 'owner', 'price', 'image', 'isPerHour', 'isAvailable', 'src', 'url', 'currentRole', 'status'],
}
</script>
