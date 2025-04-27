<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

// Props
const props = defineProps({
  buttonType: {
    type: String,
    default: "default",
  },
  buttonActionType: {
    type: String,
    default: "button",
  },
  buttonSize: {
    type: String,
    default: "base",
  },
});

// Sizes
const sizes = {
  xs: "px-2.5 py-0.5 text-xs",
  sm: "px-3 py-0.5 text-sm",
  base: "px-4 py-1 text-sm",
  lg: "px-4 py-2 text-base",
  xl: "px-6 py-3 text-base",
};

const buttonClass = computed(() => {
  const sizeClass = sizes[props.buttonSize] || sizes.base;
  return `${sizeClass}`;
});
</script>

<template>
  <button
    class="inline-flex items-center justify-center h-9 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
    :class="buttonClass"
    :type="buttonActionType"
  >
    <slot></slot>
  </button>
</template>