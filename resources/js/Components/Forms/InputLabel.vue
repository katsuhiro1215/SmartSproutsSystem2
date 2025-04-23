<script setup>
const props = defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700 leading-none mb-2 peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-slate-100">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span v-if="props.required" class="ml-2 text-red-400 font-bold">※必須</span>
        <span v-else>&nbsp;</span>
    </label>
</template>
