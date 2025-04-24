<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <Link
        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium focus-visible:outline-none focus-visible:ring-1 disabled:pointer-events-none disabled:opacity-50 shadow h-9 px-4 py-2 bg-gray-500 border border-transparent text-white uppercase tracking-widest hover:bg-gray-500/90 active:bg-gray-500/90 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <slot></slot>
    </Link>
</template>
