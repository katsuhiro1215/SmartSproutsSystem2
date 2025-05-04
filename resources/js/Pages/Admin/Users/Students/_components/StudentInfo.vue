<script setup>
import { defineProps } from "vue";
// Components
import Separator from "@/Components/Separator.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({
  student: Object,
});
</script>

<template>
  <div class="flex justify-between items-center border-b-2 border-b-orange-400">
    <h3 class="text-lg p-3">生徒</h3>
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
</template>