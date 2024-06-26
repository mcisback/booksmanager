<script setup>

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
    image: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    description: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <div class="max-w-60 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a :href="route('bookById', props.id)" class="inline-block w-100">
            <img class="rounded-t-lg w-100" style="width: 100%;" :src="image" alt="" />
        </a>
        <div class="p-5">
            <a :href="route('bookById', props.id)">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ name }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-ellipsis overflow-hidden h-12 inline-block">{{ description }}</p>

            <slot />
        </div>
    </div>
</template>

<style scoped>

</style>
