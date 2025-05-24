<script setup>
import { ref, computed } from "vue";
import dayjs from "dayjs";
import isSameOrAfter from "dayjs/plugin/isSameOrAfter";
import isSameOrBefore from "dayjs/plugin/isSameOrBefore";
import axios from "axios";
// Components
import SimpleTable from "@/Components/Tables/SimpleTable.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import InputError from "@/Components/Forms/InputError.vue";

// Plugins
dayjs.extend(isSameOrAfter);
dayjs.extend(isSameOrBefore);

// 状態管理

// 表示モードの状態
const viewMode = ref("calendar"); // "calendar" または "list"
// 日付関連
const currentDate = ref(dayjs()); // 現在の日付を取得
const selectedDate = ref(null); // 選択された日付
// モーダルの状態
const isModalOpen = ref(false); // モーダルの表示状態
const isEditing = ref(false); // 編集モードかどうか
const editingScheduleId = ref(null); // 編集対象のスケジュールID
// スケジュールの状態
const startTime = ref(""); // 開始時刻
const endTime = ref(""); // 終了時刻
const status = ref(true); // ステータス（営業日 or 休業日）
const note = ref(""); // メモ

// Props
const props = defineProps({
  schedules: Array, // 統一されたスケジュールデータ
  courseId: Number, // コースID
});

// 計算プロパティ

// 今月の開始日と終了日を計算
const startOfMonth = computed(() => currentDate.value.startOf("month"));
const endOfMonth = computed(() => currentDate.value.endOf("month"));

// カレンダー用の日付を生成
const calendarDates = computed(() => {
  const dates = [];
  let date = startOfMonth.value.startOf("week"); // 月の最初の週の日曜日
  const end = endOfMonth.value.endOf("week"); // 月の最後の週の土曜日

  while (date.isBefore(end) || date.isSame(end)) {
    dates.push(date);
    date = date.add(1, "day");
  }

  return dates;
});

// 曜日リスト（日曜日を先頭に）
const weekdays = ["日", "月", "火", "水", "木", "金", "土"];

// スケジュールを日付ごとにマッピング
const scheduleMap = computed(() => {
  const map = {};
  props.schedules.forEach((schedule) => {
    const dateKey = dayjs(schedule.course_date).format("YYYY-MM-DD");
    if (!map[dateKey]) {
      map[dateKey] = [];
    }
    map[dateKey].push(schedule);
  });
  return map;
});

// フィルタリングされたスケジュールを取得
const filteredSchedules = computed(() => {
  const start = startOfMonth.value;
  const end = endOfMonth.value;

  return props.schedules.filter((schedule) => {
    const date = dayjs(schedule.business_date);
    return date.isSameOrAfter(start) && date.isSameOrBefore(end);
  });
});

// ユーティリティ

// 曜日を取得する関数
const getDayOfWeek = (date) => {
  const days = [
    "日曜日",
    "月曜日",
    "火曜日",
    "水曜日",
    "木曜日",
    "金曜日",
    "土曜日",
  ];
  return days[dayjs(date).day()];
};

// 指定された日付のスケジュールを取得
const getSchedulesForDate = (date) => {
  const dateKey = dayjs(date).format("YYYY-MM-DD");
  return scheduleMap.value[dateKey] || [];
};

// 時間をフォーマットする関数
const formatTime = (time) => {
  if (!time) return ""; // 時間がない場合は空文字を返す
  return dayjs(`1970-01-01 ${time}`).format("HH:mm");
};

// モーダル関連

// モーダルを開く
const openModal = (date) => {
  selectedDate.value = date;
  isModalOpen.value = true;
};

// 編集モードのフラグ
const openEditModal = (schedule) => {
  selectedDate.value = dayjs(schedule.business_date); // 日付を設定
  startTime.value = schedule.start_time; // 開始時刻を設定
  endTime.value = schedule.end_time; // 終了時刻を設定
  status.value = Boolean(schedule.status); // ステータスを設定
  note.value = schedule.note; // メモを設定
  isModalOpen.value = true; // モーダルを開く
  isEditing.value = true; // 編集モードに切り替え
  editingScheduleId.value = schedule.id; // 編集対象のスケジュールIDを設定
};

