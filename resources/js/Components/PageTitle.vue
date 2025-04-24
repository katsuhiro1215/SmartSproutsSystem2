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
  <h1 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
    {{ title }}
  </h1>
</template>