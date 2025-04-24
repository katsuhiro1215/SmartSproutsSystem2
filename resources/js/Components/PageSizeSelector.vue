<script setup>
import { ref, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

const pageSize = ref(20);
const pageSizes = [10, 20, 30, 40, 50];

function changePageSize() {
  router.get(window.location.pathname, { per_page: pageSize.value }, { preserveState: true });
}

// ページサイズが変更されたときに自動的にページをリロードする
watch(pageSize, () => {
  changePageSize();
});

// 初期値を URL パラメータから取得
onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search);
  const perPage = urlParams.get('per_page');
  if (perPage) {
    pageSize.value = parseInt(perPage, 10);
  }
});
</script>

<template>
  <select v-model="pageSize" @change="changePageSize" class="flex h-9 w-16 rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-600 focus-visible:outline-none focus-visible:ring-1 disabled:cursor-not-allowed disabled:opacity-50">
    <option v-for="size in pageSizes" :key="size" :value="size">
      {{ size }}
    </option>
  </select>
</template>
