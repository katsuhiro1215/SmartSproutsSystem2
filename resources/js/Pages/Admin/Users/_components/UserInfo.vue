<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  user: Object,
});
</script>

<template>
  <div class="flex justify-between items-center border-b-2 border-b-orange-400">
    <h3 class="text-lg p-3">ユーザー</h3>
    <PrimaryButton
      :href="route('admin.user.edit', user.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">ユーザー名</dt>
    <dd class="w-full lg:w-3/4">{{ user.username }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">メールアドレス</dt>
    <dd class="w-full lg:w-3/4">{{ user.email }}</dd>
  </dl>
</template>