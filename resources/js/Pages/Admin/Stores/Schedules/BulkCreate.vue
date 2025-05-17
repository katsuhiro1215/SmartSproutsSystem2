<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";
// Libraries
import axios from "axios";
import dayjs from "dayjs";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import StoreLayout from "@/Components/SidebarLayouts/StoreLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import WarningAlert from "@/Components/Alerts/WarningAlert.vue";
import LoadingIndicator from "@/Components/Loadings/LoadingIndicator.vue";
import SimpleTable from "@/Components/Tables/SimpleTable.vue";
//  Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//  Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SelectInput from "@/Components/Forms/SelectInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Add from "vue-material-design-icons/Plus.vue";
import Remove from "vue-material-design-icons/Minus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
// import {
//   validateStoreId,
//   validateBusinessDate,
//   validateStartTime,
//   validateEndTime,
//   validateDayOfWeek,
//   validateStatus,
//   validateAllFields,
// } from "./_components/validation";
// import validationMessages from "@/Constants/validationMessages";

const props = defineProps({
  stores: Array,
});

const selectedStore = ref(null); // 選択された店舗ID
const selectedStoreName = computed(() => {
  const store = props.stores.find(
    (store) => store.value === selectedStore.value
  );
  return store ? store.label : "";
});

const year = ref(""); // 入力された年
const month = ref(""); // 入力された月
const schedules = ref([]); // スケジュールデータ

const isCardVisible = ref(false); // カードの表示状態

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// スケジュールを取得する関数
const fetchSchedules = async () => {
  if (!selectedStore.value || !year.value || !month.value) {
    alert("店舗と年月を入力してください。");
    return;
  }

  isLoading.value = true;
  loadingText.value = "スケジュールを取得中";

  try {
    const response = await axios.get(route("admin.storeSchedule.fetch"), {
      params: {
        store_id: selectedStore.value,
        year: year.value,
        month: month.value,
      },
    });

    const existingSchedules = response.data.schedules || {};
    schedules.value = generateSchedulesWithExistingData(existingSchedules);
    isCardVisible.value = true;
  } catch (error) {
    console.error("スケジュールの取得に失敗しました:", error);
    schedules.value = generateEmptySchedules(); // データがない場合は空のスケジュールを生成
  } finally {
    isLoading.value = false;
    loadingText.value = "";
  }
};

// 既存データをマージしてスケジュールを生成する関数
const generateSchedulesWithExistingData = (existingSchedules) => {
  const startOfMonth = dayjs(`${year.value}-${month.value}-01`);
  const endOfMonth = startOfMonth.endOf("month");

  const newSchedules = [];
  for (
    let date = startOfMonth;
    date.isBefore(endOfMonth) || date.isSame(endOfMonth);
    date = date.add(1, "day")
  ) {
    const businessDate = date.format("YYYY-MM-DD");
    newSchedules.push(
      existingSchedules[businessDate] || {
        business_date: businessDate,
        day_of_week: getDayOfWeek(businessDate),
        start_time: "",
        end_time: "",
        status: true,
      }
    );
  }
  return newSchedules;
};

// 曜日を取得する関数
const getDayOfWeek = (dateString) => {
  const days = [
    "日曜日",
    "月曜日",
    "火曜日",
    "水曜日",
    "木曜日",
    "金曜日",
    "土曜日",
  ];
  const date = new Date(dateString);
  return days[date.getDay()];
};

// 前月に移動する関数
const goToPreviousMonth = () => {
  const currentMonth = dayjs(`${year.value}-${month.value}-01`);
  const previousMonth = currentMonth.subtract(1, "month");
  year.value = previousMonth.format("YYYY");
  month.value = previousMonth.format("MM");
  fetchSchedules();
};

// 次月に移動する関数
const goToNextMonth = () => {
  const currentMonth = dayjs(`${year.value}-${month.value}-01`);
  const nextMonth = currentMonth.add(1, "month");
  year.value = nextMonth.format("YYYY");
  month.value = nextMonth.format("MM");
  fetchSchedules();
};

const form = useForm({
  store_id: "",
  schedules: [
    {
      business_date: "",
      day_of_week: "",
      start_time: "",
      end_time: "",
      status: true,
      error: "",
    },
  ],
});

const showAlert = ref(false); // アラートの表示状態
const alertMessage = ref(""); // アラートのメッセージ

// ステータス
const statusOptions = [
  { value: true, label: "開講" },
  { value: false, label: "閉講" },
];

// クリアボタンの動作
function clearForm() {
  form.store_id = "";
  form.business_date = "";
  form.start_time = "";
  form.end_time = "";
  form.day_of_week = "";
  form.status = true;
  form.errors = {};
}

