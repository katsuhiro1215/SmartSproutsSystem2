<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  description: {
    type: String,
    required: true,
  },
});
</script>

<template>
    <p class="text-sm text-gray-600 dark:text-gray-400">
        {{ description }}
    </p>
</template>