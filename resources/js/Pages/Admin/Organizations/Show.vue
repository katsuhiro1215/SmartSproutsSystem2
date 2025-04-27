<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";
//Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import SettingLayout from "@/Components/SidebarLayouts/SettingLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Avatar from "@/Components/Avatar.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - Organization
import OrganizationInfo from "./_components/OrganizationInfo.vue";
import AdminInfo from "./_components/AdminInfo.vue";
import StoreInfo from "./_components/StoreInfo.vue";
// Icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";
import Web from "vue-material-design-icons/Web.vue";
import Facebook from "vue-material-design-icons/Facebook.vue";
import Twitter from "vue-material-design-icons/Twitter.vue";
import Instagram from "vue-material-design-icons/Instagram.vue";
import Youtube from "vue-material-design-icons/YouTube.vue";

const props = defineProps({
  organization: Object,
  stores: Array,
  admins: Array,
});

const activeTab = ref("organizationInfo");

const tabs = [
  { name: "組織情報", key: "organizationInfo" },
  { name: "管理者情報", key: "adminInfo" },
  { name: "店舗情報", key: "storeInfo" },
];

const setActiveTab = (tab) => {
  activeTab.value = tab;
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
            {
              name: 'Show',
              url: route('admin.organization.show', organization.id),
            },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <SettingLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="組織詳細" />
          <PageDescription description="組織の詳細を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.organization.index')"
            ><Back />組織一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full lg:w-1/3">
          <template #content>
            <div class="flex flex-col items-center space-y-6">
              <Avatar
                :src="
                    organization.organization_photo_path
                      ? `/storage/organizations/${organization.organization_photo_path}`
                      : '/upload/workspace.png'
                  "
                size="xl"
                alt="Site Logo"
              />
              <h3 class="text-center mt-4">{{ organization.name }}</h3>
              <ul class="w-full list-none list-inside space-y-4">
                <li
                  v-if="organization.website"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2 p-2"
                >
                  <h6 class="flex items-center gap-1"><Web /><span>Website</span></h6>
                  <span class="badge bg-primary rounded-pill text-sm">
                    {{ organization.website }}
                  </span>
                </li>
                <li
                  v-if="organization.facebook"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2 p-2"
                >
                  <h6 class="flex items-center gap-1"><Facebook /><span>Facebook</span></h6>
                  <span class="badge bg-primary rounded-pill text-sm">
                    {{ organization.facebook }}
                  </span>
                </li>
                <li
                  v-if="organization.twitter"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2 p-2"
                >
                  <h6 class="flex items-center gap-1"><Twitter /><span>Twitter</span></h6>
                  <span class="badge bg-primary rounded-pill text-sm">
                    {{ organization.twitter }}
                  </span>
                </li>
                <li
                  v-if="organization.instagram"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2 p-2"
                >
                  <h6 class="flex items-center gap-1"><Instagram /><span>Instagram</span></h6>
                  <span class="badge bg-primary rounded-pill text-sm">
                    {{ organization.instagram }}
                  </span>
                </li>
                <li
                  v-if="organization.youtube"
                  class="flex flex-col md:flex-row md:justify-between items-center flex-wrap gap-2 p-2"
                >
                  <h6 class="flex items-center gap-1"><Youtube /><span>YouTube</span></h6>
                  <span class="badge bg-primary rounded-pill text-sm">
                    {{ organization.youtube }}
                  </span>
                </li>
              </ul>
            </div>
          </template>
        </Card>
        <Card class="w-full lg:w-2/3">
          <template #content>
            <div class="w-full space-y-6">
              <ul
                class="flex justify-start"
              >
                <li v-for="tab in tabs" :key="tab.key">
                  <a
                    href="#"
                    :class="{
                      'block text-gray-500 dark:text-gray-400 rounded-md px-4 py-3': activeTab !== tab.key,
                      'block bg-blue-400 text-white rounded-md px-4 py-3': activeTab === tab.key,
                    }"
                    @click.prevent="setActiveTab(tab.key)"
                  >
                    {{ tab.name }}
                  </a>
                </li>
              </ul>
              <div
                class="w-full space-y-4"
                v-if="activeTab === 'organizationInfo'"
              >
                <OrganizationInfo :organization="organization" />
              </div>
              <div class="w-full space-y-4" v-if="activeTab === 'adminInfo'">
                <AdminInfo :organization="organization" />
              </div>
              <div class="w-full space-y-4" v-if="activeTab === 'storeInfo'">
                <StoreInfo :organization="organization" />
              </div>
            </div>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
