<script setup>
import { ref, computed } from "vue";
import dayjs from "dayjs";
import axios from "axios";
// Components
import SimpleTable from "@/Components/Tables/SimpleTable.vue";
import Badge from "@/Components/Badge.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import InputError from "@/Components/Forms/InputError.vue";

// 状態管理

// モーダルの状態
const isModalOpen = ref(false); // スケジュール登録モーダルの表示状態
const isSubModalOpen = ref(false); // 時間範囲のモーダルの表示状態
const isEditing = ref(false); // 編集モードかどうか
const editingScheduleId = ref(null); // 編集対象のスケジュールID
// スケジュールの状態
const StoreStartTime = ref(""); // 開始時刻
const StoreEndTime = ref(""); // 終了時刻
const status = ref(true); // ステータス（営業日 or 休業日）
const note = ref(""); // メモ

// Props
const props = defineProps({
  schedules: Array, // 統一されたスケジュールデータ
  storeId: Number, // 店舗ID
});

// スケジュールを日付ごとにマッピング
const scheduleMap = computed(() => {
  const map = {};
  props.schedules.forEach((schedule) => {
    const dateKey = dayjs(schedule.business_date).format("YYYY-MM-DD");
    if (!map[dateKey]) {
      map[dateKey] = [];
    }
    map[dateKey].push(schedule);
  });
  return map;
});

// 営業時間内かどうかを判定する関数
const isInSchedule = (date, time) => {
  const dateKey = dayjs(date).format("YYYY-MM-DD");
  const schedules = scheduleMap.value[dateKey] || [];

  return schedules.some((schedule) => {
    // 休業日の場合
    if (schedule.status === false) {
      return true; // 休業日として扱う
    }

    // 営業日の場合
    if (!schedule.start_time || !schedule.end_time) {
      return false; // 時間がない場合はスキップ
    }

    const startTime = parseInt(schedule.start_time.split(":")[0], 10); // 開始時刻
    const endTime = parseInt(schedule.end_time.split(":")[0], 10); // 終了時刻
    const currentTime = parseInt(time.split(":")[0], 10); // 現在の時刻

    return currentTime >= startTime && currentTime < endTime;
  });
};

// 休業日かどうかを判定する関数
const isHoliday = (date) => {
  const dateKey = dayjs(date).format("YYYY-MM-DD");
  const schedules = scheduleMap.value[dateKey] || [];

  return schedules.some((schedule) => schedule.status === false);
};

// 現在の年を取得
const currentDate = ref(dayjs());

// 今週の開始日と終了日を計算
const startOfWeek = computed(() => currentDate.value.startOf("week"));
const endOfWeek = computed(() => currentDate.value.endOf("week"));

// カレンダー用の日付を生成
const calendarDates = computed(() => {
  const dates = [];
  let date = startOfWeek.value; // 今週の最初の日曜日
  const end = endOfWeek.value; // 今週の最後の土曜日

  while (date.isBefore(end) || date.isSame(end)) {
    dates.push(date);
    date = date.add(1, "day");
  }

  return dates;
});

// 曜日リスト（日曜日を先頭に）
const weekdays = ["日", "月", "火", "水", "木", "金", "土"];

// 時刻リスト（デフォルトは7:00～22:00、30分間隔）
const startTime = ref(7); // 開始時刻
const endTime = ref(22); // 終了時刻
const timeSlots = computed(() => {
  const slots = [];
  for (let hour = startTime.value; hour < endTime.value; hour++) {
    slots.push(`${hour}:00`);
    slots.push(`${hour}:30`);
  }
  return slots;
});

// モーダル関連

// モーダルを開く
const openModal = (date) => {
  selectedDate.value = date;
  isModalOpen.value = true;
};

