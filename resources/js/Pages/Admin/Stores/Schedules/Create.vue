<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
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
import Separator from "@/Components/Separator.vue";
//  Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//  Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Add from "vue-material-design-icons/Plus.vue";
import Remove from "vue-material-design-icons/Minus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateStoreId,
  validateBusinessDate,
  validateStartTime,
  validateEndTime,
  validateDayOfWeek,
  validateStatus,
  validateAllFields,
} from "./_components/validation";
import validationMessages from "@/Constants/validationMessages";

const props = defineProps({
  stores: Array,
});

const form = useForm({
  store_id: 1,
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

// スケジュールの追加と削除
const MAX_SCHEDULES = 30;

const addSchedule = () => {
  if (form.schedules.length >= MAX_SCHEDULES) {
    alertMessage.value = `スケジュールは最大${MAX_SCHEDULES}件まで追加できます。`;
    showAlert.value = true; // アラートを表示
    return;
  }

  form.schedules.push({
    business_date: "",
    day_of_week: "",
    start_time: "",
    end_time: "",
    status: true,
    error: "",
  });
  console.log("Schedules after adding:", form.schedules);
};

const closeAlert = () => {
  showAlert.value = false; // アラートを閉じる
};

const removeSchedule = (index) => {
  if (form.schedules.length > 1) {
    form.schedules.splice(index, 1);
  }
};

// 曜日の自動入力
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

const updateDayOfWeek = (index) => {
  const schedule = form.schedules[index];
  if (schedule.business_date) {
    schedule.day_of_week = getDayOfWeek(schedule.business_date);
  }
};

// 入力中のスケジュール同士の重複チェック
const checkLocalScheduleConflict = (index) => {
  const currentSchedule = form.schedules[index];

  if (
    !currentSchedule.business_date ||
    !currentSchedule.start_time ||
    !currentSchedule.end_time
  ) {
    currentSchedule.error = "";
    return;
  }

  const isConflict = form.schedules.some((schedule, i) => {
    if (i === index) return false;

    return (
      schedule.business_date === currentSchedule.business_date &&
      schedule.start_time < currentSchedule.end_time &&
      schedule.end_time > currentSchedule.start_time
    );
  });

  currentSchedule.error = isConflict
    ? "このスケジュールは他のスケジュールと重複しています。"
    : "";
};

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

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

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
            <div class="space-y-6">
              <!-- Form -->
              <form @submit.prevent="store" class="space-y-6">
                <div class="flex flex-col lg:flex-row gap-5">
                  <div class="w-full space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="store_id" value="店舗名" required />
                        <RadioInput
                          id="store_id"
                          name="store_id"
                          v-model="form.store_id"
                          @blur="validateStoreId(form)"
                          :options="stores"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.store_id"
                        />
                      </FormGroup>
                    </div>
                    <Separator />
                    <div class="space-y-4">
                      <div
                        v-for="(schedule, index) in form.schedules"
                        :key="index"
                        class="flex flex-col lg:flex-row gap-4"
                      >
                        <FormGroup class="w-1/6">
                          <InputLabel
                            for="business_date"
                            value="営業日"
                            required
                          />
                          <TextInput
                            id="business_date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="schedule.business_date"
                            @change="updateDayOfWeek(index)"
                            @blur="checkLocalScheduleConflict(index)"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="
                              schedule.error || form.errors.business_date
                            "
                          />
                        </FormGroup>
                        <FormGroup class="w-1/6">
                          <InputLabel for="day_of_week" value="曜日" required />
                          <TextInput
                            id="day_of_week"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="schedule.day_of_week"
                            required
                            readonly
                          />
                          <InputError
                            class="mt-2"
                            :message="form.errors.day_of_week"
                          />
                        </FormGroup>
                        <FormGroup class="w-1/6">
                          <InputLabel
                            for="start_time"
                            value="開始時間"
                            required
                          />
                          <TextInput
                            id="start_time"
                            type="time"
                            class="mt-1 block w-full"
                            v-model="schedule.start_time"
                            @blur="checkLocalScheduleConflict(index)"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="schedule.error || form.errors.start_time"
                          />
                        </FormGroup>
                        <FormGroup class="w-1/6">
                          <InputLabel
                            for="end_time"
                            value="終了時間"
                            required
                          />
                          <TextInput
                            id="end_time"
                            type="time"
                            class="mt-1 block w-full"
                            v-model="schedule.end_time"
                            @blur="checkLocalScheduleConflict(index)"
                            required
                          />
                          <InputError
                            class="mt-2"
                            :message="schedule.error || form.errors.end_time"
                          />
                        </FormGroup>
                        <FormGroup class="w-1/6">
                          <InputLabel
                            :for="`status-${index}`"
                            value="ステータス"
                            required
                          />
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
                        </FormGroup>
                        <!-- 追加、削除のボタン -->
                        <FormGroup class="w-1/6">
                          <InputLabel value="Action" />
                          <div class="flex gap-2">
                            <PrimaryButton
                              buttonType="success"
                              @click="addSchedule"
                              ><Add class="mr-2" /> 追加</PrimaryButton
                            >
                            <PrimaryButton
                              buttonType="danger"
                              @click="removeSchedule"
                              ><Remove class="mr-2" /> 削除</PrimaryButton
                            >
                          </div>
                        </FormGroup>
                      </div>
                    </div>
                  </div>
                </div>
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