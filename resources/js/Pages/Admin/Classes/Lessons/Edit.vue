<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import ClassLayout from "@/Components/SidebarLayouts/ClassLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - Form
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import ImageUpload from "@/Components/Forms/ImageUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
import Update from "vue-material-design-icons/Update.vue";
// Validation
import {
  validateStoreId,
  validateName,
  validateDescription,
  validateStatus,
  validateStartDate,
  validateEndDate,
  validateAllFields,
} from "./_components/validation";

const props = defineProps({
  stores: Array,
  lesson: Object,
});

// Form
const form = useForm({
  store_id: props.lesson.store_id,
  name: props.lesson.name,
  description: props.lesson.description,
  lesson_photo_path: props.lesson.lesson_photo_path,
  status: Boolean(props.lesson.status),
  start_date: props.lesson.start_date,
  end_date: props.lesson.end_date,
});

// ステータス
const statusOptions = [
  { value: true, label: "開講" },
  { value: false, label: "閉講" },
];

// ファイルアップロード
const inputFile = ref(null);

function handleFileUpload(event) {
  const files = event.target.files;
  if (files.length) {
    const formData = new FormData();
    formData.append("lesson_photo_path", files[0]);
    form.lesson_photo_path = formData;
  }
}

const validateStartDateWithStore = () => {
  const selectedStore = props.stores.find(store => store.value === form.store_id);
  if (!selectedStore) {
    form.errors.store_id = "選択された店舗が見つかりません。";
    return;
  }
  validateStartDate(form, selectedStore.established_date);
};

// クリアボタンの動作
function clearForm() {
  form.store_id = props.defaultStoreId;
  form.name = "";
  form.description = "";
  form.lesson_photo_path = "";
  form.status = true;
  form.start_date = "";
  form.end_date = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    form.store_id && form.name && form.description && form.status;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const update = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "更新中";
    form.post(route("admin.lesson.update", lesson.id), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="レッスン管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="レッスン管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Lesson', url: route('admin.lesson.index') },
            { name: 'Edit', url: route('admin.lesson.edit', ['id']) },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Content -->
     <ClassLayout>
       <div class="flex justify-between p-5">
         <div class="w-1/2 flex flex-col gap-2">
           <PageSubTitle title="レッスン新規作成画面" />
           <PageDescription
             description="レッスンを新規作成する画面です。"
           />
         </div>
         <div class="w-1/2 flex justify-end items-center gap-2">
           <BackButton type="button" :href="route('admin.lesson.index')"
             ><Back />戻る</BackButton
           >
         </div>
       </div>
       <div class="w-full">
         <Card>
           <template #content>
             <div class="space-y-6">
               <!-- Form -->
               <form @submit.prevent="store" class="space-y-6">
                 <div class="flex flex-col lg:flex-row gap-4">
                   <div class="w-full sm:w-2/3 space-y-4">
                     <div class="flex flex-col lg:flex-row gap-4">
                       <FormGroup class="w-1/2">
                         <InputLabel for="store_id" value="店舗名" required />
                         <RadioInput
                           id="store_id"
                           name="store_id"
                           v-model="form.store_id"
                           @blur="validateStoreId(form)"
                           :options="props.stores"
                           required
                         />
                         <InputError
                           class="mt-2"
                           :message="form.errors.store_id"
                         />
                       </FormGroup>
                     </div>
                     <div class="flex flex-col lg:flex-row gap-4">
                       <FormGroup class="w-1/2">
                         <InputLabel for="name" value="レッスン名" required />
                         <TextInput
                           id="name"
                           type="text"
                           class="mt-1 block w-full"
                           v-model="form.name"
                           @blur="validateName(form)"
                           required
                           placeholder="レッスン名を入力してください(50文字以内)。"
                         />
                         <InputError class="mt-2" :message="form.errors.name" />
                       </FormGroup>
                     </div>
                     <div class="flex flex-col lg:flex-row gap-4">
                       <FormGroup class="w-1/2">
                         <InputLabel
                           for="description"
                           value="レッスン内容"
                           required
                         />
                         <TextArea
                           id="description"
                           class="mt-1 block w-full"
                           v-model="form.description"
                           @blur="validateDescription(form)"
                           required
                           placeholder="レッスン内容を入力してください(1000文字以内)。"
                         />
                         <InputError
                           class="mt-2"
                           :message="form.errors.description"
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
                         <InputLabel for="start_date" value="レッスン開始日" />
                         <TextInput
                           id="start_date"
                           type="date"
                           class="mt-1 block w-full"
                           v-model="form.start_date"
                           @blur="validateStartDateWithStore"
                         />
                         <InputError
                           class="mt-2"
                           :message="form.errors.start_date"
                         />
                       </FormGroup>
                       <FormGroup class="w-1/2">
                         <InputLabel for="end_date" value="レッスン終了日" />
                         <TextInput
                           id="end_date"
                           type="date"
                           class="mt-1 block w-full"
                           v-model="form.end_date"
                           @blur="validateEndDate(form)"
                         />
                         <InputError
                           class="mt-2"
                           :message="form.errors.end_date"
                         />
                       </FormGroup>
                     </div>
                   </div>
                   <div class="w-full sm:w-1/3">
                     <div class="flex flex-col">
                       <InputLabel
                         for="lesson_photo_path"
                         value="レッスン画像"
                       />
                       <ImageUpload
                         id="lesson_photo_path"
                         ref="inputFile"
                         v-model="form.lesson_photo_path"
                         @change="handleFileUpload"
                       />
                       <InputError
                         class="mt-2"
                         :message="form.errors.lesson_photo_path"
                       />
                     </div>
                   </div>
                 </div>
                 <div class="flex flex-col lg:flex-row gap-4">
                   <PrimaryButton
                     buttonType="orange"
                     buttonActionType="submit"
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
     </ClassLayout>
  </AdminAuthenticatedLayout>
</template>