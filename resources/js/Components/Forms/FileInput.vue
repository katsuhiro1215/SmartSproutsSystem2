<script setup>
import { ref } from 'vue';

</script>

<template>
    <label for=file >
      <span class="block text-white bg-orange-300 text-xl px-0 py-8 text-center transition-all cursor-pointer hover:bg-black">ファイルを選択</span>
      <input id=”file” type=”file” class="relative mt-2 mr-0 mb-0 -ml-3 before:cotent-‘選択されたファイルなし’ before:absolute before:bg-orange-50 before:w-40 text-right" @change="handleFileChange" />
    </label>
</template>