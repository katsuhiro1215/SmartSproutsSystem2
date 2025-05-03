<script setup>
import { defineProps } from "vue";
// Components
import Separator from "@/Components/Separator.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({
  students: Object,
});
</script>

<template>
  <div class="flex justify-between items-center border-b-2 border-b-orange-400">
    <h3 class="text-lg p-3">生徒</h3>
  </div>
  <div v-if="students.length > 0">
    <div v-for="(student, index) in students" :key="index">
      <div class="flex justify-between items-center">
        <h4>生徒 - {{ index + 1 }}</h4>
        <PrimaryButton
          :href="route('admin.student.show', student.id)"
          buttonType="info"
          ><EyeOutline class="mr-2" />詳細</PrimaryButton
        >
      </div>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">名前</dt>
        <dd class="w-full lg:w-3/4">{{ student.full_name }}</dd>
      </dl>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">フリガナ</dt>
        <dd class="w-full lg:w-3/4">
          {{ student.full_name_kana }}
        </dd>
      </dl>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">生年月日</dt>
        <dd class="w-full lg:w-3/4">{{ student.birth }}</dd>
      </dl>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">年齢</dt>
        <dd class="w-full lg:w-3/4">{{ student.age }} 歳</dd>
      </dl>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">性別</dt>
        <dd class="w-full lg:w-3/4">{{ student.gender }}</dd>
      </dl>
      <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
        <dt class="w-full lg:w-1/4">携帯番号</dt>
        <dd class="w-full lg:w-3/4">
          {{ student.mobile_number }}
        </dd>
      </dl>
      <Separator />
    </div>
  </div>
  <div v-else>
    <p>生徒を登録してください。</p>
  </div>
</template>