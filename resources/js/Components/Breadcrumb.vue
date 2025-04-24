<script setup>
import { Link } from "@inertiajs/vue3";
import { mdiChevronRight } from "@mdi/js";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <nav aria-label="breadcrumb" class="p-2">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      <li
        v-for="(item, index) in items"
        :key="index"
        class="inline-flex items-center"
      >
        <template v-if="index !== items.length - 1">
          <Link
            :href="item.url"
            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400"
          >
            <span>{{ item.name }}</span>
          </Link>
          <!-- アイコンを挿入 -->
          <svg
            class="h-5 w-5 mx-2 text-gray-400 dark:text-gray-500"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path :d="mdiChevronRight" />
          </svg>
        </template>
        <template v-else>
          <!-- 最後の項目にはアイコンを表示しない -->
          <span
            class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400"
          >
            {{ item.name }}
          </span>
        </template>
      </li>
    </ol>
  </nav>
</template>
