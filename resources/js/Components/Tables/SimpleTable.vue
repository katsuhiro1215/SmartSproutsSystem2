<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  headers: {
    type: Array,
    required: true,
  },
});

const thClass = 'p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400';

const tdClass = 'p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white';
</script>

<template>
  <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
    <thead class="bg-gray-100 dark:bg-gray-700">
      <tr>
        <th v-for="header in headers" :key="header" :class="thClass">
          {{ header }}
        </th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
      <tr v-for="(item, index) in items" :key="index">
        <slot name="renderItem" :item="item" :index="index" :tdClass="tdClass"></slot>
      </tr>
    </tbody>
  </table>
</template>