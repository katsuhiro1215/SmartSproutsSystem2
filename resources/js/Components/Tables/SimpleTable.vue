<script setup>
import { defineProps } from "vue";

const props = defineProps({
  headers: {
    type: Array,
    required: false,
  },
});

const tdClass =
  "p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white";
</script>

<template>
  <table
    class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600"
  >
    <thead v-if="headers || $slots.header" class="bg-gray-100 dark:bg-gray-700">
      <tr v-if="headers">
        <th
          v-for="header in headers"
          :key="header"
        >
          {{ header }}
        </th>
      </tr>
      <slot name="header" v-else></slot>
    </thead>
    <tbody
      class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
    >
      <slot name="body"></slot>
    </tbody>
  </table>
</template>