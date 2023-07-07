<script setup>
import AuthenticatedLayout from '@/Layouts/CustomLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, onBeforeMount} from 'vue'

const props = defineProps({
  pizza_sizes: Object,
  pizza_toppings: Object,
  urls: Object,
  order: Object
});


const base = ref(props.order.base);
const topping = ref(0);
const toppings = ref(props.order.toppings);

function addTopping (topping, toppings, pizza_toppings) {
    console.log(topping);
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

function makeOrder (updateUrl) {
    router.put(updateUrl, 
    {
        toppings: toppings.value,
        base: base.value,
        name: 'jonas'
    },
    )
}

function destroyOrder (destroyUrl) {
    router.delete(destroyUrl)
}

</script>

<template>
    <Head title="Home" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">This is a home page for your order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-visible shadow-sm sm:rounded-lg relative">
                    <div class="p-6 text-gray-900">
                    
                        <div class="flex flex-col items-start gap-1">
                            <label for="base-select">Select the size of pizza base</label>
                            <select v-model="base" id="base-select" class="capitalize">
                            <option v-for="(value, key) in pizza_sizes" :key="value" :value="value">
                                {{ key }}
                            </option>
                            </select>
                        </div>

                        <div class="flex items-center gap-1">
                            <div class="flex flex-col items-start gap-1">
                                <label for="topping-select">Select additional toppings</label>
                                <select v-model="topping" id="topping-select">
                                    <option v-for="(value, key) in pizza_toppings" :key="value" :value="key">
                                        {{ value }}
                                    </option>
                                </select>
                            </div>

                            <button
                            @click="topping = addTopping(topping, toppings, pizza_toppings)"
                            class="border rounded border-solid border-black bg-slate-200"
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
                    <div class="absolute bottom-2 right-2 flex gap-2">
                        <button 
                        class=" border rounded border-solid border-black bg-slate-200 p-1 hover:bg-indigo-400"
                        @click="makeOrder(urls.updateUrl)"
                        >
                            Make order
                        </button>
                        <button 
                        class=" border rounded border-solid border-black bg-slate-400 p-1 hover:bg-red-400"
                        @click="destroyOrder(urls.destroyUrl)"
                        >
                            Delete order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
