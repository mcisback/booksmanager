<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {getCurrentInstance, onMounted, ref} from "vue";
import BookCard from "@/Components/BookCard.vue";
import Pagination from "@/Components/Pagination.vue";

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

const books = ref([]);
const booksBackup = ref([]);
let pagination = null

const searchTerm = ref("")

const currentPage = parseInt(usePage().props.query.page ?? 1);

let prevPage = 0
let nextPage = 0

console.log('CURRENT PAGE: ', currentPage)
console.log('usePage().props: ', usePage().props)

onMounted(async () => {
    const data = await fetch(route('api.books.index', {
        page: currentPage
    }), {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            // 'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': usePage().props.csrf
        },
    })
        .then(res => res.json())

    books.value = data.data
    booksBackup.value = [...books.value]

    pagination = {
        ...data.meta,
        links:{
            ...data.links
        }
    }

    console.log('PAGINATION: ', data.meta)
    console.log('BOOKS: ', books.value)
    console.log('currentPage: ', currentPage)

    prevPage = currentPage === 1 ? null : route('home') + '?page=' + (currentPage - 1)
    nextPage = currentPage === pagination.last_page ? null : route('home') + '?page=' + (currentPage + 1)

    console.log('prevPage: ', prevPage)
    console.log('nextPage: ', nextPage)
});

const onSearch = () => {
    books.value = booksBackup.value.filter(book =>
        book.name.toLowerCase().includes(searchTerm.value.toLowerCase())
        ||
        book.description.toLowerCase().includes(searchTerm.value.toLowerCase())
    )
}

const cancelSearch = () => {
    searchTerm.value = ''
    books.value = [...booksBackup.value]
}
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
                        <form class="max-w-md mx-auto mt-4" @submit.prevent="onSearch()">
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Cerca</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input v-model="searchTerm" type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Trova Libri" required />
                                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Search
                                </button>
                            </div>
                            <div class="relative">
                                <button type="button" @click.prevent="cancelSearch()" class="border-none absolute -end-8 bottom-2.5 cursor-pointer  hover:text-white focus:outline-none font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center" v-if="searchTerm != ''">
                                    <svg width="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 8L8 16M8.00001 8L16 16M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="w-100 flex justify-center py-8" v-if="pagination">
                        <Pagination :pagination="pagination" routeName="home" itemName="Libri" />
                    </div>

                    <div class="w-100 flex flex-wrap justify-items-center mt-8 gap-2">
                        <div v-for="book in books" v-if="books" class="mx-auto mb-4 min-h-96">
                            <BookCard :id="book.id" :name="book.name" :image="book.cover" :description="book.description">
                                <a :href="route('bookById', book.id)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Scopri di pi&ugrave;
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </BookCard>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
