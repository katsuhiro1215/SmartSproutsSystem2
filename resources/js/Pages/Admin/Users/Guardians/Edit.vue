<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import UserLayout from "@/Components/SidebarLayouts/UserLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import LoadingIndicator from "@/Components/Loadings/LoadingIndicator.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import ImageUpload from "@/Components/Forms/ImageUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
// Icons
import Update from "vue-material-design-icons/Update.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateLastname,
  validateFirstname,
  validateLastnameKana,
  validateFirstnameKana,
  validateRelationship,
  validateBirth,
  validateGender,
  validateBlood,
  validateMobileNumber,
  validateCompanyName,
  validateCompanyPhoneNumber,
  validateAllFields,
} from "./_components/validation";

// Props
const props = defineProps({
  guardian: Object,
});

// Form
const form = useForm({
  lastname: props.guardian.lastname,
  firstname: props.guardian.firstname,
  lastname_kana: props.guardian.lastname_kana,
  firstname_kana: props.guardian.firstname_kana,
  relationship: props.guardian.relationship,
  guardian_photo_path: props.guardian.guardian_photo_path,
  birth: props.guardian.birth,
  gender: props.guardian.gender,
  blood: props.guardian.blood,
  mobile_number: props.guardian.mobile_number,
  company_name: props.guardian.company_name,
  company_phone_number: props.guardian.company_phone_number,
});

// 血液型
const bloodOptions = [
  { value: "A型", label: "A型" },
  { value: "B型", label: "B型" },
  { value: "O型", label: "O型" },
  { value: "AB型", label: "AB型" },
  { value: "不明", label: "不明" },
  { value: "未回答", label: "未回答" },
];

// 生徒画像
const inputFile = ref(null);

function handleFileUpload(event) {
  const files = event.target.files;
  if (files.length) {
    const formData = new FormData();
    formData.append("guardian_photo_path", files[0]);
    form.guardian_photo_path = formData;
  }
}

// クリアボタンの動作
function clearForm() {
  form.lastname = "";
  form.firstname = "";
  form.lastname_kana = "";
  form.firstname_kana = "";
  form.relationship = "";
  form.guardian_photo_path = "";
  form.birth = "";
  form.gender = "";
  form.blood = "";
  form.mobile_number = "";
  form.company_name = "";
  form.company_phone_number = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    form.lastname &&
    form.firstname &&
    form.lastname_kana &&
    form.firstname_kana &&
    form.relationship &&
    form.gender &&
    form.mobile_number;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const update = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "更新中";
    form.post(route("admin.guardian.update", guardian.id), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="保護者管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="保護者管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Guardian', url: route('admin.guardian.index') },
            { name: 'Edit', url: route('admin.guardian.edit', guardian.id) },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <UserLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="保護者編集画面" />
          <PageDescription description="保護者を編集することができます。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.guardian.index')"
            ><Back />保護者一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <div class="space-y-6">
              <!-- Form -->
              <form @submit.prevent="update" class="space-y-6">
                <div class="flex flex-col lg:flex-row gap-5">
                  <div class="w-full sm:w-2/3 max-w-[560px] sm:max-w-full space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="lastname" value="名前(姓)" required />
                        <TextInput
                          id="lastname"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.lastname"
                          @blur="validateLastname(form)"
                          placeholder="名前(姓)を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.lastname"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel for="firstname" value="名前(名)" required />
                        <TextInput
                          id="firstname"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.firstname"
                          @blur="validateFirstname(form)"
                          placeholder="名前(名)を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.firstname"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="lastname_kana"
                          value="フリガナ(セイ)"
                          required
                        />
                        <TextInput
                          id="lastname_kana"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.lastname_kana"
                          @blur="validateLastnameKana(form)"
                          placeholder="フリガナ(セイ)を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.lastname_kana"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="firstname_kana"
                          value="フリガナ(メイ)"
                          required
                        />
                        <TextInput
                          id="firstname"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.firstname_kana"
                          @blur="validateFirstnameKana(form)"
                          placeholder="フリガナ(メイ)を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.firstname_kana"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="relationship" value="関係性" required />
                        <TextInput
                          id="relationship"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.relationship"
                          @blur="validateRelationship(form)"
                          placeholder="関係性を入力してください。"
                          required
                        />
                        <InputError class="mt-2" :message="form.errors.relationship" />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="birth" value="生年月日"/>
                        <TextInput
                          id="birth"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.birth"
                          @blur="validateBirth(form)"
                          placeholder="生年月日を入力してください。"
                        />
                        <InputError class="mt-2" :message="form.errors.birth" />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-full">
                        <InputLabel for="blood" value="血液型" />
                        <RadioInput
                          id="blood"
                          name="blood"
                          v-model="form.blood"
                          @blur="validateBlood(form)"
                          :options="bloodOptions"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.blood"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="mobile_number"
                          value="携帯電話番号"
                          required
                        />
                        <TextInput
                          id="mobile_number"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.mobile_number"
                          @blur="validateMobileNumber(form)"
                          placeholder="携帯電話を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.mobile_number"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="company_name"
                          value="会社名番"
                        />
                        <TextInput
                          id="company_name"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.company_name"
                          @blur="validateCompanyName(form)"
                          placeholder="会社名を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.company_name"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="company_phone_number"
                          value="会社の電話番号"
                        />
                        <TextInput
                          id="company_phone_number"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.company_phone_number"
                          @blur="validateCompanyPhoneNumber(form)"
                          placeholder="会社の電話番号を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.company_phone_number"
                        />
                      </FormGroup>
                    </div>
                  </div>
                  <div class="w-full sm:w-1/3 space-y-4">
                    <FormGroup>
                      <InputLabel for="guardian_photo_path" value="保護者の画像" />
                      <ImageUpload
                        id="guardian_photo_path"
                        ref="inputFile"
                        v-model="form.guardian_photo_path"
                        @change="handleFileUpload"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.guardian_photo_path"
                      />
                    </FormGroup>
                  </div>
                </div>
                <div class="flex flex-col lg:flex-row gap-4">
                  <PrimaryButton
                    buttonActionType="submit"
                    buttonType="orange"
                    :disabled="!isFormValid"
                    ><Update class="mr-2" />登録</PrimaryButton
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
    </UserLayout>
  </AdminAuthenticatedLayout>
</template>
