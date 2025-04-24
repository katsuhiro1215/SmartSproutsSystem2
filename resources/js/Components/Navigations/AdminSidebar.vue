<script setup>
import { defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
// Components - Buttons
import ButtonLink from '@/Components/Buttons/ButtonLink.vue';

const props = defineProps({
  menuItems: {
    type: Array,
    required: true,
  },
});

// 現在のルート名を取得
const currentRoute = usePage().props.route;
</script>

<template>
  <aside class="w-16 sm:w-20 lg:w-24 h-auto bg-white dark:bg-gray-800 shadow-md">
    <nav class="w-full">
      <ul class="w-full flex flex-col space-y-4">
        <li v-for="item in menuItems" :key="item.name" :class="{ 'bg-gray-200 dark:bg-gray-700': currentRoute === item.route }">
          <ButtonLink
            :href="item.params ? route(item.route, item.params) : route(item.route)"
            :imgSrc="item.icon"
            :label="item.label"
            buttonType="primary"
          />
        </li>
      </ul>
    </nav>
  </aside>
</template>