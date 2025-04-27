<script setup>
import { ref, computed } from 'vue';
import { onClickOutside } from '@vueuse/core';

const props = defineProps({
  modelValue: {
    type: [String, Number],
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  placeholder: {
    type: String,
    default: "選択してください。",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const selectedOption = computed(() => {
  return props.options.find(option => option.id === props.modelValue)?.name || props.placeholder;
});

// ドロップダウンの開閉を制御
const toggleDropdown = (event) => {
  event.preventDefault(); // デフォルトの動作を防ぐ
  if (!props.disabled) {
    isOpen.value = !isOpen.value;
  }
};

// オプションを選択する処理
const selectOption = (option) => {
  emit("update:modelValue", option.id);
  isOpen.value = false;
};

// ドロップダウン外をクリックしたときに閉じる
const dropdownRef = ref(null);
onClickOutside(dropdownRef, () => {
  isOpen.value = false;
});
</script>

<template>
  <div class="relative w-full">
    <!-- ボタン -->
    <button
      class="flex w-full items-center justify-between h-10 px-3 py-2 text-left rounded-md border shadow-sm bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:cursor-not-allowed disabled:bg-gray-200"
      @click="toggleDropdown"
      :disabled="disabled"
    >
      <span :class="{ 'text-gray-400': !props.modelValue }">
        {{ selectedOption }}
      </span>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5 text-gray-400"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M5.293 7.707a1 1 0 011.414 0L10 11.586l3.293-3.879a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
          clip-rule="evenodd"
        />
      </svg>
    </button>

    <!-- ドロップダウン -->
    <ul
      v-if="isOpen"
      class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-auto focus:outline-none"
    >
      <li
        v-for="option in props.options"
        :key="option.id"
        @click="selectOption(option)"
        class="px-4 py-2 hover:bg-indigo-100 cursor-pointer text-gray-700"
      >
        {{ option.name }}
      </li>
    </ul>
  </div>
</template>
