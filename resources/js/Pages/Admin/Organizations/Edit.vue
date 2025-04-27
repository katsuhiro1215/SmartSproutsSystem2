<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import SettingLayout from "@/Components/SidebarLayouts/SettingLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
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
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Save from "vue-material-design-icons/ContentSave.vue";
import Clear from "vue-material-design-icons/CloseCircleOutline.vue";
// API
import YubinBango from "yubinbango-core2";
// Validation
import {
  validateType,
  validateName,
  validateDescription,
  validateEmail,
  validatePostalcode,
  validatePrefecture,
  validateCity,
  validateAddress1,
  validateAddress2,
  validatePhoneNumber,
  validateFaxNumber,
  validateWebsiteUrl,
  validateFacebookUrl,
  validateTwitterUrl,
  validateInstagramUrl,
  validateYoutubeUrl,
  validateLineUrl,
  validateEstablishedDate,
  validateStatus,
  validateAllFields,
} from "./_components/validation";
import validationMessages from "@/Constants/validationMessages";

const props = defineProps({
  organization: Object,
});

// Form
const form = useForm({
  type: props.organization.type,
  name: props.organization.name,
  description: props.organization.description,
  email: props.organization.email,
  organization_photo_path: props.organization.organization_photo_path,
  organization_logo_path: props.organization.organization_logo_path,
  postalcode: props.organization.postalcode,
  prefecture: props.organization.prefecture,
  city: props.organization.city,
  address1: props.organization.address1,
  address2: props.organization.address2,
  phone_number: props.organization.phone_number,
  fax_number: props.organization.fax_number,
  status: Boolean(props.organization.status),
  established_date: props.organization.established_date,
  website: props.organization.website,
  facebook: props.organization.facebook,
  twitter: props.organization.twitter,
  instagram: props.organization.instagram,
  youtube: props.organization.youtube,
  line: props.organization.line,
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
  form.organization_photo_path = "";
  form.organization_logo_path = "";
  form.postalcode = "";
  form.prefecture = "";
  form.city = "";
  form.address1 = "";
  form.address2 = "";
  form.phone_number = "";
  form.fax_number = "";
  form.status = true;
  form.established_date = "";
  form.website = "";
  form.facebook = "";
  form.twitter = "";
  form.instagram = "";
  form.line = "";
  form.youtube = "";
  form.errors = {};
}

// ローディング
const isLoading = ref(false);
const loadingText = ref("");

// メールアドレスのユニーク性チェック
const checkEmailUniqueness = async () => {
  if (form.email) {
    try {
      const response = await axios.get(route("admin.organization.checkEmail"), {
        params: { email: form.email },
      });
      if (response.data.exists) {
        form.errors.email = validationMessages.common.emailUnique;
      } else {
        delete form.errors.email;
      }
    } catch (error) {
      console.error("Error checking email uniqueness:", error);
    }
  }
};

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
    form.type &&
    form.name &&
    form.description &&
    form.email &&
    form.postalcode &&
    form.prefecture &&
    form.city &&
    form.address1 &&
    form.address2 &&
    form.phone_number &&
    form.status;
  // エラーがないかをチェック
  const noErrors = Object.keys(form.errors).length === 0;

  return requiredFields && noErrors;
});

// 登録
const update = () => {
  validateAllFields(form);

  if (isFormValid.value) {
    isLoading.value = true;
    loadingText.value = "登録中";
    form.post(route("admin.organization.update", organization.id), {
      onFinish: () => {
        isLoading.value = false;
        loadingText.value = "";
      },
    });
  }
};
</script>

