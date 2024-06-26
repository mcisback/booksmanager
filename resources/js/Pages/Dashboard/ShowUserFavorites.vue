<script setup>
import {Head, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {onMounted, ref} from "vue";
import BookCard from "@/Components/BookCard.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
})

const books = ref([])
let pagination = null
let currentPage = 1


onMounted(async () => {
    const data = await fetch(route('api.books.user.favorites', props.user), {
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
    <Head title="Preferiti Utente" />

    <DashboardLayout title="Preferiti Utente">

        <div class="py-12 w-full">
            <div class="mx-auto sm:px-6 lg:px-8">
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
    </DashboardLayout>
</template>

<style scoped>

</style>
