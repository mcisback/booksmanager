<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";

defineProps({
    book: {
        type: Object,
        required: true
    }
});

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

    console.log('addToFavorite: ', data)
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
                                <button @click="addToFavorite(book)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Aggiungi ai preferiti</button>
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
