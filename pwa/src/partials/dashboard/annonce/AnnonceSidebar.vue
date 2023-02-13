<template>
    <div>
        <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5 min-w-60">
            <div class="grid md:grid-cols-2 xl:grid-cols-1 gap-6">
                <!-- Group 1 -->
                <div>
                    <div class="text-sm text-slate-800 font-semibold mb-3">Discover</div>
                    <ul class="text-sm font-medium space-y-2">
                        <li>
                            <a class="text-indigo-500" href="#0">View All</a>
                        </li>
                        <li>
                            <a class="text-slate-600 hover:text-slate-700" href="#0">Apps / Software</a>
                        </li>
                        <li>
                            <a class="text-slate-600 hover:text-slate-700" href="#0">Design / Tech Products</a>
                        </li>
                        <li>
                            <a class="text-slate-600 hover:text-slate-700" href="#0">Books & Writing</a>
                        </li>
                        <li>
                            <a class="text-slate-600 hover:text-slate-700" href="#0">Education</a>
                        </li>
                        <li>
                            <a class="text-slate-600 hover:text-slate-700" href="#0">Drawing / Painting</a>
                        </li>
                    </ul>
                </div>
                <!-- Price Range -->
                <div>
                    <div class="text-sm text-slate-800 font-semibold mb-3">Price Range</div>
                    <label class="sr-only">Price</label>
                    <select class="form-select w-full">
                        <option>Less than $20</option>
                        <option>$20 - $40</option>
                        <option>$40 - $80</option>
                        <option>More than $80</option>
                    </select>
                </div>
                <!-- Group 3 -->
                <div>
                    <div class="text-sm text-slate-800 font-semibold mb-3">Multi Select</div>
                    <ul class="space-y-2">
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox"/>
                                <span class="text-sm text-slate-600 font-medium ml-2">Apps / Software</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox"/>
                                <span class="text-sm text-slate-600 font-medium ml-2">Education</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox"/>
                                <span class="text-sm text-slate-600 font-medium ml-2">Books & Writing</span>
                            </label>
                        </li>
                        <li>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox"/>
                                <span class="text-sm text-slate-600 font-medium ml-2">Drawing / Painting</span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AnnonceSidebar',
}
</script>
