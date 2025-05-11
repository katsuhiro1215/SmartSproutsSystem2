<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, onMounted, ref, computed } from "vue";
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
import LoadingIndicator from "@/Components/Loadings/LoadingIndicator.vue";
//  Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//  Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Update from "vue-material-design-icons/Update.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateStoreId,
  validateBusinessDate,
  validateDayOfWeek,
  validateStartTime,
  validateEndTime,
  validateStatus,
  validateNote,
  validateAllFields,
} from "./_components/validation";
import validationMessages from "@/Constants/validationMessages";

const props = defineProps({
  storeSchedule: Object,
});

const form = useForm({
  store_id: props.storeSchedule.store.name,
  business_date: props.storeSchedule.business_date,
  day_of_week: props.storeSchedule.day_of_week,
  start_time: props.storeSchedule.start_time,
  end_time: props.storeSchedule.end_time,
  note: props.storeSchedule.note,
  status: Boolean(props.storeSchedule.status),
});

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

const updateDayOfWeek = () => {
  const date = form.business_date;
  if (date) {
    form.day_of_week = getDayOfWeek(date);
  }
};

// ステータス
const statusOptions = [
  { value: true, label: "開講" },
  { value: false, label: "閉講" },
];

// クリアボタンの動作
function clearForm() {
  form.business_date = "";
  form.start_time = "";
  form.end_time = "";
  form.status = true;
  form.note = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  const noErrors = Object.keys(form.errors).length === 0;

  return noErrors;
});

// 登録
const update = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "更新中";
    form.post(route("admin.storeSchedule.update", storeSchedule.id), {
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
            {
              name: 'Edit',
              url: route('admin.storeSchedule.edit', storeSchedule.id),
            },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <StoreLayout>
      <div class="flex justify-between">
        <div class="w-1/2 flex flex-col gap-2">
          <PageSubTitle title="店舗スケジュール編集画面" />
          <PageDescription
            description="店舗のスケジュールを編集することができます。"
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
              <h3>背景がピンクの項目は編集することができません。</h3>
              <!-- Form -->
              <form @submit.prevent="update" class="space-y-6">
                <div class="flex flex-col lg:flex-row gap-5">
                  <div class="w-full sm:w-2/3 space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="store_id" value="店舗名" required />
                        <TextInput
                          id="store_id"
                          type="text"
                          class="mt-1 block w-full"
                          backgroundColor="bg-pink-300 dark:bg-pink-600"
                          v-model="form.store_id"
                          @blur="validateStoreId(form)"
                          required
                          readonly
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.store_id"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="business_date"
                          value="営業日"
                          required
                        />
                        <TextInput
                          id="business_date"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.business_date"
                          @change="updateDayOfWeek"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.business_date"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel for="day_of_week" value="曜日" required />
                        <TextInput
                          id="day_of_week"
                          type="text"
                          class="mt-1 block w-full"
                          backgroundColor="bg-pink-300 dark:bg-pink-600"
                          v-model="form.day_of_week"
                          required
                          readonly
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.day_of_week"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="start_time"
                          value="営業開始時間"
                          required
                        />
                        <TextInput
                          id="start_time"
                          type="time"
                          class="mt-1 block w-full"
                          v-model="form.start_time"
                          placeholder="営業開始時間を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.start_time"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="end_time"
                          value="営業終了時間"
                          required
                        />
                        <TextInput
                          id="end_time"
                          type="time"
                          class="mt-1 block w-full"
                          v-model="form.end_time"
                          placeholder="営業終了時間を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.end_time"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="status" value="ステータス" required />
                        <RadioInput
                          id="status"
                          name="status"
                          v-model="form.status"
                          :options="statusOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.status"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="note" value="ノート" />
                        <TextArea
                          id="note"
                          class="mt-1 block w-full"
                          v-model="form.note"
                          @blur="validateNote(form)"
                          placeholder="ノートを入力してください。"
                        />
                        <InputError class="mt-2" :message="form.errors.note" />
                      </FormGroup>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                  <PrimaryButton
                    buttonActionType="submit"
                    buttonType="warning"
                    :disabled="!isFormValid"
                    ><Update class="mr-2" />更新</PrimaryButton
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