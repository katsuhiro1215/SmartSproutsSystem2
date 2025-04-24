<script setup>
import { defineProps } from "vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <h2 class="font-semibold text-lg text-gray-800 leading-tight dark:text-gray-200">
    {{ title }}
  </h2>
</template>