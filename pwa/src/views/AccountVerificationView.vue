<template>
    <section class="flex items-center w-full h-screen bg-gray-50 text-gray-800">
        <div v-if="isLoading" class="container flex flex-col items-center justify-center px-5 mx-auto my-8 space-y-8 text-center sm:max-w-md">
            <svg class="animate-spin w-20 h-20 fill-current shrink-0" viewBox="0 0 16 16">
                <path d="M8 16a7.928 7.928 0 01-3.428-.77l.857-1.807A6.006 6.006 0 0014 8c0-3.309-2.691-6-6-6a6.006 6.006 0 00-5.422 8.572l-1.806.859A7.929 7.929 0 010 8c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8z" />
            </svg>
        </div>
        <div v-else-if="isVerified" class="container flex flex-col items-center justify-center px-5 mx-auto my-8 space-y-8 text-center sm:max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-40 h-40 text-gray-400" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512"><path fill="#3AAF3C" d="M256 0c141.39 0 256 114.61 256 256S397.39 512 256 512 0 397.39 0 256 114.61 0 256 0z"/><path fill="#0DA10D" fill-rule="nonzero" d="M391.27 143.23h19.23c-81.87 90.92-145.34 165.89-202.18 275.52-29.59-63.26-55.96-106.93-114.96-147.42l22.03-4.98c44.09 36.07 67.31 76.16 92.93 130.95 52.31-100.9 110.24-172.44 182.95-254.07z"/><path fill="#fff" fill-rule="nonzero" d="M158.04 235.26c19.67 11.33 32.46 20.75 47.71 37.55 39.53-63.63 82.44-98.89 138.24-148.93l5.45-2.11h61.06c-81.87 90.93-145.34 165.9-202.18 275.53-29.59-63.26-55.96-106.93-114.96-147.43l64.68-14.61z"/></svg>
            <p class="text-3xl">Congratulation ! your account is activated you can sign in to your account now.</p>
            <router-link :to="{ name: 'login'}" class="px-8 py-3 font-semibold rounded bg-indigo-600 text-gray-50">Sign In</router-link>
        </div>
        <div v-else class="container flex flex-col items-center justify-center px-5 mx-auto my-8 space-y-8 text-center sm:max-w-md">
            <svg class="w-40 h-40 text-gray-400" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="122.879px" height="122.879px" viewBox="0 0 122.879 122.879" enable-background="new 0 0 122.879 122.879" xml:space="preserve"><g><path fill-rule="evenodd" clip-rule="evenodd" fill="#FF4141" d="M61.44,0c33.933,0,61.439,27.507,61.439,61.439 s-27.506,61.439-61.439,61.439C27.507,122.879,0,95.372,0,61.439S27.507,0,61.44,0L61.44,0z M73.451,39.151 c2.75-2.793,7.221-2.805,9.986-0.027c2.764,2.776,2.775,7.292,0.027,10.083L71.4,61.445l12.076,12.249 c2.729,2.77,2.689,7.257-0.08,10.022c-2.773,2.765-7.23,2.758-9.955-0.013L61.446,71.54L49.428,83.728 c-2.75,2.793-7.22,2.805-9.986,0.027c-2.763-2.776-2.776-7.293-0.027-10.084L51.48,61.434L39.403,49.185 c-2.728-2.769-2.689-7.256,0.082-10.022c2.772-2.765,7.229-2.758,9.953,0.013l11.997,12.165L73.451,39.151L73.451,39.151z"/></g></svg>
            <p class="text-3xl">Token not valid or expired !</p>
            <router-link :to="{ name: 'home'}" class="px-8 py-3 font-semibold rounded bg-indigo-600 text-gray-50">Back to home page</router-link>
        </div>
    </section>
</template>

<script>
export default {
	data() {
        return {
            isLoading: true,
            isVerified: false
        }
    },
	mounted: async function () {
		try {
            const userId = this.$route.params.userId;
            const actionPayload = {
                verifyAccountToken: this.$route.params.token
            };
			const response = await fetch(`https://localhost/users/${userId}/account-verification`, {
				method: 'POST',
				headers: {
					'Content-type': 'application/json'
				},
				body: JSON.stringify(actionPayload)
			});
            const responseData = await response.json();
            console.log(responseData);
			if (response.ok && responseData?.isVerified) {
                this.isVerified = true;
                this.isLoading = false;
			} else {
                this.isLoading = false;
            }
		} catch (err) {
            this.isLoading = false;
		}
  }
}
</script>