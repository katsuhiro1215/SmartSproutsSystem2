<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  className: { type: String, default: '' },
});
</script>

<template>
  <div :class="`flex flex-col w-full ${props.className}`">
    <slot />
  </div>
</template>


