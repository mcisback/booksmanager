<script setup>
import {Head, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {onMounted, ref} from "vue";

const users = ref([])
let pagination = null
let currentPage = 1
const currentUser = ref(null)

let openEditUserModal = false

onMounted(async () => {
    const data = await fetch(route('api.users.index'), {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
        },
    })
        .then(res => res.json())

    users.value = data.data
    pagination = {
        ...data.meta,
        links:{
            ...data.links
        }
    }

    console.log('PAGINATION: ', data.meta)
    console.log('USERS: ', users.value)
    console.log('currentPage: ', currentPage)

    // prevPage = currentPage === 1 ? null : route('home') + '?page=' + (currentPage - 1)
    // nextPage = currentPage === pagination.last_page ? null : route('home') + '?page=' + (currentPage + 1)

    // console.log('prevPage: ', prevPage)
    // console.log('nextPage: ', nextPage)
});

const editUser = (user) => {
    currentUser.value = user
    openEditUserModal = true

    console.log('currentUser: ', currentUser.value, openEditUserModal)
}
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
                                        <a :href="route('dashboard.users.add')" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Aggiungi Utente</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>

                <div class="w-full">


                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <!-- Users Table -->
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Ruolo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    N. Libri
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Azioni
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="users">
                                <tr v-for="user in users" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                        <img class="w-10 h-10 rounded-full" src="https://placehold.co/64x64?text=U" alt="Jese image">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold">{{ user.name }}</div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            {{ user.roles.length > 0 ? user.roles[0]?.name : 'Unknown' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a v-if="user.roles.length > 0 && user.roles[0].name === 'user' && user.favorites.length > 0" :href="route('dashboard.books.user.favorites', user)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            {{ user.favorites.length }}
                                        </a>

                                        <span v-else>
                                            {{ user.favorites.length }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a :href="route('dashboard.users.edit', user)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit user</a>
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
