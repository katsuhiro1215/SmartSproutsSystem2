<script setup>
import { defineProps, ref, onMounted } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import ButtonLink from "@/Components/Buttons/ButtonLink.vue";
// Components - Schedules
import YearlyCalendar from "../Schedules/_components/YearlyCalendar.vue";
import MonthlyCalendar from "../Schedules/_components/MonthlyCalendar.vue";
import WeeklyCalendar from "../Schedules/_components/WeeklyCalendar.vue";

const props = defineProps({
  course: Object,
});

const currentSchedules = ref([]);
const viewMode = ref("month");

// スケジュールを取得
const fetchSchedules = async () => {
  try {
    const response = await axios.get(
      route("admin.courseSchedule.fetchByCourse", { course: props.course.id })
    );
    currentSchedules.value = response.data.schedules;
  } catch (error) {
    console.error("スケジュールの取得に失敗しました:", error);
  }
};

// 表示モードを切り替える
const switchViewMode = (mode) => {
  viewMode.value = mode;
};

onMounted(() => {
  fetchSchedules();
});
</script>

<template>
  <div class="flex flex-col">
    <div class="flex justify-between items-center mb-4">
      <div class="relative flex justify-start items-center md:w-2/3 lg:w-1/3">
        <h2>{{ course.name }} のスケジュール</h2>
      </div>
      <div class="flex justify-end gap-4">
        <!-- 切り替えボタン -->
        <PrimaryButton
          @click="viewMode = 'year'"
          :class="{ 'bg-indigo-300': viewMode === 'year' }"
          buttonType="info"
        >
          <img src="/upload/year.png" alt="" width="20" height="20" />
        </PrimaryButton>
        <PrimaryButton
          @click="viewMode = 'month'"
          :class="{ 'bg-indigo-300': viewMode === 'month' }"
          buttonType="info"
        >
          <img src="/upload/month.png" alt="" width="20" height="20" />
        </PrimaryButton>
        <PrimaryButton
          @click="viewMode = 'week'"
          :class="{ 'bg-indigo-300': viewMode === 'week' }"
          buttonType="info"
        >
          <img src="/upload/week.png" alt="" width="20" height="20" />
        </PrimaryButton>
      </div>
    </div>
    <div class="flex flex-col lg:flex-row gap-4">
      <YearlyCalendar
        v-if="viewMode === 'year'"
        :schedules="currentSchedules"
      />
      <MonthlyCalendar
        v-if="viewMode === 'month'"
        :schedules="currentSchedules"
        :course-id="props.course.id"
      />
      <WeeklyCalendar
        v-if="viewMode === 'week'"
        :schedules="currentSchedules"
        :course-id="props.course.id"
      />
    </div>
  </div>
</template>