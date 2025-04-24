<script setup>
import { defineProps } from "vue";

defineProps({
  isLoading: Boolean,
  loadingText: {
    type: String,
    default: "Loading, please wait...",
  },
});
</script>

<template>
  <div
    v-if="isLoading"
    class="fixed top-0 left-0 w-full h-full bg-white bg-opacity-80 flex items-center justify-center z-50"
  >
    <div class="text-center">
      <span class="text-lg mb-2">{{ loadingText }}</span>
      <span class="flex justify-center items-center">
        <span
          class="w-4 h-4 bg-black rounded-full animate-bounce duration-100"
        ></span>
      </span>
    </div>
  </div>
</template>