// 編集モードのフラグ
const openEditModal = (schedule) => {
  selectedDate.value = dayjs(schedule.business_date); // 日付を設定
  StoreStartTime.value = schedule.start_time; // 開始時刻を設定
  StoreEndTime.value = schedule.end_time; // 終了時刻を設定
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
      `/api/store/schedules?store_id=${props.storeId}`
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
      await axios.put(`/api/store/schedules/${editingScheduleId.value}`, {
        store_id: props.storeId,
        business_date: selectedDate.value.format("YYYY-MM-DD"),
        day_of_week: dayOfWeek,
        start_time: startTime.value,
        end_time: endTime.value,
        status: status.value,
        note: note.value,
      });
      alert("スケジュールが更新されました！");
    } else {
      // 新規登録処理
      await axios.post("/api/store/schedules", {
        store_id: props.storeId,
        business_date: selectedDate.value.format("YYYY-MM-DD"),
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

// ローカルストレージに保存
const saveTimeRangeToLocalStorage = () => {
  localStorage.setItem("startTime", startTime.value);
  localStorage.setItem("endTime", endTime.value);
  alert("時間範囲が保存されました。");
  isModalOpen.value = false; // モーダルを閉じる
};

// ローカルストレージから読み込み
const loadTimeRangeFromLocalStorage = () => {
  const savedStartTime = localStorage.getItem("startTime");
  const savedEndTime = localStorage.getItem("endTime");
  if (savedStartTime && savedEndTime) {
    startTime.value = parseInt(savedStartTime, 10);
    endTime.value = parseInt(savedEndTime, 10);
  }
};

// ページ読み込み時に設定をロード
loadTimeRangeFromLocalStorage();

// 前週・次週への移動
const goToPreviousPeriod = () => {
  currentDate.value = currentDate.value.subtract(1, "week");
};
const goToNextPeriod = () => {
  currentDate.value = currentDate.value.add(1, "week");
};
</script>

<template>
  <div>
    <header class="flex justify-between items-center mb-4">
      <PrimaryButton @click="goToPreviousPeriod" buttonType="secondary">
        Prev
      </PrimaryButton>
      <h2 class="text-xl font-bold">{{ currentDate.format("YYYY年MM月") }}</h2>
      <PrimaryButton @click="goToNextPeriod" buttonType="secondary">
        Next
      </PrimaryButton>
    </header>
    <div class="flex justify-end mb-4">
      <PrimaryButton @click="isSubModalOpen = true" buttonType="primary">
        時間範囲を設定
      </PrimaryButton>
    </div>
    <!-- モーダルウィンドウ -->
    <div
      v-if="isSubModalOpen"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center"
    >
      <div class="bg-white p-6 rounded shadow-lg w-96 dark:bg-gray-800">
        <h2 class="text-lg font-bold mb-4">時間範囲を設定してください</h2>
        <div class="mb-4">
          <InputLabel for="start-time"> 開始時刻 </InputLabel>
          <select
            id="start-time"
            v-model="startTime"
            class="mt-1 block w-full border-gray-300 rounded-md"
          >
            <option v-for="hour in 24" :key="hour" :value="hour">
              {{ hour }}:00
            </option>
          </select>
        </div>
        <div class="mb-4">
          <InputLabel for="end-time"> 終了時刻 </InputLabel>
          <select
            id="end-time"
            v-model="endTime"
            class="mt-1 block w-full border-gray-300 rounded-md"
          >
            <option v-for="hour in 24" :key="hour" :value="hour">
              {{ hour }}:00
            </option>
          </select>
        </div>
        <div class="flex justify-end gap-4">
          <PrimaryButton @click="isSubModalOpen = false" buttonType="secondary">
            キャンセル
          </PrimaryButton>
          <PrimaryButton
            @click="saveTimeRangeToLocalStorage"
            buttonType="primary"
          >
            保存
          </PrimaryButton>
        </div>
      </div>
    </div>
    <!-- カレンダー -->
    <SimpleTable>
      <template #header>
        <tr>
          <th class="border border-gray-300 p-2 text-center">時間</th>
          <th
            v-for="(date, index) in calendarDates"
            :key="index"
            class="border border-gray-300 p-2 text-center"
          >
            {{ weekdays[date.day()] }}<br />
            {{ date.format("MM/DD") }}
          </th>
        </tr>
        <tr>
          <th class="border border-gray-300 p-2 text-center">ステータス</th>
          <th
            v-for="(date, index) in calendarDates"
            :key="index"
            class="border border-gray-300 p-2 text-center"
          >
            <Badge v-if="isHoliday(date)" type="danger"> 休業日 </Badge>
            <Badge v-else-if="isInSchedule(date, timeSlots[0])" type="success">
              営業中
            </Badge>
            <Badge v-else type="danger"> 営業外 </Badge>
          </th>
        </tr>
        <tr>
          <th class="border border-gray-300 p-2 text-center">Action</th>
          <th
            v-for="(date, index) in calendarDates"
            :key="index"
            class="border border-gray-300 p-2 text-center"
          >
            <PrimaryButton
              v-if="scheduleMap[date.format('YYYY-MM-DD')]"
              @click="openEditModal(scheduleMap[date.format('YYYY-MM-DD')])"
              buttonType="warning"
            >
              編集
            </PrimaryButton>
            <PrimaryButton
              v-if="!scheduleMap[date.format('YYYY-MM-DD')]"
              @click="openModal(date)"
              buttonType="primary"
            >
              未登録
            </PrimaryButton>
          </th>
        </tr>
      </template>
      <template #body>
        <tr v-for="(time, index) in timeSlots" :key="time">
          <!-- 時刻 -->
          <td class="border border-gray-300 p-2 text-center h-16">
            <!-- 1時間おきに時刻を表示 -->
            <span v-if="index % 2 === 0">{{ time }}</span>
          </td>
          <!-- 各曜日のセル -->
          <td
            v-for="(date, index) in calendarDates"
            :key="index"
            class="border border-gray-300 p-2 text-center h-16"
            :class="{
              'bg-blue-400': isInSchedule(date, time), // 営業時間内
              'bg-gray-400': isHoliday(date), // 休業日
            }"
          ></td>
        </tr>
      </template>
    </SimpleTable>

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
              v-model="StoreStartTime"
              type="time"
              class="mt-1 block w-full"
            />
          </FormGroup>
          <FormGroup>
            <InputLabel for="end-time"> 終了時刻 </InputLabel>
            <TextInput
              id="end-time"
              v-model="StoreEndTime"
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