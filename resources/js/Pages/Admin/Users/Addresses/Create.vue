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
import InputError from "@/Components/Forms/InputError.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// API
import YubinBango from "yubinbango-core2";
// Validation
import {
  validatePostalcode,
  validatePrefecture,
  validateCity,
  validateAddress1,
  validateAddress2,
  validatePhoneNumber,
  validateAllFields,
} from "./_components/validation";

const props = defineProps({
  user: Object,
});

// Form
const form = useForm({
  postalcode: "",
  prefecture: "",
  city: "",
  address1: "",
  address2: "",
  phone_number: "",
  is_default: true,
});

// ステータス
const isDefaultOptions = [
  { value: true, label: "メイン" },
  { value: false, label: "サブ" },
];

// クリアボタンの動作
function clearForm() {
  form.postalcode = "";
  form.prefecture = "";
  form.city = "";
  form.address1 = "";
  form.address2 = "";
  form.phone_number = "";
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
    form.postalcode &&
    form.prefecture &&
    form.city &&
    form.address1 &&
    form.address2 &&
    form.phone_number;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const store = () => {
  if (Object.keys(form.errors).length === 0) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.userAddress.store"), {
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
        <PageTitle title="ユーザー住所管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'User', url: route('admin.user.index') },
            {
              name: 'Address Create',
              url: route('admin.userAddress.create', user.id),
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
    <UserLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="ユーザー住所新規作成画面" />
          <PageDescription
            description="ユーザーの住所を新規作成することができます。"
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
                  <div class="w-full sm:w-2/3 space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                      <FormGroup class="w-full lg:w-1/3">
                        <InputLabel
                          for="postalcode"
                          value="郵便番号"
                          required
                        />
                        <TextInput
                          id="postalcode"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.postalcode"
                          @blur="validatePostalcode(form)"
                          placeholder="郵便番号を入力してください。"
                          required
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
                      <FormGroup class="w-1/3">
                        <InputLabel
                          for="prefecture"
                          value="都道府県名"
                          required
                        />
                        <TextInput
                          id="prefecture"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.prefecture"
                          @blur="validatePrefecture(form)"
                          placeholder="都道府県名を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.prefecture"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/3">
                        <InputLabel for="city" value="市区町村名" required />
                        <TextInput
                          id="city"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.city"
                          @blur="validateCity(form)"
                          placeholder="市区町村名を入力してください。"
                          required
                        />
                        <InputError class="mt-2" :message="form.errors.city" />
                      </FormGroup>
                      <FormGroup class="w-1/3">
                        <InputLabel for="address1" value="地域名" required />
                        <TextInput
                          id="address1"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.address1"
                          @blur="validateAddress1(form)"
                          placeholder="地域名を入力してください。"
                          required
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
                          required
                        />
                        <TextInput
                          id="address2"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.address2"
                          @blur="validateAddress2(form)"
                          placeholder="建物その他の住所を入力してください。"
                          required
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
                          required
                        />
                        <TextInput
                          id="phone_number"
                          type="text"
                          class="mt-1 block w-full"
                          v-model="form.phone_number"
                          @blur="validatePhoneNumber(form)"
                          placeholder="電話番号を入力してください。"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.phone_number"
                        />
                      </FormGroup>
                      <FormGroup class="w-1/2">
                        <InputLabel for="is_default" value="デフォルト" required />
                        <RadioInput
                          id="is_default"
                          name="is_default"
                          v-model="form.is_default"
                          @blur="validateIsDefault(form)"
                          :options="isDefaultOptions"
                          required
                        />
                        <InputError
                          class="mt-2"
                          :message="form.errors.isDefault"
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
