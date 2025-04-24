<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  sortOptions: {
    type: Array,
    required: true,
  },
});

const sortOption = ref(props.sortOptions[0].value);

function changeSortOption() {
  const [sortField, sortOrder] = sortOption.value.split('_');
  router.get(window.location.pathname, { sort_field: sortField, sort_order: sortOrder }, { preserveState: true });
}

// 初期値を URL パラメータから取得
onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const sortField = urlParams.get('sort_field');
  const sortOrder = urlParams.get('sort_order');
  if (sortField && sortOrder) {
    sortOption.value = `${sortField}_${sortOrder}`;
  }
});
</script>

<template>
  <select v-model="sortOption" @change="changeSortOption" class="flex h-9 w-32 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-600 focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50">
    <option v-for="option in sortOptions" :key="option.value" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>