<template>
  <Head title="組織管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="組織管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Organization', url: route('admin.organization.index') },
            { name: 'Edit', url: route('admin.organization.edit', organization.id) },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Loading -->
    <LoadingIndicator :isLoading="isLoading" :loadingText="loadingText" />
    <!-- Main Contents -->
    <SettingLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="組織編集画面" />
          <PageDescription
            description="組織を編集することができます。編集できるのはSuperAdmin権限を持つユーザーのみです。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.organization.index')"
            ><Back />組織一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
          <template #content>
            <!-- Form -->
            <form @submit.prevent="update" class="space-y-6">
              <div class="flex flex-col lg:flex-row gap-5">
                <div class="w-full sm:w-2/3 space-y-4">
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel for="type" value="組織タイプ" required />
                      <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.type"
                        @blur="validateType(form)"
                        required
                        disabled
                      />
                      <InputError class="mt-2" :message="form.errors.type" />
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel for="name" value="組織名" required />
                      <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        @blur="validateName(form)"
                        placeholder="組織名を入力してください。"
                        required
                      />
                      <InputError class="mt-2" :message="form.errors.name" />
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel
                        for="description"
                        value="組織概要"
                        required
                      />
                      <TextArea
                        id="description"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        @blur="validateDescription(form)"
                        placeholder="組織概要を入力してください。"
                        required
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.description"
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
                        @blur="
                          validateEmail(form);
                          checkEmailUniqueness();
                        "
                        placeholder="メールアドレスを入力してください。"
                        required
                      />
                      <InputError class="mt-2" :message="form.errors.email" />
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-full lg:w-1/3">
                      <InputLabel for="postalcode" value="郵便番号" required />
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
                        class="mt-1"
                        buttonType="primary"
                        buttonSize="xl"
                        @click.prevent="fetchAddress"
                        >郵便番号から住所を検索</PrimaryButton
                      >
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-full lg:w-1/3">
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
                    <FormGroup class="w-full lg:w-1/3">
                      <InputLabel
                        for="city"
                        value="市区町村名"
                        required
                      />
                      <TextInput
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                        @blur="validateCity(form)"
                        placeholder="市区町村名を入力してください。"
                        required
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.city"
                      />
                    </FormGroup>
                    <FormGroup class="w-full lg:w-1/3">
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
                    <FormGroup>
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
                      <InputLabel for="fax_number" value="FAX番号" />
                      <TextInput
                        id="fax_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.fax_number"
                        @blur="validateFaxNumber(form)"
                        placeholder="FAX番号を入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.fax_number"
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
                    <FormGroup class="w-1/2">
                      <InputLabel for="established_date" value="設立日" />
                      <TextInput
                        id="established_date"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="form.established_date"
                        @blur="validateEstablishedDate(form)"
                        placeholder="設立日を入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.established_date"
                      />
                    </FormGroup>
                  </div>
                  <Separator />
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel for="website" value="WebサイトURL" />
                      <TextInput
                        id="website"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.website"
                        @blur="validateWebsiteUrl(form)"
                        placeholder="WebサイトのURLを入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.website"
                      />
                    </FormGroup>
                    <FormGroup class="w-1/2">
                      <InputLabel for="facebook" value="Facebook URL" />
                      <TextInput
                        id="facebook"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.facebook"
                        @blur="validateFacebookUrl(form)"
                        placeholder="FacebookのURLを入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.facebook"
                      />
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel for="twitter" value="Twitter URL" />
                      <TextInput
                        id="twitter"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.twitter"
                        @blur="validateTwitterUrl(form)"
                        placeholder="TwitterのURLを入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.twitter"
                      />
                    </FormGroup>
                    <FormGroup class="w-1/2">
                      <InputLabel for="instagram" value="Instagram URL" />
                      <TextInput
                        id="instagram"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.instagram"
                        @blur="validateInstagramUrl(form)"
                        placeholder="InstagramのURLを入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.instagram"
                      />
                    </FormGroup>
                  </div>
                  <div class="flex flex-col lg:flex-row gap-4">
                    <FormGroup class="w-1/2">
                      <InputLabel for="youtube" value="Youtube URL" />
                      <TextInput
                        id="youtube"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.youtube"
                        @blur="validateYoutubeUrl(form)"
                        placeholder="YoutubeのURLを入力してください。"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.youtube"
                      />
                    </FormGroup>
                    <FormGroup class="w-1/2">
                      <InputLabel for="line" value="LINE URL" />
                      <TextInput
                        id="line"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.line"
                        @blur="validateLineUrl(form)"
                        placeholder="LINEのURLを入力してください。"
                      />
                      <InputError class="mt-2" :message="form.errors.line" />
                    </FormGroup>
                  </div>
                </div>
                <div class="w-full sm:w-1/3 space-y-4">
                  <div class="flex flex-col gap-4">
                    <FormGroup>
                      <InputLabel
                        for="organization_photo_path"
                        value="組織画像"
                      />
                      <ImageUpload
                        id="organization_photo_path"
                        ref="inputFile"
                        v-model="form.organization_photo_path"
                        @change="handleFileUpload"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.organization_photo_path"
                      />
                    </FormGroup>
                    <FormGroup>
                      <InputLabel
                        for="organization_logo_path"
                        value="組織ロゴ画像"
                      />
                      <ImageUpload
                        id="organization_logo_path"
                        ref="inputFile"
                        v-model="form.organization_logo_path"
                        @change="handleFileUpload"
                      />
                      <InputError
                        class="mt-2"
                        :message="form.errors.organization_logo_path"
                      />
                    </FormGroup>
                  </div>
                </div>
              </div>
              <div class="flex flex-col lg:flex-row gap-4">
                <PrimaryButton
                  buttonActionType="submit"
                  buttonType="warning"
                  :disabled="!isFormValid"
                  ><Save class="mr-2" />更新</PrimaryButton
                >
                <PrimaryButton buttonType="secondary" @click="clearForm"
                  ><Clear class="mr-2" />
                  入力をクリア
                </PrimaryButton>
              </div>
            </form>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
