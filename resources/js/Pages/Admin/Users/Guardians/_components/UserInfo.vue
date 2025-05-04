<script setup>
import { defineProps } from "vue";
// Components
import Separator from "@/Components/Separator.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  users: Array,
});
</script>

<template>
  <div class="flex justify-between items-center border-b-2 border-b-orange-400">
    <h3 class="text-lg p-3">ユーザー</h3>
  </div>
  <div v-if="users.length > 0">
    <div v-for="(user, index) in users" :key="index">
      <div class="flex justify-between items-center">
        <h4>ユーザー - {{ index + 1 }}</h4>
        <PrimaryButton
          :href="route('admin.user.show', user.id)"
          buttonType="info"
          ><EyeOutline class="mr-2" />詳細</PrimaryButton
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
      <Separator />
    </div>
  </div>
  <div v-else>
    <p class="text-center">ユーザー情報はありません。</p>
  </div>
</template>