<script setup>
import { defineProps, computed } from "vue";

const props = defineProps({
  src: {
    type: String,
    default: "/upload/user.png",
  },
  size: {
    type: String,
    default: "base",
  },
  rounded: {
    type: String,
    default: "full",
  },
});

const sizes = {
  xs: "h-6 w-6",
  sm: "h-8 w-8",
  base: "h-10 w-10",
  lg: "h-12 w-12",
  xl: "h-16 w-16",
  xxl: "h-20 w-20",
};

const roundedOptions = {
  full: "rounded-full",
  lg: "rounded-lg",
  md: "rounded-md",
  sm: "rounded-sm",
  none: "rounded-none",
};

const sizeClass = computed(() => sizes[props.size] || sizes.base);
const roundedClass = computed(
  () => roundedOptions[props.rounded] || roundedOptions.full
);
</script>

<template>
  <div class="flex items-center">
    <img
      :src="src"
      alt="avatar"
      class="object-cover"
      :class="`${sizeClass} ${roundedClass}`"
    />
  </div>
</template>