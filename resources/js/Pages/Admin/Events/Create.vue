<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import EventLayout from "@/Components/SidebarLayouts/EventLayout.vue";
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
import TextArea from "@/Components/Forms/TextArea.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import ImageUpload from "@/Components/Forms/ImageUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// API
import YubinBango from "yubinbango-core2";
// Validation
import {
  validateName,
  validateDescription,
  validatePostalcode,
  validatePrefecture,
  validateCity,
  validateAddress1,
  validateAddress2,
  validatePhoneNumber,
  validateStatus,
  validateEventStartDate,
  validateEventEndDate,
  validateApplicationStartDate,
  validateApplicationStartTime,
  validateApplicationEndDate,
  validateApplicationEndTime,
  validateAllFields,
} from "./_components/validation";

const form = useForm({
  name: "",
  description: "",
  event_photo_path: "",
  postalcode: "",
  prefecture: "",
  city: "",
  address1: "",
  address2: "",
  phone_number: "",
  status: true,
  event_start_date: "",
  event_end_date: "",
  application_start_date: "",
  application_start_time: "",
  application_end_date: "",
  application_end_time: "",
});

// ステータス
const statusOptions = [
  { value: true, label: "開講" },
  { value: false, label: "閉講" },
];

// クリアボタンの動作
function clearForm() {
  form.name = "";
  form.description = "";
  form.event_photo_path = "";
  form.postalcode = "";
  form.prefecture = "";
  form.city = "";
  form.address1 = "";
  form.address2 = "";
  form.phone_number = "";
  form.status = true;
  form.event_start_date = "";
  form.event_end_date = "";
  form.application_start_date = "";
  form.application_start_time = "";
  form.application_end_date = "";
  form.application_end_time = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// API
const fetchAddress = () => {
  const yubin = new YubinBango.Core(form.postalcode, (address) => {
    form.prefecture = address.region;
    form.city = address.locality;
    form.address1 = address.street;
  });
};

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    form.name &&
    form.description &&
    form.status &&
    form.event_start_date &&
    form.event_end_date &&
    form.application_start_date &&
    form.application_start_time &&
    form.application_end_date &&
    form.application_end_time;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.event.store"), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="イベント管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="イベント管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Event', url: route('admin.event.index') },
            { name: 'Create', url: route('admin.event.create') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <EventLayout>
      <div class="flex justify-between p-5">
        <div class="w-1/2 flex flex-col gap-2">
          <PageSubTitle title="イベント新規登録画面" />
          <PageDescription
            description="イベントの新規登録することができます。"
          />
        </div>
        <div class="w-1/2 flex justify-end items-center gap-2">
          <BackButton
            :href="route('admin.event.index')"
            buttonType="secondary"
            ><Back />イベント一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <div class="space-y-6">
              <!-- Form -->
              <form @submit.prevent="store" class="space-y-6" enctype="multipart/form-data">
                <div class="flex flex-col lg:flex-row gap-5">
                  <div class="w-full sm:w-2/3 space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="name" value="イベント名" required />
                        <TextInput
                          id="name"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.name"
                          @blur="validateName(form)"
                          placeholder="イベント名を入力してください。"
                          required
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="wfull">
                        <InputLabel
                          for="description"
                          value="イベント概要"
                          required
                        />
                        <TextArea
                          id="description"
                          class="mt-1 block w-full"
                          v-model="form.description"
                          @blur="validateDescription(form)"
                          placeholder="イベント概要を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.description"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-full lg:w-1/3">
                        <InputLabel for="postalcode" value="郵便番号" />
                        <TextInput
                          id="postalcode"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.postalcode"
                          @blur="validatePostalcode(form)"
                          placeholder="郵便番号を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.postalcode"
                        />
                      </FormGroup>
                      <FormGroup class="w-full lg:w-1/3">
                        <InputLabel for="search" value="検索" />
                        <PrimaryButton
                          class="mt-2"
                          buttonType="primary"
                          buttonSize="xl"
                          @click.prevent="fetchAddress"
                          >郵便番号から住所を検索</PrimaryButton
                        >
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="prefecture"
                          value="都道府県名"
                        />
                        <TextInput
                          id="prefecture"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.prefecture"
                          @blur="validatePrefecture(form)"
                          placeholder="都道府県名を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.prefecture"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="city"
                          value="市区町村名"
                        />
                        <TextInput
                          id="city"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.city"
                          @blur="validateCity(form)"
                          placeholder="市区町村名を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.city"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel for="address1" value="地域名" />
                        <TextInput
                          id="address1"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.address1"
                          @blur="validateAddress1(form)"
                          placeholder="地域名を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.address1"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-full">
                        <InputLabel
                          for="address2"
                          value="建物その他"
                        />
                        <TextInput
                          id="address2"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.address2"
                          @blur="validateAddress2(form)"
                          placeholder="建物その他の住所を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.address2"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="phone_number"
                          value="電話番号"
                        />
                        <TextInput
                          id="phone_number"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.phone_number"
                          @blur="validatePhoneNumber(form)"
                          placeholder="電話番号を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.phone_number"
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
                          @blur="validateStatus(form)"
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
                        <InputLabel
                          for="event_start_date"
                          value="イベント開始日"
                          required
                        />
                        <TextInput
                          id="event_start_date"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.event_start_date"
                          @blur="validateEventStartDate(form)"
                          placeholder="イベント開始日を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.event_start_date"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="event_end_date"
                          value="イベント終了日"
                          required
                        />
                        <TextInput
                          id="event_end_date"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.event_end_date"
                          @blur="validateEventEndDate(form)"
                          placeholder="イベント終了日を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.event_end_date"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/4">
                        <InputLabel
                          for="application_start_date"
                          value="イベント申込開始日"
                          required
                        />
                        <TextInput
                          id="application_start_date"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.application_start_date"
                          @blur="validateApplicationStartDate(form)"
                          placeholder="イベント申込開始日を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.application_start_date"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/4">
                        <InputLabel
                          for="application_start_time"
                          value="イベント申込開始時間"
                          required
                        />
                        <TextInput
                          id="application_start_time"
                          type="time"
                          class="mt-1 block w-full"
                          v-model="form.application_start_time"
                          @blur="validateApplicationStartTime(form)"
                          placeholder="イベント申込開始時間を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.application_start_time"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/4">
                        <InputLabel
                          for="application_end_date"
                          value="イベント申込終了日"
                          required
                        />
                        <TextInput
                          id="application_end_date"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.application_end_date"
                          @blur="validateApplicationEndDate(form)"
                          placeholder="イベント申込終了日を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.application_end_date"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/4">
                        <InputLabel
                          for="application_end_time"
                          value="イベント申込終了時間"
                          required
                        />
                        <TextInput
                          id="application_end_time"
                          type="time"
                          class="mt-1 block w-full"
                          v-model="form.application_end_time"
                          @blur="validateApplicationEndTime(form)"
                          placeholder="イベント申込終了時間を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.application_end_time"
                        />
                      </FormGroup>
                    </div>
                  </div>
                  <div class="w-full sm:w-1/3 space-y-4">
                    <div class="flex flex-col gap-4">
                      <FormGroup>
                        <InputLabel for="event_photo_path" value="イベント画像" />
                        <ImageUpload
                          id="event_photo_path"
                          ref="inputFile"
                          v-model="form.event_photo_path"
                          @change="handleFileUpload"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.event_photo_path"
                        />
                      </FormGroup>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                  <PrimaryButton
                    buttonActionType="submit"
                    buttonType="primary"
                    :disabled="!isFormValid"
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
    </EventLayout>
  </AdminAuthenticatedLayout>
</template>