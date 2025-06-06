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
import SelectInput from "@/Components/Forms/SelectInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import ImageUpload from "@/Components/Forms/ImageUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Update from "vue-material-design-icons/Update.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateLessonId,
  validateName,
  validateDescription,
  validateStatus,
  validateStartDate,
  validateEndDate,
  validateAllFields,
} from "./_components/validation";

const props = defineProps({
  course: Object,
  lessons: {
    type: Array,
    default: () => [],
  },
  defaultLessonId: Number,
  courseCategories: {
    type: Array,
    default: () => [],
  },
  defaultCourseCategoryId: Number,
});

// Form
const form = useForm({
  lesson_id: props.course.lesson_id,
  course_category_id: props.course.course_category_id,
  name: props.course.name,
  description: props.course.description,
  course_photo_path: props.course.course_photo_path,
  status: Boolean(props.course.status),
  start_date: props.course.start_date,
  end_date: props.course.end_date,
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
    formData.append("course_photo_path", files[0]);
    form.course_photo_path = formData;
  }
}

const validateStartDateWithLesson = () => {
  const selectedLesson = props.lessons.find(
    (lesson) => lesson.value === form.lesson_id
  );
  if (!selectedLesson) {
    form.errors.lesson_id = "選択されたレッスンが見つかりません。";
    return;
  }
  validateStartDate(form, selectedLesson.start_date);
};

// クリアボタンの動作
function clearForm() {
  form.lesson_id = props.defaultLessonId;
  form.course_category_id = props.defaultCourseCategoryId;
  form.name = "";
  form.description = "";
  form.course_photo_path = "";
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
    form.post(route("admin.course.update", course.id), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="コース管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="コース管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Course', url: route('admin.course.index') },
            { name: 'Edit', url: route('admin.course.edit', course.id) },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <ClassLayout>
      <div class="flex justify-between p-5">
        <div class="w-1/2 flex flex-col gap-2">
          <PageSubTitle title="コース編集画面" />
          <PageDescription description="コースを編集する画面です。" />
        </div>
        <div class="w-1/2 flex justify-end items-center gap-2">
          <BackButton :href="route('admin.course.index')"
            ><Back />コース一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <div class="space-y-6">
              <!-- Form -->
              <form @submit.prevent="update" class="space-y-6">
                <div class="flex flex-col lg:flex-row gap-4">
                  <div class="w-full sm:w-2/3 space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="lesson_id"
                          value="レッスン名"
                          required
                        />
                        <template v-if="props.lessons.length <= 3">
                          <RadioInput
                            id="lesson_id"
                            name="lesson_id"
                            v-model="form.lesson_id"
                            @blur="validateLessonId(form)"
                            :options="props.lessons"
                            required
                          />
                        </template>
                        <template v-else>
                          <SelectInput
                            id="lesson_id"
                            v-model="form.lesson_id"
                            :options="props.lessons"
                            @change="validateLessonId(form)"
                            required
                          />
                        </template>
                        <InputError
                          class="mt-2"
                          :message="form.errors.lesson_id"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="course_category_id"
                          value="コースカテゴリー名"
                          required
                        />
                        <template v-if="props.courseCategories.length <= 3">
                          <RadioInput
                            id="course_category_id"
                            name="course_category_id"
                            v-model="form.course_category_id"
                            @blur="validateCourseCategoryId(form)"
                            :options="props.courseCategories"
                            required
                          />
                        </template>
                        <template v-else>
                          <SelectInput
                            id="course_category_id"
                            v-model="form.course_category_id"
                            :options="props.courseCategories"
                            @change="validateCourseCategoryId(form)"
                            required
                          />
                        </template>
                        <InputError
                          class="mt-2"
                          :message="form.errors.course_category_id"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="name"
                          value="コースカテゴリー名"
                          required
                        />
                        <TextInput
                          id="name"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.name"
                          @blur="validateName(form)"
                          required
                          placeholder="コースカテゴリー名を入力してください(50文字以内)。"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="description"
                          value="コースカテゴリー内容"
                          required
                        />
                        <TextArea
                          id="description"
                          class="mt-1 block w-full"
                          v-model="form.description"
                          @blur="validateDescription(form)"
                          required
                          placeholder="コースカテゴリー内容を入力してください(1000文字以内)。"
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
                        <InputLabel
                          for="start_date"
                          value="コースカテゴリー開始日"
                        />
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
                        <InputLabel
                          for="end_date"
                          value="コースカテゴリー終了日"
                        />
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
                        for="course_category_photo_path"
                        value="コースカテゴリー画像"
                      />
                      <ImageUpload
                        id="course_category_photo_path"
                        ref="inputFile"
                        v-model="form.course_category_photo_path"
                        @change="handleFileUpload"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.course_category_photo_path"
                      />
                    </div>
                  </div>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                  <PrimaryButton
                    buttonType="orange"
                    buttonActionType="submit"
                    :disabled="!isFormValid"
                    ><Save class="mr-2" />更新</PrimaryButton
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