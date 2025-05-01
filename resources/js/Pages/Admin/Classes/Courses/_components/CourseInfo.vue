<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  course: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>コース</h3>
    <PrimaryButton
      :href="route('admin.course.edit', course.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">レッスン名</dt>
    <dd class="w-full lg:w-3/4">{{ course.lesson_id }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">コースカテゴリー名</dt>
    <dd class="w-full lg:w-3/4">{{ course.course_category_id }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">コース名</dt>
    <dd class="w-full lg:w-3/4">{{ course.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">コース内容</dt>
    <dd class="w-full lg:w-3/4">{{ course.description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">コースカテゴリーステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="course.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="course.status == '0'" type="danger"> CLOSE </Badge>
      <Badge v-if="course.status == null" type="warning">
        PENDING
      </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">設立日</dt>
    <dd class="w-full lg:w-3/4">
      {{ course.established_date }}
    </dd>
  </dl>
</template>