// ボタンの状態
const isSubmitDisabled = computed(() => {
  return form.schedules.some(
    (schedule) =>
      !schedule.business_date ||
      !schedule.start_time ||
      !schedule.end_time ||
      schedule.error
  );
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.storeSchedule.store"), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="店舗スケジュール管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="店舗スケジュール管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Store Schedule', url: route('admin.storeSchedule.index') },
            { name: 'Create', url: route('admin.storeSchedule.create') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Alert -->
    <WarningAlert
      :isVisible="showAlert"
      :message="alertMessage"
      @confirm="closeAlert"
    />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <StoreLayout>
      <div class="flex justify-between p-5">
        <div class="w-1/2 flex flex-col gap-2">
          <PageSubTitle title="店舗スケジュール新規登録画面" />
          <PageDescription
            description="店舗のスケジュールを新規登録することができます。"
          />
        </div>
        <div class="w-1/2 flex justify-end items-center gap-2">
          <BackButton
            :href="route('admin.storeSchedule.index')"
            buttonType="secondary"
            ><Back />店舗スケジュール一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <div class="space-y-4">
              <div class="flex">
                <FormGroup class="w-full lg:max-w-md">
                  <InputLabel for="store_id" value="店舗名" required />
                  <template v-if="props.stores.length <= 3">
                    <RadioInput
                      id="store_id"
                      v-model="selectedStore"
                      :options="props.stores"
                      required
                    />
                  </template>
                  <template v-else>
                    <SelectInput
                      id="store_id"
                      v-model="selectedStore"
                      :options="props.stores"
                      required
                    />
                  </template>
                </FormGroup>
              </div>
              <div class="flex gap-4 mb-4">
                <FormGroup class="w-1/4">
                  <InputLabel for="year" value="年" required />
                  <TextInput
                    id="year"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="year"
                    placeholder="例: 2025"
                    required
                  />
                </FormGroup>
                <FormGroup class="w-1/4">
                  <InputLabel for="month" value="月" required />
                  <TextInput
                    id="month"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="month"
                    placeholder="例: 5"
                    required
                  />
                </FormGroup>
              </div>
              <PrimaryButton buttonType="success" @click="fetchSchedules">
                スケジュールを取得
              </PrimaryButton>
            </div>
          </template>
        </Card>
        <Card v-if="isCardVisible">
          <template #content>
            <div class="space-y-6">
              <!-- Form -->
              <form @submit.prevent="store" class="space-y-6">
                <h3>{{ selectedStore.name }}</h3>
                <p>開始時間、終了時間、ステータスを入力していください。</p>
                <div class="space-y-4">
                  <div class="flex justify-center gap-5">
                    <PrimaryButton
                      buttonType="secondary"
                      @click="goToPreviousMonth"
                    >
                      前月
                    </PrimaryButton>
                    <!-- 今月を表示 year month -->
                    <PrimaryButton buttonType="primary">
                      {{ year }}年{{ month }}月
                    </PrimaryButton>
                    <PrimaryButton buttonType="secondary" @click="goToNextMonth">
                      次月
                    </PrimaryButton>
                  </div>
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
                          開始時間
                        </th>
                        <th
                          class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                        >
                          終了時間
                        </th>
                        <th
                          class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                        >
                          ステータス
                        </th>
                      </tr>
                    </template>
                    <template #body>
                      <tr
                        v-for="(schedule, index) in schedules"
                        :key="schedule.id"
                      >
                        <td>{{ index + 1 }}</td>
                        <td
                          class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                          <TextInput
                            id="business_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="schedule.business_date"
                            required
                            readonly
                          />
                        </td>
                        <td
                          class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                          <TextInput
                            id="day_of_week"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="schedule.day_of_week"
                            required
                            readonly
                          />
                        </td>
                        <td
                          class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                          <TextInput
                            id="start_time"
                            type="time"
                            class="mt-1 block w-full"
                            v-model="schedule.start_time"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="form.errors.start_time"
                          />
                        </td>
                        <td
                          class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                          <TextInput
                            id="end_time"
                            type="time"
                            class="mt-1 block w-full"
                            v-model="schedule.end_time"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="form.errors.end_time"
                          />
                        </td>
                        <td
                          class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                          <RadioInput
                            :id="`status-${index}`"
                            :name="`status-${index}`"
                            v-model="schedule.status"
                            :options="statusOptions"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="form.errors.status"
                          />
                        </td>
                      </tr>
                    </template>
                  </SimpleTable>
                </div>

                <p class="flex">
                  1~10でお応えください。<br>
                  <span>(10~)</span>
                </p>
                <div class="flex flex-col lg:flex-row gap-4">
                  <PrimaryButton
                    buttonActionType="submit"
                    buttonType="primary"
                    :disabled="isSubmitDisabled"
                    ><Save class="mr-2" />登録</PrimaryButton
                  >
                  <PrimaryButton buttonType="secondary" @click="clearForm"
                    ><Clear class="mr-2" />
                    入力をクリア
                  </PrimaryButton>
                </div>
              </form>
            </div>
          </template>
        </Card>
      </div>
    </StoreLayout>
  </AdminAuthenticatedLayout>
</template>