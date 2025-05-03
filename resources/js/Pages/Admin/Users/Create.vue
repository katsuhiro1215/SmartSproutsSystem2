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
import InputError from "@/Components/Forms/InputError.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// Validation
import {
  validateUsername,
  validateEmail,
  validatePassword,
  validatePasswordConfirmation,
  validateAllFields,
} from "./_components/validation";

const props = defineProps({

});

// Form
const form = useForm({
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
});

// クリアボタンの動作
function clearForm() {
  form.username = "";
  form.email = "";
  form.password = "";
  form.password_confirmation = "";
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
    form.username &&
    form.email &&
    form.password &&
    form.password_confirmation;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.user.store"), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="ユーザー管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="ユーザー管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'User', url: route('admin.user.index') },
            { name: 'Create', url: route('admin.user.create') },
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
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="ユーザー新規作成画面" />
          <PageDescription
            description="ユーザーを新規作成することができます。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.user.index')"
            ><Back />ユーザー一覧へ戻る</BackButton
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
                  <div class="w-full sm:w-2/3 max-w-[560px] space-y-4">
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
                          @blur="validateEmail(form)"
                          placeholder="メールアドレスを入力してください。"
                          required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="password"
                          value="パスワード"
                          required
                        />
                        <TextInput
                          id="type"
                          type="password"
                          class="mt-1 block w-full"
                          v-model="form.password"
                          @blur="validatePassword(form)"
                          placeholder="パスワードを入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.password"
                        />
                      </FormGroup>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-1/2">
                        <InputLabel
                          for="password_confirmation"
                          value="パスワード確認"
                          required
                        />
                        <div class="relative">
                          <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            @blur="validatePasswordConfirmation(form)"
                            required
                            placeholder="もう一度パスワードを入力してください。"
                          />
                          <div
                            class="absolute inset-y-0 top-1 right-0 flex items-center pr-3"
                          >
                            <EyeOutline class="h-6 w-6 text-gray-400" />
                          </div>
                        </div>
                        <InputError
                          class="mt-2"
                          :message="form.errors.password_confirmation"
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
    </UserLayout>
  </AdminAuthenticatedLayout>
</template>
