<script setup>
import { defineProps } from "vue";
// Components
import Card from "@/Components/Cards/Card.vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
  >
    <Card v-for="(item, index) in items" :key="index">
      <template #content>
        <slot name="renderItem" :item="item" />
      </template>
    </Card>
  </div>
</template>
