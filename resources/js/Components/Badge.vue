<script setup>
import { computed, defineProps } from 'vue'

const props = defineProps({
  type: {
    type: String,
    default: 'default',
    validator: (value) =>
      ['default', 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'pink', 'orange', 'light', 'dark'].includes(value),
  },
})

// Color styles
const badgeStyles = {
  default: 'bg-gray-600 text-white hover:bg-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700',
  primary: 'bg-indigo-600 text-white hover:bg-indigo-700 dark:bg-indigo-800 dark:text-white dark:hover:bg-indigo-700',
  secondary: 'bg-gray-600 text-white hover:bg-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700',
  success: 'bg-green-600 text-white hover:bg-green-700 dark:bg-green-800 dark:text-white dark:hover:bg-green-700',
  danger: 'bg-red-600 text-white hover:bg-red-700 dark:bg-red-800 dark:text-white dark:hover:bg-red-700',
  warning: 'bg-yellow-600 text-white hover:bg-yellow-700 dark:bg-yellow-800 dark:text-white dark:hover:bg-yellow-700',
  info: 'bg-blue-600 text-white hover:bg-blue-700 dark:bg-blue-800 dark:text-white dark:hover:bg-blue-700',
  pink: 'bg-pink-600 text-white hover:bg-pink-700 dark:bg-pink-800 dark:text-white dark:hover:bg-pink-700',
  orange: 'bg-orange-600 text-white hover:bg-orange-700 dark:bg-orange-800 dark:text-white dark:hover:bg-orange-700',
  light: 'bg-gray-100 text-gray-800 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-gray-200',
  dark: 'bg-gray-800 text-white hover:bg-gray-900 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-900',
}

// Compute class with default fallback
const computedClass = computed(() => badgeStyles[props.type] || badgeStyles.default);
</script>

<template>
  <span
    :class="['inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2', computedClass]"
    role="status"
    aria-label="Badge"
  >
    <slot />
  </span>
</template>
