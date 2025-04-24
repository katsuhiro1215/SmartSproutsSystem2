<script setup>
import { defineProps } from 'vue';
// Components
import Table from '@/Components/Tables/Table.vue';

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  headers: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <Table>
    <template #head>
      <th
        v-for="header in headers"
        :key="header"
        class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
      >
        {{ header }}
      </th>
    </template>
    <template #body>
      <tr v-for="(item, index) in items.data" :key="index">
        <slot name="renderItem" :item="item" :index="index">
        </slot>
      </tr>
    </template>
  </Table>
</template>