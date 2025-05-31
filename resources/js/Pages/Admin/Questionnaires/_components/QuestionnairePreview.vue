<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";

const props = defineProps({
  form: Object,
});

const showModal = ref(false);
const openModal = () => {
  showModal.value = true;
};

// モーダルを閉じるための関数
const closeModal = () => {
  showModal.value = false;
};
</script>

<template>
  <!-- hoverのときは少し薄く -->
  <div class="p-4 border shadow hover:shadow-lg transition-shadow duration-200 cursor-pointer hover:opacity-50">
    <div class="preview-content" @click="openModal">
      <img
        v-if="form.questionnaire_photo_path"
        :src="form.questionnaire_photo_path"
        alt="アンケートの画像"
        class="w-full h-32 object-cover mb-2 rounded"
      />
      <h1 class="font-bold text-sm mb-2">{{ form.name }}</h1>
      <p class="text-xs mb-2">{{ form.main_description }}</p>
      <p class="text-xs mb-2">{{ form.sub_description }}</p>
      <p class="text-xs mb-2">{{ form.annotation }}</p>
    </div>
    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h1 class="font-bold text-2xl mb-2">{{ form.name }}</h1>
        <p class="mb-2">{{ form.main_description }}</p>
        <p class="mb-2">{{ form.sub_description }}</p>
        <p class="mb-2">{{ form.annotation }}</p>
        <!-- 他の項目も拡大表示 -->
        <SecondaryButton @click="closeModal"> 閉じる </SecondaryButton>
      </div>
    </Modal>
  </div>
</template>