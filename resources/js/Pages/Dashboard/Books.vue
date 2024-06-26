<script setup>
import {Head, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {onMounted, ref} from "vue";
import DropdownActions from "@/Components/Dashboard/DropdownActions.vue";
import Pagination from "@/Components/Pagination.vue";

const books = ref([])
let pagination = null
let currentPage = parseInt(usePage().props.query.page ?? 1);


onMounted(async () => {
    const data = await fetch(route('api.books.index', {
        page: currentPage
    }), {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
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

    // prevPage = currentPage === 1 ? null : route('home') + '?page=' + (currentPage - 1)
    // nextPage = currentPage === pagination.last_page ? null : route('home') + '?page=' + (currentPage + 1)

    // console.log('prevPage: ', prevPage)
    // console.log('nextPage: ', nextPage)
});
</script>

<template>
    <Head title="Utenti" />

    <DashboardLayout title="Utenti">

        <div class="py-12 w-full">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-nowrap">
                    <nav class="w-full bg-gray-50 dark:bg-gray-700">
                        <div class="max-w-screen-xl px-4 py-3 mx-auto">
                            <div class="flex items-center">
                                <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                                    <li>
                                        <a :href="route('dashboard.books.add')" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Aggiungi Libro</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="w-100 flex justify-center py-2" v-if="pagination">
                    <Pagination :pagination="pagination" routeName="dashboard.books" itemName="Libri" />
                </div>

                <div class="w-full">


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <!-- Books Table -->
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Descrizione
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Prezzo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Azioni
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="books">
                                <tr v-for="book in books" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" :src="book.cover" alt="Book Cover">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ book.name }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ book.description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ book.price }} €
                                    </td>
                                    <td class="px-6 py-4 flex items-center gap-2">
                                        <a :href="route('dashboard.books.edit', book)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            <svg class="feather feather-edit" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <a :href="route('dashboard.books.edit', book)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                           <svg height="18px" version="1.1" viewBox="0 0 14 18" width="14px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#000000" id="Core" transform="translate(-299.000000, -129.000000)"><g id="delete" transform="translate(299.000000, 129.000000)"><path d="M1,16 C1,17.1 1.9,18 3,18 L11,18 C12.1,18 13,17.1 13,16 L13,4 L1,4 L1,16 L1,16 Z M14,1 L10.5,1 L9.5,0 L4.5,0 L3.5,1 L0,1 L0,3 L14,3 L14,1 L14,1 Z" id="Shape"/></g></g></g></svg>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
