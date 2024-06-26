<script setup>

import {Head} from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    }
})
</script>

<template>
    <Head title="Modifca Utente" />

    <DashboardLayout title="Modifica Utente">

        <div class="py-12 w-full">
            <div class="w-full">


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    {{ user.name }}
                </div>

            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>

</style>
