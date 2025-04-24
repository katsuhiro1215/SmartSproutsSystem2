<script setup>
import { onMounted, ref, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import SettingLayout from "@/Components/SidebarLayouts/SettingLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Badge from "@/Components/Badge.vue";
import Card from "@/Components/Cards/Card.vue";
import Avatar from "@/Components/Avatar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Web from "vue-material-design-icons/Web.vue";
import Facebook from "vue-material-design-icons/Facebook.vue";
import Twitter from "vue-material-design-icons/Twitter.vue";
import Instagram from "vue-material-design-icons/Instagram.vue";
import Youtube from "vue-material-design-icons/YouTube.vue";

const props = defineProps({
  admin: Object,
  adminProfile: Object,
  adminAddresses: Array,
});
</script>

<template>
  <Head title="オーナー管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="オーナー管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Owner', url: route('admin.owner.show', ['id']) },
          ]"
        />
      </div>
    </template>
    <!-- Main Contents -->
    <SettingLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="オーナー詳細" />
          <PageDescription description="オーバー詳細を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.dashboard')"
            ><Back />ホームへ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full lg:w-1/3 xl:w-1/4">
          <template #content>
            <div class="flex flex-col items-center space-y-4">
              <Avatar
                alt="Site Logo"
                size="xl"
                :src="
                  adminProfile.admin_photo_path
                    ? adminProfile.admin_photo_path
                    : '/upload/user.png'
                "
              />
              <h3>{{ admin.username }}</h3>
              <ul class="list-none list-inside space-y-4">
                <li
                  v-if="adminProfile.website"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2"
                >
                  <h6><Web /></h6>
                  <span class="badge bg-primary rounded-pill">
                    {{ adminProfile.website }}
                  </span>
                </li>
                <li
                  v-if="adminProfile.facebook"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2"
                >
                  <h6><Facebook /></h6>
                  <span class="badge bg-primary rounded-pill">
                    {{ adminProfile.facebook }}
                  </span>
                </li>
                <li
                  v-if="adminProfile.twitter"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2"
                >
                  <h6><Twitter /></h6>
                  <span class="badge bg-primary rounded-pill">
                    {{ adminProfile.twitter }}
                  </span>
                </li>
                <li
                  v-if="adminProfile.instagram"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2"
                >
                  <h6><Instagram /></h6>
                  <span class="badge bg-primary rounded-pill">
                    {{ adminProfile.instagram }}
                  </span>
                </li>
                <li
                  v-if="adminProfile.youtube"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2"
                >
                  <h6><Youtube /></h6>
                  <span class="badge bg-primary rounded-pill">
                    {{ adminProfile.youtube }}
                  </span>
                </li>
              </ul>
            </div>
          </template>
        </Card>
        <Card class="w-full lg:w-2/3 xl:w-3/4">
          <template #content>
            <div class="space-y-4">
              <h3 class="text-lg p-3 border-b-2 border-b-orange-400">
                アカウント
              </h3>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">ユーザー名</dt>
                <dd class="w-full lg:w-3/4">{{ admin.username }}</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">メールアドレス</dt>
                <dd class="w-full lg:w-3/4">{{ admin.email }}</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">権限</dt>
                <dd class="w-full lg:w-3/4">{{ admin.role }}</dd>
              </dl>
              <h3 class="text-lg p-3 border-b-2 border-b-orange-400">
                プロフィール
              </h3>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">名前</dt>
                <dd class="w-full lg:w-3/4">{{ adminProfile.full_name }}</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">フリガナ</dt>
                <dd class="w-full lg:w-3/4">
                  {{ adminProfile.full_name_kana }}
                </dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">生年月日</dt>
                <dd class="w-full lg:w-3/4">{{ adminProfile.birth }}</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">年齢</dt>
                <dd class="w-full lg:w-3/4">{{ adminProfile.age }} 歳</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">性別</dt>
                <dd class="w-full lg:w-3/4">{{ adminProfile.gender }}</dd>
              </dl>
              <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                <dt class="w-full lg:w-1/4">携帯番号</dt>
                <dd class="w-full lg:w-3/4">
                  {{ adminProfile.mobile_number }}
                </dd>
              </dl>
              <h3 class="text-lg p-3 border-b-2 border-b-orange-400">住所</h3>
              <div
                v-for="(adminAddress, index) in adminAddresses"
                :key="adminAddress"
                class="space-y-4"
              >
               <h4>住所 - {{ index + 1 }}</h4>
                <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                  <dt class="w-full lg:w-1/4">郵便番号</dt>
                  <dd class="w-full lg:w-3/4">
                    {{ adminAddress.postalcode }}
                  </dd>
                </dl>
                <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                  <dt class="w-full lg:w-1/4">都道府県</dt>
                  <dd class="w-full lg:w-3/4">
                    {{ adminAddress.full_address }}
                  </dd>
                </dl>
                <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
                  <dt class="w-full lg:w-1/4">デフォルト</dt>
                  <dd class="w-full lg:w-3/4">
                    <Badge v-if="adminAddress.is_default == '1'" type="success">
                      Default
                    </Badge>
                    <Badge v-if="adminAddress.is_default == '0'" type="danger">
                      Not Default
                    </Badge>
                  </dd>
                </dl>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
