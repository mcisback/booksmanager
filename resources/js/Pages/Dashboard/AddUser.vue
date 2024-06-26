<script setup>
import {Head, usePage} from '@inertiajs/vue3';
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

const form = {
    name: '',
    email: '',
    password: '',
}

let response = null
let submitted = false

const onSubmit = async () => {
    response = await fetch(route('api.users.store'), {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${usePage().props.auth.token}`,
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': usePage().props.csrf
        },
        body: JSON.stringify(form)
    })
        .then(res => res.json())

    console.log('AddBook response: ', response)

    submitted = true
}
</script>

<template>
    <Head title="Aggiungi Utente" />

    <DashboardLayout title="Aggiungi Utente">

        <div class="py-12 w-full">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="w-full flex flex-wrap justify-items-center mt-8 gap-2 p-40">

                    <!-- Alert -->
                    <div v-if="submitted">
                        <div v-if="response.success === true" class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Success!</span> {{ response.message }}
                            </div>
                        </div>

                        <div v-else class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Danger!</span> {{ response.message }}
                            </div>
                        </div>
                    </div>


                    <form class="space-y-6 w-full" @submit.prevent="onSubmit()">
                        <!-- Book Name -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                            <input v-model="form.name" type="text" id="name" name="name" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                            <input v-model="form.email" type="text" id="email" name="email" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                            <input v-model="form.password" type="text" id="password" name="password" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruolo</label>
                            <select v-model="form.role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="role">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Add User
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>

</style>
