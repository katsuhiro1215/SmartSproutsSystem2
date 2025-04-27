<script setup>
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";

// Props
const props = defineProps({
  isVisible: Boolean,
  message: String,
});
// Emit
const emit = defineEmits(["confirm", "cancel"]);

// Confirm
const confirm = () => {
  emit("confirm");
};
// Cancel
const cancel = () => {
  emit("cancel");
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
      @click.self="cancel"
    >
      <div
        v-if="isVisible"
        class="min-w-80 md:w-2/3 lg:w-1/2 flex items-center justify-center flex-col bg-white border-8 border-red-400 p-5 rounded-md shadow-lg z-20 text-center"
      >
        <h3 class="text-xl md:text-2xl font-bold mb-2">
          こちらは管理者の編集画面です。編集しても良いですか？
        </h3>
        <h4 class="text-lg md:text-xl">この操作は取り消せません。</h4>
        <div class="p-4">
          <p class="md:text-lg">{{ message }}</p>
        </div>
        <div class="flex flex-col md:flex-row gap-4">
          <PrimaryButton
            @click="cancel"
            buttonActionType="button"
            buttonType="secondary"
            >いいえ</PrimaryButton
          >
          <PrimaryButton @click="confirm" buttonActionType="button" buttonType="danger"
            >はい</PrimaryButton
          >
        </div>
      </div>
    </div>
  </transition>
</template>