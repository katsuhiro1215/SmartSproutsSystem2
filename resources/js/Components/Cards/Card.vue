<script setup>
import { defineProps, useSlots } from 'vue';

const props = defineProps({
  header: String,
  title: String,
  description: String,
  footer: String,
  cardClass: {
    type: String,
    default: 'space-y-4 p-6 mb-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-800 rounded-lg shadow-md self-start',
  },
  headerClass: {
    type: String,
    default: 'space-y-1',
  },
  contentClass: {
    type: String,
    default: 'p-4',
  },
  footerClass: {
    type: String,
    default: 'border-t border-gray-200 pt-4',
  },
});

const slots = useSlots();
</script>

<template>
  <div :class="cardClass">
    <div v-if="slots.header || header" :class="headerClass">
      <slot name="header">
        <h3 v-if="title" class="text-2xl font-semibold leading-none tracking-tight">{{ title }}</h3>
        <p v-if="description" class="text-sm text-gray-600">{{ description }}</p>
        <p v-if="header" class="text-sm text-gray-600">{{ header }}</p>
      </slot>
    </div>

    <div :class="contentClass">
      <slot name="content">
        <p class="text-gray-700">No content provided.</p>
      </slot>
    </div>

    <div v-if="slots.footer || footer" :class="footerClass">
      <slot name="footer">
        <p class="text-sm text-gray-500">{{ footer }}</p>
      </slot>
    </div>
  </div>
</template>
