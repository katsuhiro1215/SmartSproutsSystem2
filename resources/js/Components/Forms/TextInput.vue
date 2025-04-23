<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 placeholder:test-gray-700 dark:text-gray-300 dark:border-gray-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:placeholder:text-slate-400"
        v-model="model"
        ref="input"
    />
</template>
