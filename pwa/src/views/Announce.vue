<template>
    <div class="flex h-screen overflow-hidden">

        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Site header -->
            <Header/>

            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full">

                    <!-- Page content -->
                    <div class="max-w-5xl mx-auto flex flex-col lg:flex-row lg:space-x-8 xl:space-x-16">
                        <!-- Content -->
                        <div>
                            <div v-if="status == 0"
                                 class="bg-orange-500 text-center flex items-center justify-center mb-5"
                                 style="border-radius: 10px; height: 50px">
                            <span class="text-white">
                                The announce is being verified by an administrator. Thank you for waiting.
                            </span>
                            </div>
                            <div v-else-if="status == 2"
                                 class="bg-red-500 text-center flex items-center justify-center mb-5"
                                 style="border-radius: 10px; height: 50px">
                            <span class="text-white">
                                The announce has been deleted.
                            </span>
                            </div>
                            <router-link to="/dashboard/announces">
                                <span class="text-indigo-500">Go back</span>
                            </router-link>
                            <header class="mb-4 flex justify-between">

                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-2 ">{{ title }}</h1>

                                <div>
                                    <button class="btn border-slate-200 hover:border-slate-300 text-slate-600">
                                        <svg class="w-4 h-4 fill-current text-slate-500 shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M11.7.3c-.4-.4-1-.4-1.4 0l-10 10c-.2.2-.3.4-.3.7v4c0 .6.4 1 1 1h4c.3 0 .5-.1.7-.3l10-10c.4-.4.4-1 0-1.4l-4-4zM4.6 14H2v-2.6l6-6L10.6 8l-6 6zM12 6.6L9.4 4 11 2.4 13.6 5 12 6.6z"/>
                                        </svg>
                                        <span class="ml-2">Edit </span>
                                    </button>

                                    <button
                                        class=" ml-2 justify-end btn border-slate-200 hover:border-slate-300 text-rose-500 sm:justify-end">
                                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 16 16">
                                            <path
                                                d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z"/>
                                        </svg>
                                        <span class="ml-2">Delete</span>
                                    </button>
                                </div>
                            </header>

                            <!-- Meta -->
                            <div class="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0 mb-6">
                                <!-- Author -->
                                <div class="flex items-center sm:mr-4">
                                    <a class="block mr-2 shrink-0" href="#0">
                                        <img class="rounded-full"
                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAilBMVEX///8AAAD7+/v19fX4+Pi4uLi/v7+lpaWurq6fn5/f399mZmbU1NTNzc3y8vLo6Ojh4eFKSkp5eXmUlJR/f39SUlIdHR2MjIwNDQ2+vr6wsLCamprIyMhsbGw0NDTY2Ng9PT1bW1slJSVEREQuLi50dHSOjo4VFRV9fX1ra2spKSlWVlZfX19NTU2a/HRDAAAN3UlEQVR4nNVd2WLiOgxlKPsSSlkKLWVpB+gw7f//3p2wx0d2JFmB3vPYxY4SWbvkUqlolJPWrNp8/mx/zHfj7eTXZLybf4zehs/Naq2TlAvfv1AspoP2/FcY86/NS+feD6pAudVYj3Nou8ZyWO3d+5kFWDRHAuLOmPxpPN770RlIqm0NdSeM19OHe5MQQq/ejyHviH4juTchNMrVbwPyDhi9/DwZ230zI++A9eLeJF2j8iqRm1z8rv+UI/n4VAB5B6x/gnDt/i2MvhRf92bW7rJQ+lL072nxdD8Kpy/FqHUn+hYWyo+H9j1MusRaPYSxvrkVMLgpfSnqN6VvJnu47bL9/FqvdTuL1uNja7HodKf11+FqKdOiu9uJnIrAuF49V1t+BksW1ecVf7G3ym0IfGE+T39T4wmIZDbgmrTVgmlL8cB65/NNV/a+y50BS7W2CzfJa4ynWL3oBN/D9A9j9ZkxRQ7yTdBVLeqwMHyUtRUxBHp5wm9ej1dblUYeu+4K0//VvJdrZSW3hjk71Yw2cvAc3HTStPTmKs1JcLdnw73Oewat0PGL+YbV36EN++YyNQkeQXv6UkzfA1u+GxuqncBe22LoSzENvVdT33ga2OjVciNAPbCzobxp+nd5K9yr2fg3b1rt4Sdwfgtz/9Ev4wY2O/hdwWIZ9AK/rW+iNbwELm8XWki8AT0DEr0EGnEIEw3fYwxjV/adwa1WVpeVqjrxpVojSfS9urZ4pUqnMWj3l9t/9t14/vF3+FqVxgg/i2Amn60tFNPJdEiq7o9BV7KMTytHxKh8ASeRjnhoBOPGTwKP9tGzhlr1t+j15hIl32FErTbsBR88L0vEChdU6NX+CpaYMcP+a7bi8bwwneKiXe1P/gItQdifrddoL3WskdD02xIIrjxH3QH3PNL6ayQn8JVciC9EO+K0MDfCRNtwYuOmSy7TYP9/yOvxYczM+NJaQxgsfogkUMihJzBlIq2mZdKGlBF8AjmRXRLMw0h+xd8SAklzm38G1QSySSQPgcBCJQ8hX4oqWfQA5lkkBSHfPKL+mx9L9zo6LEyYSQFSL3JDtmvif/n6phdFIN9movT1ivevlL0tOMV5JbO54AYnKYuQpzKoXfnGtkYROmDyWoUK/HOsN4pH+ba7x1wX4Ym5F+VM/cn/Nyq6LXB4aWNPCC7HUJo/X57u8J+Y53cPCwL5NiaVsM37H0rUC5K6eSlGJtj7EWItR29Tx0gSVTMqE55y96NUU5jHiXjWRkBgYkMgR14cQYjut9DfE9JJZM8aMamATUtENDzEdCv8c1FU06xamH8yCLbp+/+aCK7Jwq2hpK0IfEeN4lO/xsAvPhYRSPvNGgjiXUTE7MP3pwvJ26Dgi9jKIQlZEpzns8GwW0mYnhAWZQYg4h30Rz0fkfiEwhQ2t2qRAcm2hBKn8w7ocEkjdHG+r5pCQtiQ7ixhHkgDyYYUysr/UIZTSg65WZy1MuRSWQkZxt4oDwx3kRJoZ9KI98YKMWQCfP8CrXsEp7y2GApxZ/RpwQ/Zign0pAJuQSE+/rv7F6gqFLljQt8oAc+XBzwgrtbH6IycQEMK5+K9YQnXWoE/0JTi2Nk0E/HeGCDKyhr8yJqKPINI4gnigmO0+rOScuX++ktBIJ2x0kEuyOGcZdxEfAGa6oZQma0UMrctBTo212wITCrfoOQrbVBCXvcI219rAzC6NXWVhjZbCrEgAClwzaawvKY+ZWtLIT/edgRGbC7iCqS8NwwQgKFBc4D4I0IQ5lINBm6FXJLRGZ0oiKu4QZpcsrrAXxplaMykwaAgjTIscfoN+L7italF4iF+hi93hVPYFYSgpmAz1JKhhHhkBBByUglwgjTTKAI9GVqIrQ6QpqegJFSgKQiMKzGhIW/6BS/x8GM4QdwscwbmolQj0aG/5sCNIGRVRcUFjFiQUwg6+VDXAfylamUq4BvKe+IgNnzQiG7edqch0NsrEAFF17brvx08CJpuKUyKMLJQDG2BWrA0qA2CRmOymcZKT1CcFtDKqc6HUKOu38cuCnWG4ingc6UaB2pJVQQaZkdPkHcelfDIpXUWrvercu9LBhV7LlTNPm4ONLVqXOdfO5TB3KhRTYdynyINLbtej7Yx1NoDFoe994AE3wOeH3Y9kgtjCnXdofCeEwzCqdvcw1MlxNCN2wP3ooMxGnX7uafVTYml7iGAJWugqeUZgzNWlhRqB+24rmADrC1RHVsWlkpf/RiuaniG06MJJJ5gOART2TOJjPQEPoHKkjjCLhq1VD+DqxC/wKSJauE3mxSpn1rmnroPeKio3m+rgJvWcixh9mIH5mTcvBCjabsRE29co2YL5URxAxhtvMQIeY5PAGapzv89g2hmkEMtSEuEu1tyW2siJxNaFCvEiHM0TMFejh1NpBqpn0XU2CJItQOFsWMJ4+uE4+b65FMYPV4q1hOWFwsJKVS7hyfEdq9FDn5GCl1ZGj8DNU5jSFp0KKCkcSszDQYSx1SdKCoiswBhDo9jMAMtxhWOHo/mZknHIN0tBlzpcxjx01fdTO0cfIvo2VklqmSAi/iJlm6A+y94raqSPRdaYWMw6tn16NegvmJ8/At0jqJiyAzArcf4tIzTXEEnbCyG+GGcBhjKZrirJiUcqwr3cD3UumG8NANNv6zFvkS8FPjJaGCnPAIe6ZkeAMGwDr5so9H14nxiRGzmCuAAJ6i7rGZaSn0Mm/sroIy2gpnNKA/7ClJH0eZmB1e9pzk6KPUx2akkzbYtbTZ1FXFaZgllIlbXZMjiGd82m7rLpgFuOJtW04+h2jOIpcmecDTSyCuoC6sra2RK38QeRvtln+8tZi9pj5CFT0No4f1P3cNpo5ik6UQbNexapQdaQHFZTbEWzZAwMRbBfDnMOQHetboJQNLaHRy5wgZIzYNMAVNO3K3igyCJYcM3wI7H0CR0SpjsVpJ4iUamIpyL48+9bQrR4GZMLZz7EsGNp1p9EOt2A+V5ARsjewYJOYVGgZkiUwfX4FS72UiZEtHDejbPYE/DC07LuaaN2V1qGFc4/woewvTiiseggTrEnuaeMgcM2ulinYEasTJrjkg2ngqGXZNwZJLJrydVOAxCmBfuwISY0r/wa7XOBmqI5wNSZid75aVIY2K90pWdBN2XKjt48R70LcuLanP4Nfruj76GzapPIz0ctfNIbAOAo3sd3Eb7Srp86WBQxMv9i9KWVmfBSbh2A1EKiQVcbaJ6LBcZ50AUX8QqkAwXrNzfLmUP1jvLy7gsueP97AR1EyCxsxkYtD1Eltu14xljQ+NIvCWXRpQzDgfA7wWGRjbtGmEQkdcxLHnaEcOzjtRDy4PrktbcSgBVg2YKXyJgzlAdmJR1474YcuApjBnRKqM0wwJxnW09zwTA1jlgbyygYHzELj2vRXUUc8ZoDcOL4kuBP8G5HbmCv+orK1kqCMz3lr8DYho7yQnTGpcMBr97ofSZ3MHk5RuHvoIp/FNiSBEKI/9JLL/kjBMS27XBS0evMK9T3IqnkFIFRK7Iw/qz/PsrpKVNkk7wJVw6TOQqSXWO2ohKtHV5wXqZ6S4doTWqZmQrVijR9jFx1l1m6/LTnhI+1QyYerp8JYL7PJYQpsMy9snjMHwLcRYCJ1pZr9k/kYG2ns+uIl7lxQGpSYuA+LUj6kHu8/13JBSp1wgiiDgK3YZivg5X78d08qczo/GnftOY+Ij7YM5C1WPADPPGdbwtqYqIgD9CRMVq+pfMc3wip5wTL38Z2I2qn9D33LGUYgFzbYJinKAmopWJUW9cwCiGcLmM1fUNR+SHPbnWmgA5Es52REmuBV7ARJRcLWXUX3dEzhhSY5bZI49A49EIOT6m9zJqPRgBBttxSMGTaDeV9wzOvUb6QnsKwSxWAWKGNZ3XdlpQYKMCxvQxy0hWlnsGgitmd7acwa0HsLg77Qx/d8M9J0uZSgBvxtz+EwoCtZbGok9hGF4zcISoacrw/frsb9PJ0SlkQ4nsbv3x9Z7bm9zCAhJDSU6H3cwnSYrbNQxnIlHLm493U2S8DBrrj6DYx/CSgT00LXdlMy+DKhw3ljPcW4SzMJunQ1jD1pOjlWVqVncdEMO1jJlUXR5hpZTxDZsNI9ojon/C6FWDNWXr20eVw5LXyIsBhpup0R3ZqWFioUKPiuHYs/j6WxMS3UUt1jzCoMPHwrhxljQ8hiYV1AZf0QnS2vmfkvtKA4j/ik4JhVkcOLYS0u6JnCyUrDPRD7uuiWhfyrE5jIYqW/Vn7RFpwGVVvlGkK2aqG4GepEoBkPVOTUTp1qqH8IxKzKVqWcPRIjWytOrHvkaESM1+QwOD3qanFqCXN9lzGH+prlkjkYue1u3PaotYc/7d/AheQTnjKltHF2lBmLW60dAZXNmXHmcGFsahJ1Q0Bkl2iRgKv8TXdyogv+fQCdREcGnhH/CACtkXEYATbFNTuLrFBzygKyzkG89HT4N646Vam3W7HWWlwDZ2tKoMcDtW4TDta+WgJ2XVOLRtRpDJsDC8/jcH32YTAoSgWoIKALO3qyAazTO5gPltBQyiq67SZqF/z+93wqKAiwGPaN/r/Ll4eDW/SPYfxoN7yE8vZtZlhu2fwJ5ZJHU7qfPRKCJIYYBe3SIvOGr8KO50kVTXUVG59vR21rUerbqujqM/+Hlnz4ty6+VJYvBM2q/dH3r0Qih3XjZfeXXA7x9Pze7/gTP9qPQ6tcbmczV/vxzQye777fO5WZ31iqftPxLrys///fLfAAAAAElFTkSuQmCC"
                                             width="32" height="32" alt="User 04"/>
                                    </a>
                                    <a class="block text-sm font-semibold text-slate-800 whitespace-nowrap" href="#0">
                                        ELMOHRI Othmane
                                    </a>
                                </div>

                                <!-- Right side -->
                                <div class="flex flex-wrap items-center sm:justify-end space-x-4">

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
                                        <div class="inline-flex text-sm font-medium text-amber-600">4.2</div>
                                    </div>
                                </div>

                            </div>

                            <div class="text-sm font-semibold text-indigo-500 uppercase mb-2">{{ createdAt }}</div>
                            <!-- Image -->
                            <figure class="mb-6">
                                <img class="w-full rounded-sm"
                                     :src="src"
                                     width="640" height="360" alt="Product"/>
                            </figure>

                            <!-- Product content -->
                            <div>
                                <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Description</h2>
                                <p class="mb-6">{{ description }}</p>
                            </div>

                            <hr class="my-6 border-t border-slate-200"/>

                        </div>

                        <!-- Sidebar -->
                        <div>
                            <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                                <div class="text-sm text-slate-800 font-semibold mb-3">The offer</div>
                                <ul class="space-y-2 sm:flex sm:space-y-0 sm:space-x-2 lg:space-y-2 lg:space-x-0 lg:flex-col mb-4">
                                    <li>
                                        <button
                                            class="w-full h-full text-left py-3 px-4 rounded bg-white border-2 border-indigo-400 shadow-sm duration-150 ease-in-out">
                                            <div class="flex flex-wrap items-center justify-between mb-0.5">
                                                <span v-if="isPerHour"
                                                      class="font-semibold text-slate-800">Per hour </span>
                                                <span v-else class="font-semibold text-slate-800">Fixed </span>
                                                <span class="font-medium text-emerald-600">€{{ price }}</span>
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                                <div v-if="status == 0" class="mb-4">
                                    <span class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white opacity-30">Order
                                        Now</span>
                                </div>
                                <div v-else-if="status == 1" class="mb-4">
                                    <router-link to="#">
                                    <span class="btn w-full bg-indigo-500 hover:bg-indigo-600 text-white">Order
                                        Now</span>
                                    </router-link>
                                </div>
                            </div>

                            <hr class="my-6 border-t border-slate-200"/>
                            <!-- 2nd block -->
                            <div class="bg-white p-5 shadow-lg rounded-sm border border-slate-200 lg:w-72 xl:w-80">
                                <div class="flex justify-between space-x-1 mb-5">
                                    <div class="text-sm text-slate-800 font-semibold">Requests</div>
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
import Header from '../partials/Header.vue'

export default {
    name: 'Announce',
    components: {
        Header,
    },
    data() {
        return {
            title: "",
            description: "",
            price: null,
            isPerHour: null,
            createdAt: null,
            src: "",
            status: "",
        }
    },
    setup() {


        return {}
    },
    async created() {
        let token = localStorage.getItem('esgi-ws-token');

        let id = document.URL.substring(document.URL.lastIndexOf('/') + 1);
        console.log(id)
        const response = await fetch(`${import.meta.env.VITE_API_URL}/annonces/${id}`, {
            method: 'GET',
            headers: {
                // 'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            },
        });

        let data = await response.json();
        this.title = data.title;
        this.description = data.description;
        this.isPerHour = data.isPerHour;
        let date = new Date(data.createdAt);
        this.createdAt = date.toLocaleDateString() + " at " + date.toLocaleTimeString();
        this.price = data.price;
        this.status = data.status;
        this.src = import.meta.env.VITE_API_URL + '/uploads/images_annonces/' + data.image;
        console.log(data)
    }
}
</script>
