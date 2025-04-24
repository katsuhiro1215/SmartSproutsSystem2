<script setup>
import { computed, defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  imgSrc: {
    type: String,
    default: null,
  },
  icon: {
    type: String,
    default: null,
  },
  label: {
    type: String,
    required: true,
  },
  buttonType: {
    type: String,
    default: 'default',
  },
});

//Color
const colors = {
  default: {
    class: 'text-white bg-black border border-transparent hover:bg-black/90 active:bg-black/90',
  },
  primary: {
    class:
      'text-white bg-blue-400 border border-transparent hover:bg-blue-400/90 active:bg-blue-400/90',
  },
  secondary: {
    class:
      'text-white bg-gray-400 border border-transparent hover:bg-gray-400/90 active:bg-gray-400/90',
  },
  danger: {
    class:
      'text-white bg-red-400 border border-transparent hover:bg-red-400/90 active:bg-red-400/90',
  },
  warning: {
    class:
      'text-white bg-yellow-400 border border-transparent hover:bg-yellow-400/90 active:bg-yellow-400/90',
  },
  success: {
    class:
      'text-white bg-green-400 border border-transparent hover:bg-green-400/90 active:bg-green-400/90',
  },
  info: {
    class:
      'text-white bg-sky-400 border border-transparent hover:bg-sky-400/90 active:bg-sky-400/90',
  },
  orange: {
    class:
      'text-white bg-orange-400 border border-transparent hover:bg-orange-400/90 active:bg-orange-400/90',
  },
  pink: {
    class:
      'text-white bg-pink-400 border border-transparent hover:bg-pink-400/90 active:bg-pink-400/90',
  },
  indigo: {
    class:
      'text-white bg-indigo-400 border border-transparent hover:bg-indigo-400/90 active:bg-indigo-400/90',
  },
  emerald: {
    class:
      'text-white bg-emerald-400 border border-transparent hover:bg-emerald-400/90 active:bg-emerald-400/90',
  },
  light: {
    class:
      'text-gray-900 bg-gray-100 border border-transparent hover:bg-gray-200 active:bg-gray-200',
  },
  dark: {
    class:
      'text-white bg-gray-800 border border-transparent hover:bg-gray-800/90 active:bg-gray-800/90',
  },
  ghost: {
    class:
      'text-gray-900 bg-transparent border border-transparent hover:bg-transparent hover:border-gray-100 active:bg-gray-100',
  },
};

const buttonClass = computed(() => colors[props.buttonType].class);
</script>

<template>
  <Link
    :href="href"
    class="flex flex-col justify-center items-center gap-2 whitespace-nowrap rounded-md size-16 text-xs font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 disabled:pointer-events-none disabled:opacity-50 shadow p-4 sm:size-20 sm:text-sm lg:size-24 lg:text-base"
    :class="buttonClass"
  >
    <template v-if="imgSrc">
      <img :src="imgSrc" alt="" class="size-6 lg:size-8" />
    </template>
    <template v-if="icon">
      <svg :class="icon" class="size-5 sm:size-6 lg:size-8" />
    </template>
    <span>{{ label }}</span>
  </Link>
</template>