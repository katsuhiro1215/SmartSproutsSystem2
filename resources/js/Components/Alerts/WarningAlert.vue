<script setup>
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

// Props
const props = defineProps({
  isVisible: Boolean,
  message: String,
});
// Emit
const emit = defineEmits(["confirm"]);
// Confirm
const confirm = () => {
  emit("confirm");
};
</script>

<template>
  <transition
    enter-active-class="transition ease-out duration-300"
    enter-from-class="opacity-0 transform translate-y-4"
    enter-to-class="opacity-100 transform translate-y-0"
    leave-active-class="transition ease-in duration-200"
    leave-from-class="opacity-100 transform translate-y-0"
    leave-to-class="opacity-0 transform translate-y-4"
  >
    <div
      v-if="isVisible"
      class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center z-10"
      @click.self="confirm"
    >
      <div
        v-if="isVisible"
        class="min-w-80 md:w-2/3 lg:w-1/2 flex items-center justify-center flex-col bg-white border-8 border-yellow-400 px-5 py-20 rounded-md shadow-lg z-20 text-center dark:bg-gray-800 dark:text-white"
      >
        <h3 class="text-xl md:text-2xl font-bold mb-2">
          これ以上は追加できません。
        </h3>
        <div class="p-4">
          <p class="md:text-lg">{{ message }}</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
          <PrimaryButton
            @click="confirm"
            buttonActionType="button"
            buttonType="secondary"
            >確認</PrimaryButton
          >
        </div>
      </div>
    </div>
  </transition>
</template>