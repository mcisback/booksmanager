<script setup>
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    pagination: {
        type: Object,
        required: true,
    },
    itemName: {
        type: String,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    }
})

const currentPage = parseInt(usePage().props.query.page ?? 1);
const prevPage = currentPage === 1 ? null : route(props.routeName) + '?page=' + (currentPage - 1)
const nextPage = currentPage === props.pagination.last_page ? null : route(props.routeName) + '?page=' + (currentPage + 1)

console.log('PAGINATION PAGINATION: ', props.pagination)
console.log('PAGINATION currentPage: ', currentPage)
console.log('PAGINATION routeName: ', props.routeName)
console.log('PAGINATION itemName: ', props.itemName)

console.log('prevPage: ', prevPage)
console.log('nextPage: ', nextPage)
</script>

<template>
    <div class="flex flex-col items-center">
        <!-- Help text -->
        <span class="text-sm text-gray-700 dark:text-gray-400">
  Pagina <span class="font-semibold text-gray-900 dark:text-white">{{props.pagination.current_page}}</span> / <span class="font-semibold text-gray-900 dark:text-white">{{props.pagination.last_page}}</span> di <span class="font-semibold text-gray-900 dark:text-white">{{props.pagination.total}}</span> {{props.itemName}}
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
</template>

<style scoped>

</style>
