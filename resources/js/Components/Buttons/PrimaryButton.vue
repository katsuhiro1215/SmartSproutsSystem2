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
  href: {
    type: String,
    default: null,
  },
});

// Colors
const colors = {
  default: {
    class:
      "text-white bg-black border border-transparent hover:bg-black/90 active:bg-black/90",
  },
  primary: {
    class:
      "text-white bg-blue-500 border border-transparent hover:bg-blue-500/90 active:bg-blue-500/90",
  },
  secondary: {
    class:
      "text-white bg-gray-500 border border-transparent hover:bg-gray-500/90 active:bg-gray-500/90",
  },
  danger: {
    class:
      "text-white bg-red-500 border border-transparent hover:bg-red-500/90 active:bg-red-500/90",
  },
  warning: {
    class:
      "text-white bg-yellow-500 border border-transparent hover:bg-yellow-500/90 active:bg-yellow-500/90",
  },
  success: {
    class:
      "text-white bg-green-500 border border-transparent hover:bg-green-500/90 active:bg-green-500/90",
  },
  info: {
    class:
      "text-white bg-sky-500 border border-transparent hover:bg-sky-500/90 active:bg-sky-500/90",
  },
  orange: {
    class:
      "text-white bg-orange-500 border border-transparent hover:bg-orange-500/90 active:bg-orange-500/90",
  },
  pink: {
    class:
      "text-white bg-pink-500 border border-transparent hover:bg-pink-500/90 active:bg-pink-500/90",
  },
  indigo: {
    class:
      "text-white bg-indigo-500 border border-transparent hover:bg-indigo-500/90 active:bg-indigo-500/90",
  },
  emerald: {
    class:
      "text-white bg-emerald-500 border border-transparent hover:bg-emerald-500/90 active:bg-emerald-500/90",
  },
  light: {
    class:
      "text-gray-900 bg-gray-100 border border-transparent hover:bg-gray-200 active:bg-gray-200",
  },
  dark: {
    class:
      "text-white bg-gray-800 border border-transparent hover:bg-gray-800/90 active:bg-gray-800/90",
  },
  ghost: {
    class:
      "text-gray-900 bg-transparent border border-transparent hover:bg-transparent hover:border-gray-100 active:bg-gray-100",
  },
};

// Sizes
const sizes = {
  xs: "px-2.5 py-0.5 text-xs",
  sm: "px-3 py-0.5 text-sm",
  base: "px-4 py-1 text-sm",
  lg: "px-4 py-2 text-base",
  xl: "px-6 py-3 text-base",
};

const buttonClass = computed(() => {
  const colorClass = colors[props.buttonType]?.class || colors.default.class;
  const sizeClass = sizes[props.buttonSize] || sizes.base;
  return `${colorClass} ${sizeClass}`;
});
</script>

<template>
  <Link
    v-if="href"
    :href="href"
    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 disabled:pointer-events-none disabled:opacity-50 shadow h-9 px-4 py-2"
    :class="buttonClass"
    :type="buttonActionType"
  >
    <slot></slot>
  </Link>

  <button
    v-else
    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 disabled:pointer-events-none disabled:opacity-50 shadow h-9 px-4 py-2"
    :class="buttonClass"
    :type="buttonActionType"
  >
    <slot></slot>
  </button>
</template>