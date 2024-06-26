<script setup>

let toggled = false
const toggle = () => {
    if(!toggled) {
        document.querySelector('#dropdownMenu').classList.remove('hidden')
    } else {
        document.querySelector('#dropdownMenu').classList.add('hidden')
    }

    toggled = !toggled
}

</script>

<template>
    <div>
        <button @click.prevent="toggle()" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
            <span class="sr-only">Action button</span>
            Azioni
            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownMenu" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            <slot />
        </div>
    </div>
</template>

<style scoped>

</style>
