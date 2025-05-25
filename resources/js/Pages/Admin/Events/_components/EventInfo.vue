<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  event: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>イベント</h3>
    <PrimaryButton
      :href="route('admin.event.edit', event.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント名</dt>
    <dd class="w-full lg:w-3/4">{{ event.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント内容</dt>
    <dd class="w-full lg:w-3/4">{{ event.description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">郵便番号</dt>
    <dd class="w-full lg:w-3/4">{{ event.postalcode }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">住所</dt>
    <dd class="w-full lg:w-3/4">{{ event.full_address }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">電話番号</dt>
    <dd class="w-full lg:w-3/4">{{ event.phone_number }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベントステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="event.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="event.status == '0'" type="danger"> CLOSE </Badge>
      <Badge v-if="event.status == null" type="warning"> PENDING </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント期間</dt>
    <dd class="w-full lg:w-3/4">
      {{ event.event_start_date }} - {{ event.event_end_date }}
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント申込開始日時</dt>
    <dd class="w-full lg:w-3/4">
      {{ event.application_start_date }} - {{ event.application_start_time }}
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント申込終了日時</dt>
    <dd class="w-full lg:w-3/4">
      {{ event.application_end_date }} - {{ event.application_end_time }}
    </dd>
  </dl>
</template>