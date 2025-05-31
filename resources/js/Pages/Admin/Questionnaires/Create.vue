<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import QuestionnaireLayout from "@/Components/SidebarLayouts/QuestionnaireLayout.vue";
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
// Validation
import {
  validateName,
  validateMainDescription,
  validateSubDescription,
  validateAnnotation,
  validateStatus,
  validateStartDate,
  validateStartTime,
  validateEndDate,
  validateEndTime,
  validateAllFields,
} from "./_components/validation";
import QuestionnairePreview from "./_components/QuestionnairePreview.vue";

const form = useForm({
  name: "",
  main_description: "",
  sub_description: "",
  annotation: "",
  questionnaire_photo_path: "",
  status: true,
  start_date: "",
  start_time: "",
  end_date: "",
  end_time: "",
});

// ステータス
const statusOptions = [
  { value: true, label: "開講" },
  { value: false, label: "閉講" },
];

// クリアボタンの動作
function clearForm() {
  form.name = "";
  form.main_description = "";
  form.sub_description = "";
  form.annotation = "";
  form.questionnaire_photo_path = "";
  form.status = true;
  form.start_date = "";
  form.start_time = "";
  form.end_date = "";
  form.end_time = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    form.name &&
    form.description &&
    form.status &&
    form.start_date &&
    form.start_time &&
    form.end_date &&
    form.end_time;

  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.questionnaire.store"), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="アンケート管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="アンケート管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Questionnaire', url: route('admin.questionnaire.index') },
            { name: 'Create', url: route('admin.questionnaire.create') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <QuestionnaireLayout>
      <div class="flex justify-between p-5">
        <div class="w-1/2 flex flex-col gap-2">
          <PageSubTitle title="アンケート新規登録画面" />
          <PageDescription
            description="アンケートの新規登録することができます。"
          />
        </div>
        <div class="w-1/2 flex justify-end items-center gap-2">
          <BackButton
            :href="route('admin.questionnaire.index')"
            buttonType="secondary"
            ><Back />アンケート一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <div class="space-y-6">
              <div class="flex gap-5">
                <div class="w-full sm:w-3/4 space-y-4">
                  <!-- Form -->
                   <h4>フォーム</h4>
                  <form @submit.prevent="store" class="space-y-6" enctype="multipart/form-data">
                    <div class="flex gap-4">
                      <div class="w-full sm:w-2/3 space-y-4">
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="w-1/2">
                            <InputLabel for="name" value="アンケート設問名" required />
                            <TextInput
                              id="name"
                              type="text"
                              class="mt-1 block w-full"
                              v-model="form.name"
                              @blur="validateName(form)"
                              placeholder="アンケート設問を入力してください。"
                              required
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                          </FormGroup>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="w-1/2">
                            <InputLabel for="name" value="アンケート設問名" required />
                            <TextInput
                              id="name"
                              type="text"
                              class="mt-1 block w-full"
                              v-model="form.name"
                              @blur="validateName(form)"
                              placeholder="アンケート設問を入力してください。"
                              required
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                          </FormGroup>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="wfull">
                            <InputLabel
                              for="main_description"
                              value="アンケート設問内容"
                              required
                            />
                            <TextArea
                              id="main_description"
                              class="mt-1 block w-full"
                              v-model="form.main_description"
                              @blur="validateMainDescription(form)"
                              placeholder="アンケート設問内容を入力してください。"
                              required
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.main_description"
                            />
                          </FormGroup>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="wfull">
                            <InputLabel
                              for="sub_description"
                              value="アンケート設問の補足説明"
                            />
                            <TextArea
                              id="sub_description"
                              class="mt-1 block w-full"
                              v-model="form.sub_description"
                              @blur="validateSubDescription(form)"
                              placeholder="アンケート設問の補足説明を入力してください。"
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.sub_description"
                            />
                          </FormGroup>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="wfull">
                            <InputLabel
                              for="annotation"
                              value="アンケート設問注釈"
                            />
                            <TextArea
                              id="annotation"
                              class="mt-1 block w-full"
                              v-model="form.annotation"
                              @blur="validateAnnotation(form)"
                              placeholder="アンケート設問注釈を入力してください。"
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.annotation"
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
                              for="start_date"
                              value="公開開始日"
                              required
                            />
                            <TextInput
                              id="start_date"
                              type="date"
                              class="mt-1 block w-full"
                              v-model="form.start_date"
                              @blur="validateStartDate(form)"
                              placeholder="公開開始日を入力してください。"
                              required
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.start_date"
                            />
                          </FormGroup>
                          <FormGroup class="w-1/2">
                            <InputLabel
                              for="start_time"
                              value="公開開始時間"
                              required
                            />
                            <TextInput
                              id="astart_time"
                              type="time"
                              class="mt-1 block w-full"
                              v-model="form.start_time"
                              @blur="validateStartTime(form)"
                              placeholder="公開開始時間を入力してください。"
                              required
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.start_time"
                            />
                          </FormGroup>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-4">
                          <FormGroup class="w-1/2">
                            <InputLabel
                              for="end_date"
                              value="公開終了日"
                              required
                            />
                            <TextInput
                              id="end_date"
                              type="date"
                              class="mt-1 block w-full"
                              v-model="form.end_date"
                              @blur="validateEndDate(form)"
                              placeholder="公開終了日を入力してください。"
                              required
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.end_date"
                            />
                          </FormGroup>
                          <FormGroup class="w-1/2">
                            <InputLabel
                              for="end_time"
                              value="公開終了時間"
                              required
                            />
                            <TextInput
                              id="end_time"
                              type="time"
                              class="mt-1 block w-full"
                              v-model="form.end_time"
                              @blur="validateEndTime(form)"
                              placeholder="公開終了時間を入力してください。"
                              required
                            />
                            <InputError
                              class="mt-2"
                              :message="form.errors.end_time"
                            />
                          </FormGroup>
                        </div>
                      </div>
                      <div class="w-full sm:w-1/3 space-y-4">
                        <FormGroup>
                          <InputLabel
                            for="questionnaire_photo_path"
                            value="アンケート画像"
                          />
                          <ImageUpload
                            id="questionnaire_photo_path"
                            v-model="form.questionnaire_photo_path"
                            @blur="validateAllFields(form)"
                            placeholder="アンケート画像をアップロードしてください。"
                          />
                          <InputError
                            class="mt-2"
                            :message="form.errors.questionnaire_photo_path"
                          />
                        </FormGroup>
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
                <div class="w-full sm:w-1/4 space-y-4">
                  <h4>プレビュー</h4>
                  <QuestionnairePreview :form="form" />
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </QuestionnaireLayout>
  </AdminAuthenticatedLayout>
</template>