// モーダルを閉じる
const closeModal = () => {
  isModalOpen.value = false;
  startTime.value = "";
  endTime.value = "";
  status.value = true;
  isEditing.value = false; // 編集モードをリセット
  editingScheduleId.value = null; // 編集対象IDをリセット
};

// ステータスオプション
const statusOptions = [
  { label: "営業日", value: true },
  { label: "休業日", value: false },
];

// ブラウザを更新する
const fetchSchedules = async () => {
  try {
    const response = await axios.get(
      `/api/course/schedules?course_id=${props.courseId}`
    );
    console.log("スケジュール取得レスポンス:", response.data);
    props.schedules.splice(
      0,
      props.schedules.length,
      ...response.data.schedules
    );
  } catch (error) {
    console.error("スケジュールの取得に失敗しました:", error);

    throw error;
  }
};

// スケジュールを登録する
const saveSchedule = async () => {
  try {
    const dayOfWeek = getDayOfWeek(selectedDate.value.format("YYYY-MM-DD"));

    if (isEditing.value) {
      // 更新処理
      await axios.put(`/api/course/schedules/${editingScheduleId.value}`, {
        course_id: props.courseId,
        course_date: selectedDate.value.format("YYYY-MM-DD"),
        day_of_week: dayOfWeek,
        start_time: startTime.value,
        end_time: endTime.value,
        status: status.value,
        note: note.value,
      });
      alert("スケジュールが更新されました！");
    } else {
      // 新規登録処理
      await axios.post("/api/course/schedules", {
        course_id: props.courseId,
        course_date: selectedDate.value.format("YYYY-MM-DD"),
        day_of_week: dayOfWeek,
        start_time: startTime.value,
        end_time: endTime.value,
        status: status.value,
        note: note.value,
      });
      alert("スケジュールが登録されました！");
    }

    closeModal();
    await fetchSchedules();
  } catch (error) {
    console.error("スケジュールの登録に失敗しました:", error);
    alert("スケジュールの登録に失敗しました。");
  }
};

// ナビゲーション

// 前月・次月への移動
const goToPreviousPeriod = () => {
  if (viewMode.value === "calendar") {
    currentDate.value = currentDate.value.subtract(1, "month");
  } else if (viewMode.value === "list") {
    currentDate.value = currentDate.value.subtract(1, "month");
  }
};

const goToNextPeriod = () => {
  if (viewMode.value === "calendar") {
    currentDate.value = currentDate.value.add(1, "month");
  } else if (viewMode.value === "list") {
    currentDate.value = currentDate.value.add(1, "month");
  }
};
</script>

