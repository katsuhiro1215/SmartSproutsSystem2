<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
  type: String,
  required: true,
});

const textarea = ref(null);

onMounted(() => {
  if (textarea.value.hasAttribute('autofocus')) {
    textarea.value.focus();
  }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
  <textarea
    class="border-gray-300 flex w-full rounded-md bg-white border focus:border-indigo-600 bg-transparent shadow-sm transition-colors placeholder:text-slate-600 focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-700 placeholder:test-gray-700 dark:text-gray-300 dark:border-gray-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:placeholder:text-slate-400"
    v-model="model"
    ref="textarea"
    rows="3"
  ></textarea>
</template>
