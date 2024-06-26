<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {getCurrentInstance, onMounted, ref} from "vue";
import {useApiEndpoint} from "@/Compostable/useApiEndpoint.js";
import BookCard from "@/Components/BookCard.vue";

const apiEndpoint = useApiEndpoint(getCurrentInstance());
const books = ref([]);
let pagination = null

const currentPage = parseInt(usePage().props.query.page ?? 1);

let prevPage = 0
let nextPage = 0

console.log('CURRENT PAGE: ', currentPage)
console.log('API ENDPOINT: ', apiEndpoint)
console.log('usePage().props: ', usePage().props)

onMounted(async () => {
    const data = await fetch(`${apiEndpoint}/books/favorites`, {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': usePage().props.csrf
        },
    })
        .then(res => res.json())

    books.value = data.data
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
</script>

<template>
    <Head title="Libri Preferiti" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Libri Preferiti</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                    <div class="w-100 flex justify-center py-8">

                        <div class="flex flex-col items-center" v-if="pagination">
                            <!-- Help text -->
                            <span class="text-sm text-gray-700 dark:text-gray-400">
      Pagina <span class="font-semibold text-gray-900 dark:text-white">{{pagination.current_page}}</span> / <span class="font-semibold text-gray-900 dark:text-white">{{pagination.last_page}}</span> di <span class="font-semibold text-gray-900 dark:text-white">{{pagination.total}}</span> Libri
  </span>
                            <div class="inline-flex mt-2 xs:mt-0">
                                <!-- Buttons -->
                                <a class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :href="prevPage">
                                    <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                    </svg>
                                    Prev
                                </a>
                                <a class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" :href="nextPage">
                                    Next
                                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div class="w-100 flex flex-wrap justify-items-center mt-8 gap-2">
                        <div v-for="book in books" v-if="books" class="mx-auto mb-4">
                            <BookCard :id="book.id" :name="book.name" :image="book.cover" :description="book.description" />
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
