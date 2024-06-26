<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {getCurrentInstance, onMounted, ref} from "vue";
import {useApiEndpoint} from "@/Compostable/useApiEndpoint.js";
import BookCard from "@/Components/BookCard.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const apiEndpoint = useApiEndpoint(getCurrentInstance());
const books = ref([]);

console.log('API ENDPOINT: ', apiEndpoint)
console.log('usePage().props: ', usePage().props)

onMounted(async () => {
    books.value = await fetch(`${apiEndpoint}/books`, {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            // 'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': usePage().props.csrf
        },
    })
        .then(res => res.json())

    console.log('BOOKS: ', books.value)
});
</script>

<template>
    <Head title="Home" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                    <div class="w-100">
                        <form class="max-w-md mx-auto mt-4">
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cerca</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Trova Libri" required />
                                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                            </div>
                        </form>
                    </div>

                    <div class="w-100 flex flex-wrap">
                        <div v-for="book in books" v-if="books">
                            <BookCard :name="book.name" :image="book.image" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
