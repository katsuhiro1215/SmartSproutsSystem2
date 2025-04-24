<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  links: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <div v-if="props.links.length > 3">
    <div class="flex flex-wrap -mb-1 dark:text-white">
      <template v-for="(link, index) in props.links" :key="index">
        <div
          v-if="link.url === null"
          class="mr-1 mb-1 px-4 py-3"
          v-html="link.label"
        />
        <Link
          v-else
          class="mr-1 mb-1 px-4 py-3 border rounded hover:bg-blue-700"
          :class="{ 'bg-blue-700 text-white': link.active }"
          :href="link.url"
          ><span v-html="link.label"></span
        ></Link>
      </template>
    </div>
  </div>
</template>
