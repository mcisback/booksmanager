<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import Sidebar from "@/Components/Dashboard/Sidebar.vue";

defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-nowrap">
                    <Sidebar />

                    <slot />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
