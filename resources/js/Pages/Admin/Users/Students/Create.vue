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
import TextArea from "@/Components/Forms/TextArea.vue";
import RadioInput from "@/Components/Forms/RadioInput.vue";
import ImageUpload from "@/Components/Forms/ImageUpload.vue";
import InputError from "@/Components/Forms/InputError.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateMemberOptionId,
  validateLastname,
  validateFirstname,
  validateLastnameKana,
  validateFirstnameKana,
  validateBirth,
  validateGender,
  validateBlood,
  validateMobileNumber,
  validateMobileNumberRelationship,
  validatePersonalHistory,
  validateMemberNo,
  validateSerialNo,
  validatePermissionPhoto,
  validatePermissionDm,
  validateRemarks,
  validateAllFields,
} from "./_components/validation";

// Props
const props = defineProps({
  membershipOptions: Array,
});

// Form
const form = useForm({
  lastname: "",
  firstname: "",
  lastname_kana: "",
  firstname_kana: "",
  student_photo_path: "",
  birth: "",
  gender: "",
  blood: "未回答",
  mobile_number: "",
  mobile_number_relationship: "",
  personal_history: "",
  membership_option_id: 1,
  member_no: "",
  serial_no: "",
  permission_photo: true,
  permission_dm: true,
  remarks: "",
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

// 写真許可
const permissionPhotoOptions = [
  { value: true, label: "はい" },
  { value: false, label: "いいえ" },
];

// DM許可
const permissionDmOptions = [
  { value: true, label: "はい" },
  { value: false, label: "いいえ" },
];

// 生徒画像
const inputFile = ref(null);

function handleFileUpload(event) {
  const files = event.target.files;
  if (files.length) {
    const formData = new FormData();
    formData.append("student_photo_path", files[0]);
    form.student_photo_path = formData;
  }
}

// クリアボタンの動作
function clearForm() {
  form.lastname = "";
  form.firstname = "";
  form.lastname_kana = "";
  form.firstname_kana = "";
  form.student_photo_path = "";
  form.birth = "";
  form.gender = "";
  form.blood = "";
  form.mobile_number = "";
  form.mobile_number_relationship = "";
  form.personal_history = "";
  form.member_no = "";
  form.membership_status = "";
  form.serial_no = "";
  form.permission_photo = "";
  form.permission_dm = "";
  form.remarks = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    form.membership_option_id &&
    form.lastname &&
    form.firstname &&
    form.lastname_kana &&
    form.firstname_kana &&
    form.student_photo_path &&
    form.birth &&
    form.gender &&
    form.blood &&
    form.mobile_number &&
    form.mobile_number_relationship &&
    form.personal_history &&
    form.membership_status &&
    form.permission_photo &&
    form.permission_dm;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.student.store"), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="生徒管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="生徒管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Student', url: route('admin.student.index') },
            { name: 'Create', url: route('admin.student.create') },
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
          <PageSubTitle title="生徒新規作成画面" />
          <PageDescription description="生徒を新規作成することができます。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.student.index')"
            ><Back />生徒一覧へ戻る</BackButton
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
                        <InputLabel for="birth" value="生年月日" required />
                        <TextInput
                          id="birth"
                          type="date"
                          class="mt-1 block w-full"
                          v-model="form.birth"
                          @blur="validateBirth(form)"
                          placeholder="生年月日を入力してください。"
                          required
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
                          for="mobile_number"
                          value="緊急連絡先"
                          required
                        />
                        <TextInput
                          id="mobile_number"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.mobile_number"
                          @blur="validateMobileNumber(form)"
                          placeholder="緊急連絡先を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.mobile_number"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="mobile_number_relationship"
                          value="緊急連絡先の続柄"
                          required
                        />
                        <TextInput
                          id="mobile_number_relationship"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.mobile_number_relationship"
                          @blur="validateMobileNumberRelationship(form)"
                          placeholder="緊急連絡先の続柄を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.mobile_number_relationship"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-full">
                        <InputLabel
                          for="personal_history"
                          value="既往歴"
                          required
                        />
                        <TextArea
                          id="personal_history"
                          class="mt-1 block w-full"
                          v-model="form.personal_history"
                          @blur="validatePersonalHistory(form)"
                          placeholder="既往歴を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.personal_history"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="membership_status"
                          value="会員種別"
                          required
                        />
                        <RadioInput
                          id="membership_option_id"
                          name="membership_option_id"
                          v-model="form.membership_option_id"
                          @blur="validateMembershipOptionId(form)"
                          :options="membershipOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.membership_status"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel for="member_no" value="会員番号" />
                        <TextInput
                          id="member_no"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.member_no"
                          @blur="validateMemberNo(form)"
                          placeholder="会員番号を入力してください。"
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.member_no"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="serial_no"
                          value="シリアル番号"
                        />
                        <TextInput
                          id="serial_no"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.serial_no"
                          @blur="validateSerialNo(form)"
                          placeholder="シリアル番号を入力してください。"
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
                          for="permission_photo"
                          value="写真の使用許可"
                          required
                        />
                        <RadioInput
                          id="permission_photo"
                          name="permission_photo"
                          v-model="form.permission_photo"
                          @blur="validatePermissionPhoto(form)"
                          :options="permissionPhotoOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.permission_photo"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="permission_dm"
                          value="DMの使用許可"
                          required
                        />
                        <RadioInput
                          id="permission_dm"
                          name="permission_dm"
                          v-model="form.permission_dm"
                          @blur="validatePermissionDm(form)"
                          :options="permissionDmOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.permission_dm"
                        />
                      </FormGroup>
                    </div>
                  </div>
                  <div class="w-full sm:w-1/3 space-y-4">
                    <FormGroup>
                      <InputLabel for="student_photo_path" value="生徒写真" />
                      <ImageUpload
                        id="student_photo_path"
                        ref="inputFile"
                        v-model="form.student_photo_path"
                        @change="handleFileUpload"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.student_photo_path"
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
          </template>
        </Card>
      </div>
    </UserLayout>
  </AdminAuthenticatedLayout>
</template>
