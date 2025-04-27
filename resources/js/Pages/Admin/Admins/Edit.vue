<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import SettingLayout from "@/Components/SidebarLayouts/SettingLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import AdminAlert from "@/Components/Alerts/AdminAlert.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import LoadingIndicator from "@/Components/Loadings/LoadingIndicator.vue";
import Separator from "@/Components/Separator.vue";
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
import Update from "vue-material-design-icons/Update.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// API
import YubinBango from "yubinbango-core2";
// Validation
import {
  validateOrganizationId,
  validateUsername,
  validateEmail,
  validateRole,
  validateAllFields,
} from "./_components/validation";

const props = defineProps({
  admin: Object,
  organizations: Array,
  relatedOrganizationIds: Array,
});

// Form
const form = useForm({
  organization_id: null,
  username: props.admin.username,
  email: props.admin.email,
  role: props.admin.role,
});

onMounted(() => {
  // Adminが関連付けられている最初のOrganizationのIDをセット
  form.organization_id = props.relatedOrganizationIds[0] || null;
});

// ステータス
const roleOptions = [
  { value: "SuperAdmin", label: "SuperAdmin" },
  { value: "Admin", label: "Admin" },
  { value: "SubAdmin", label: "SubAdmin" },
];

// クリアボタンの動作
function clearForm() {
  form.organization_id = props.defaultOrganizationId;
  form.username = "";
  form.email = "";
  form.password = "";
  form.password_confirmation = "";
  form.role = "Admin";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// ボタンの状態
const isFormValid = computed(() => {
  // 必須フィールドがすべて入力されているかをチェック
  const requiredFields =
    // form.organization_id &&
    form.username && form.email && form.role;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 更新
const update = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "更新中";
    form.put(route("admin.admin.update", props.admin.id), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="管理者管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="管理者管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Admin', url: route('admin.admin.index') },
            { name: 'Edit', url: route('admin.admin.edit', admin.id) },
          ]"
        />
      </div>
    </template>
    <!-- Alert (後で実装) -->
    <AdminAlert />
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <SettingLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="管理者編集画面" />
          <PageDescription
            description="管理者を編集することができます。オーナーのみが編集することができます。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.admin.index')"
            ><Back />管理者一覧へ戻る</BackButton
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
                  <div class="w-full sm:w-2/3 max-w-[560px] space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="organization_id"
                          value="組織名"
                          required
                        />
                        <RadioInput
                          id="organization_id"
                          name="organization_id"
                          v-model="form.organization_id"
                          @blur="validateOrganizationId(form)"
                          :options="organizations"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.organization_id"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel for="role" value="権限" required />
                        <RadioInput
                          id="role"
                          name="role"
                          v-model="form.role"
                          @blur="validateRole(form)"
                          :options="roleOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.organization_id"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="username"
                          value="ユーザー名"
                          required
                        />
                        <TextInput
                          id="username"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.username"
                          @blur="validateUsername(form)"
                          placeholder="ユーザー名を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.username"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="email"
                          value="メールアドレス"
                          required
                        />
                        <TextInput
                          id="type"
                          type="email"
                          class="mt-1 block w-full"
                          v-model="form.email"
                          @blur="validateEmail(form, props.admin.id)"
                          placeholder="メールアドレスを入力してください。"
                          required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
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
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
