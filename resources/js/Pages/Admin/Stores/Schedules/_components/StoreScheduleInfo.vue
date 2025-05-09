<script setup>
import { defineProps } from "vue";
// Components
import Badge from "@/Components/Badge.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  storeSchedule: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>店舗スケジュール</h3>
    <PrimaryButton
      :href="route('admin.storeSchedule.edit', storeSchedule.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">店舗名</dt>
    <dd class="w-full lg:w-3/4">{{ storeSchedule.store.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">営業日</dt>
    <dd class="w-full lg:w-3/4">{{ storeSchedule.business_date }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">曜日</dt>
    <dd class="w-full lg:w-3/4">{{ storeSchedule.day_of_week }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">営業時間</dt>
    <dd class="w-full lg:w-3/4">
      {{ storeSchedule.start_time }} - {{ storeSchedule.end_time }}
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">ステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="storeSchedule.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="storeSchedule.status == '0'" type="danger"> CLOSE </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">Note</dt>
    <dd class="w-full lg:w-3/4">{{ storeSchedule.note }}</dd>
  </dl>
</template>