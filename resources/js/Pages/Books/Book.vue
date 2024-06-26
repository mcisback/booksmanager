<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import AddToFavoriteButton from "@/Components/AddToFavoriteButton.vue";

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

const addedToFavorites = ref(props.isFavorited)

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

                                <AddToFavoriteButton :book="book" :isFavorited="addedToFavorites">
                                    Aggiungi ai preferiti
                                </AddToFavoriteButton>
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
