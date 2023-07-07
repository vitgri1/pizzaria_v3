<script setup>
import AuthenticatedLayout from '@/Layouts/CustomLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue'

defineProps({
  pizza_sizes: Object,
  pizza_toppings: Object,
  storeUrl: String,
});

const base = ref(0);
const topping = ref(0);
const toppings = ref({});

function addTopping (topping, toppings, pizza_toppings) {
    if (topping != 0) {
        toppings[topping] = pizza_toppings[topping];
        delete pizza_toppings[topping];
    }
    return 0;
}

function deleteTopping (pizza_toppings, event) {
    pizza_toppings[event.target.dataset.topId] = event.target.dataset.top;
    delete toppings.value[event.target.dataset.topId];
}

function makeOrder (storeUrl) {
    router.post(storeUrl, 
    {
        toppings: toppings.value,
        base: base.value,
        name: 'jonas'
    },
    )
}

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Make a new order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-visible shadow-sm sm:rounded-lg relative">
                    <div class="p-6 text-gray-900 flex flex-col">
                    
                        <div class="flex flex-col items-start gap-1">
                            <label for="base-select">Select the size of pizza base</label>
                            <select v-model="base" id="base-select" class="capitalize">
                            <option v-for="(value, key) in pizza_sizes" :key="value" :value="value">
                                {{ key }}
                            </option>
                            </select>
                        </div>
                        
                        <div class="flex items-center gap-8">
                            <div class="flex flex-col items-start gap-1">
                                <label for="topping-select">Select additional toppings</label>
                                <select v-model="topping" id="topping-select" class="capitalize">
                                    <option v-for="(value, key) in pizza_toppings" :key="value" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>
                            
                            <button
                            @click="topping = addTopping(topping, toppings, pizza_toppings)"
                            class="border rounded border-solid border-black bg-slate-200 p-1 hover:bg-green-400"
                            >
                                Add an additional topping
                            </button>
                        </div>

                        <div class="flex flex-col items-start gap-1">
                            <p v-if="Object.keys(toppings).length > 0">Added toppings:</p>
                            <ul v-if="Object.keys(toppings).length > 0">
                                <li v-for="(top, topId) in toppings" class="flex items-center gap-2">
                                    <button
                                    :data-top="top"
                                    :data-top-id="topId"
                                    @click="deleteTopping(pizza_toppings, $event)"
                                    class="border rounded border-solid border-black bg-slate-200 p-1 leading-none font-black hover:bg-red-700"
                                    >╳</button>
                                    <p class="capitalize">{{ top }}</p>
                                </li>
                            </ul>
                            <p>Esitamted cost of the order: {{ base + Object.keys(toppings).length }}€</p>
                        </div>
                    </div>
                    <button 
                    class="absolute bottom-2 right-2  border rounded border-solid border-black bg-slate-200 p-1 hover:bg-indigo-400"
                    @click="makeOrder(storeUrl)"
                    >
                        Make order
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
