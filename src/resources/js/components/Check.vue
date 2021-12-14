<template>
    <svg :class="colorClass" xmlns="http://www.w3.org/2000/svg" class="ml-3 h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
</template>

<script>

    export default {

        name: "Check",

        props: {
            colorClass: {
                type: String,
                default: 'text-white',
                required: false
            }
        }
    }

</script>
