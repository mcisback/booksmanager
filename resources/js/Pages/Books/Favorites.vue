<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import {getCurrentInstance, onMounted, ref} from "vue";
import BookCard from "@/Components/BookCard.vue";
import AddToFavoriteButton from "@/Components/AddToFavoriteButton.vue";
import Pagination from "@/Components/Pagination.vue";

const books = ref([]);
let pagination = null

const currentPage = parseInt(usePage().props.query.page ?? 1);

let prevPage = 0
let nextPage = 0

console.log('CURRENT PAGE: ', currentPage)
console.log('usePage().props: ', usePage().props)

onMounted(async () => {
    const data = await fetch(route('api.books.favorites'), {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            // 'X-CSRF-TOKEN': usePage().props.csrf
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

                        <div class="w-100 flex justify-center py-8" v-if="pagination">
                            <Pagination :pagination="pagination" routeName="books.favorites" itemName="Libri" />
                        </div>

                    </div>

                    <div class="w-100 flex flex-wrap justify-items-center mt-8 gap-2">
                        <div v-for="book in books" v-if="books" class="mx-auto mb-4">
                            <BookCard :id="book.id" :name="book.name" :image="book.cover" :description="book.description">
                                <AddToFavoriteButton :book=book :isFavorited="true">
                                    Aggiungi ai preferiti
                                </AddToFavoriteButton>
                            </BookCard>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
