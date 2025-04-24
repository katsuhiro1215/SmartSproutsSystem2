<!-- BasicTable.vue -->
<script setup>
const props = defineProps({
  className: { type: String, default: '' },
});
</script>

<template>
  <table :class="`min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600 ${props.className}`">
    <thead :class="`bg-gray-100 dark:bg-gray-700 ${props.className}`">
      <tr>
        <slot name="head"></slot>
      </tr>
    </thead>
    <tbody :class="`bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 ${props.className}`">
      <slot name="body"></slot>
    </tbody>
  </table>
</template>