<template>
  <div class="w-full">
    <header class="flex justify-between items-center mb-4">
      <PrimaryButton @click="goToPreviousPeriod" buttonType="secondary">
        Prev
      </PrimaryButton>
      <h2 class="text-xl font-bold">{{ currentDate.format("YYYY年MM月") }}</h2>
      <PrimaryButton @click="goToNextPeriod" buttonType="secondary">
        Next
      </PrimaryButton>
    </header>
    <div class="flex justify-end gap-4 mb-4">
      <PrimaryButton
        :buttonType="viewMode === 'calendar' ? 'primary' : 'secondary'"
        @click="viewMode = 'calendar'"
      >
        カレンダー表示
      </PrimaryButton>
      <PrimaryButton
        :buttonType="viewMode === 'list' ? 'primary' : 'secondary'"
        @click="viewMode = 'list'"
      >
        リスト表示
      </PrimaryButton>
    </div>
    <!-- 今月のカレンダー -->
    <div v-if="viewMode === 'calendar'">
      <table class="table-fixed border-collapse border border-gray-300 w-full">
        <!-- 曜日 -->
        <thead>
          <tr>
            <th
              v-for="weekday in weekdays"
              :key="weekday"
              class="border border-gray-300 p-2 text-center"
            >
              {{ weekday }}
            </th>
          </tr>
        </thead>
        <!-- 日付 -->
        <tbody>
          <tr v-for="week in Math.ceil(calendarDates.length / 7)" :key="week">
            <td
              v-for="date in calendarDates.slice((week - 1) * 7, week * 7)"
              :key="date.format('YYYY-MM-DD')"
              class="border border-gray-300 text-center"
              :class="{
                'text-gray-400': date.month() !== currentDate.month(),
                'bg-emerald-500': date.isSame(dayjs(), 'day'),
              }"
            >
              <div class="border-b">{{ date.date() }}</div>
              <div class="mt-2 h-20">
                <!-- スケジュールを表示 -->
                <div
                  v-for="schedule in getSchedulesForDate(date)"
                  :key="schedule.id"
                  class="text-sm"
                >
                  <span v-if="schedule.start_time && schedule.end_time">
                    {{ formatTime(schedule.start_time) }} -
                    {{ formatTime(schedule.end_time) }}
                  </span>
                  <span v-else class="text-red-500">休</span>
                  <div class="w-full mt-2">
                    <PrimaryButton
                      @click="openEditModal(schedule)"
                      buttonType="warning"
                    >
                      編集
                    </PrimaryButton>
                  </div>
                </div>
                <PrimaryButton
                  v-if="!getSchedulesForDate(date).length"
                  @click="openModal(date)"
                  buttonType="secondary"
                >
                  未登録
                </PrimaryButton>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else-if="viewMode === 'list'">
      <SimpleTable>
        <template #header>
          <tr>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              SL
            </th>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              営業日
            </th>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              曜日
            </th>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              時刻
            </th>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              ステータス
            </th>
            <th
              class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
            >
              Action
            </th>
          </tr>
        </template>
        <template #body>
          <tr v-for="(schedule, index) in filteredSchedules" :key="schedule.id">
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ index + 1 }}
            </td>
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ dayjs(schedule.business_date).format("YYYY年MM月DD日") }}
            </td>
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ getDayOfWeek(schedule.business_date) }}
            </td>
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              {{ formatTime(schedule.start_time) }} -
              {{ formatTime(schedule.end_time) }}
            </td>
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              <span
                :class="{
                  'text-green-500': schedule.status,
                  'text-red-500': !schedule.status,
                }"
                >{{ schedule.status ? "営業日" : "休業日" }}</span
              >
            </td>
            <td
              class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
            >
              <div class="flex gap-4">
                <PrimaryButton
                  @click="openEditModal(schedule)"
                  buttonType="warning"
                >
                  編集
                </PrimaryButton>
                <DangerButton buttonType="danger" size="10">
                  削除
                </DangerButton>
              </div>
            </td>
          </tr>
        </template>
      </SimpleTable>
    </div>

    <!-- モーダルウィンドウ -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center"
    >
      <div class="bg-white p-6 rounded shadow-lg w-96 dark:bg-gray-800">
        <h2 class="text-lg font-bold mb-4">スケジュールを登録</h2>
        <div class="space-y-4">
          <FormGroup>
            <InputLabel for="start-time"> 開始時刻 </InputLabel>
            <TextInput
              id="start-time"
              v-model="startTime"
              type="time"
              class="mt-1 block w-full"
            />
          </FormGroup>
          <FormGroup>
            <InputLabel for="end-time"> 終了時刻 </InputLabel>
            <TextInput
              id="end-time"
              v-model="endTime"
              type="time"
              class="mt-1 block w-full"
            />
          </FormGroup>
          <FormGroup>
            <InputLabel for="end-time" required> 営業日 </InputLabel>
            <RadioInput
              id="status-open"
              v-model="status"
              :options="statusOptions"
              name="status"
            />
          </FormGroup>
          <FormGroup>
            <InputLabel for="note"> ノート </InputLabel>
            <TextArea
              id="note"
              class="mt-1 block w-full"
              v-model="note"
              name="note"
              placeholder="コースカテゴリー内容を入力してください(255文字以内)。"
            />
          </FormGroup>
          <div class="flex justify-end gap-4">
            <PrimaryButton @click="closeModal" buttonType="secondary">
              キャンセル
            </PrimaryButton>
            <PrimaryButton @click="saveSchedule" buttonType="primary">
              保存
            </PrimaryButton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>