<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    book: {
        type: Object,
        required: true
    },
    isFavorited: {
        type: Boolean,
        required: true
    }
});

let addedToFavorites = ref(props.isFavorited)

const addToFavorite = async (book) => {
    console.log('addToFavorite: ', book)

    const data = await fetch(route('api.books.favorites.add', book.id), {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            // 'X-CSRF-TOKEN': usePage().props.csrf
        },
    })
        .then(res => res.json())
        .then((data) => {
            addedToFavorites.value = data.isFavorited

            return data
        })

    console.log('added: ', data)
}
</script>

<template>
    <Head :title="book.name" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ book.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <a href="#">
                            <img class="p-8 rounded-t-lg" :src="book.cover" alt="product image" />
                        </a>
                        <div class="px-8 pb-5">
                            <a href="#">
                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ book.name }}</h5>
                            </a>
                            <div class="flex items-center mt-2.5 mb-5">

                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ book.price }} €</span>

                                <button type="button" @click="addToFavorite(book)" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                                    <svg v-if="addedToFavorites" class="w-6 h-6 ms-2 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    <svg v-else class="w-6 h-6 ms-2 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                    </svg>
                                    Aggiungi ai preferiti
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full max-w-sm p-16 text-2xl">
                        {{ book.description }}
                    </div>
                </div>


            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
