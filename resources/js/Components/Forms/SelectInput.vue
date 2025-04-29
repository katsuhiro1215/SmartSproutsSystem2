<script setup>
const props = defineProps({
  options: Array,
  modelValue: [String, Number],
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <select
    class="flex h-10 w-full rounded-md border border-gray-300 bg-transparent px-3 py-2 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-600 focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:placeholder:text-slate-400"
    :value="modelValue"
    @change="emit('update:modelValue', $event.target.value)"
  >
    <option class="border-2 border-gray-300" value="" disabled selected>選択してください。</option>
    <option
      v-for="option in options"
      :key="option.value"
      :value="option.value"
    >
      {{ option.label }}
    </option>
  </select>
</template>