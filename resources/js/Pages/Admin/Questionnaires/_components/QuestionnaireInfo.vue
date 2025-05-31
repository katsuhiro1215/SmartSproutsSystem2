<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  questionnaire: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>アンケート設問</h3>
    <PrimaryButton
      :href="route('admin.questionnaire.edit', questionnaire.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">アンケート設問名</dt>
    <dd class="w-full lg:w-3/4">{{ questionnaire.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">アンケート設問内容</dt>
    <dd class="w-full lg:w-3/4">{{ questionnaire.main_description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">アンケート設問補足説明</dt>
    <dd class="w-full lg:w-3/4">{{ questionnaire.sub_description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">アンケート設問注釈</dt>
    <dd class="w-full lg:w-3/4">{{ questionnaire.annotation }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">アンケート設問ステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="questionnaire.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="questionnaire.status == '0'" type="danger"> CLOSE </Badge>
      <Badge v-if="questionnaire.status == null" type="warning"> PENDING </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">公開開始日時</dt>
    <dd class="w-full lg:w-3/4">
      {{ questionnaire.start_date }} - {{ questionnaire.start_time }}
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">イベント申込公開終了日時</dt>
    <dd class="w-full lg:w-3/4">
      {{ questionnaire.end_date }} - {{ questionnaire.end_time }}
    </dd>
  </dl>
</template>