<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  lesson: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>レッスン</h3>
    <PrimaryButton
      :href="route('admin.lesson.edit', lesson.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">店舗名</dt>
    <dd class="w-full lg:w-3/4">{{ lesson.store_id }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">レッスン名</dt>
    <dd class="w-full lg:w-3/4">{{ lesson.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">レッスン内容</dt>
    <dd class="w-full lg:w-3/4">{{ lesson.description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">レッスンステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="lesson.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="lesson.status == '0'" type="danger"> CLOSE </Badge>
      <Badge v-if="lesson.status == null" type="warning"> PENDING </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">設立日</dt>
    <dd class="w-full lg:w-3/4">
      {{ lesson.established_date }}
    </dd>
  </dl>
</template>