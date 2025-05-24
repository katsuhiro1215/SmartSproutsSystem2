<script setup>
import { ref } from 'vue';
import dayjs from "dayjs";
// Components - Buttons
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';

// 現在の年を取得
const currentYear = ref(dayjs().year());

// 各月の名前を定義
const months = [
  "1月", "2月", "3月", "4月", "5月", "6月",
  "7月", "8月", "9月", "10月", "11月", "12月",
];

// 前年・翌年への移動
const goToPreviousYear = () => {
  currentYear.value -= 1;
};

const goToNextYear = () => {
  currentYear.value += 1;
};
</script>
<!-- 年間カレンダー -->
<template>
  <div>
    <!-- 年の切り替え -->
    <header class="flex justify-between items-center mb-4">
      <PrimaryButton @click="goToPreviousYear" buttonType="secondary">
        前年
      </PrimaryButton>
      <h2 class="text-xl font-bold">{{ currentYear }}年</h2>
      <PrimaryButton @click="goToNextYear" buttonType="secondary">
        翌年
      </PrimaryButton>
    </header>
        <!-- 年間カレンダー -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        v-for="(month, index) in months"
        :key="index"
        class="relative border p-5 bg-white dark:bg-gray-800 shadow-md rounded-lg hover:shadow-lg transition-shadow duration-300"
      >
        <!-- 月名 -->
        <p class="text-lg font-bold mb-2">{{ month }}</p>

        <!-- スケジュールの表示スペース -->
        <div class="text-sm text-gray-600">
          <!-- スケジュールがあれば表示 -->
          <p v-if="schedules && schedules[index]">
            {{ schedules[index].length }} 件のスケジュール
          </p>
          <!-- スケジュールがない場合 -->
          <p v-else>スケジュールなし</p>
        </div>
      </div>
    </div>
  </div>
</template>
