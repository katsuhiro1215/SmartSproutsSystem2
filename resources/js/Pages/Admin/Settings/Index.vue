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
import Card from "@/Components/Cards/Card.vue";
import Avatar from "@/Components/Avatar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import SettingSidebarLink from "@/Components/SidebarNavigationLinks/SettingSidebarLink.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - Forms
//icon
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({});
</script>

<template>
  <Head title="各種設定管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="各種設定管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Setting', url: route('admin.setting.index') },
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
          <PageSubTitle title="各種設定一覧" />
          <PageDescription description="各種設定一覧を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2"></div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full">
          <template #content>
            <div class="flex flex-col gap-5 lg:flex-row">
              <div class="w-40 flex justify-center">
                <Avatar alt="Site Logo" size="w-16 h-16" />
              </div>
              <div class="w-[calc(100%-160px)] flex flex-col gap-2">
                <h3 class="text-lg font-bold">サイト情報</h3>
                <p class="text-sm text-gray-500">
                  サイトの基本情報を表示します。
                </p>
                <p class="text-sm text-gray-500">
                  サイトの基本情報を編集するには、オーナーの許可が必要です。
                </p>
                <dl class="flex flex-col lg:flex-row gap-2">
                  <dt class="w-60">サイト名</dt>
                  <dd>Smart Sprouts</dd>
                </dl>
                <dl class="flex flex-col lg:flex-row gap-2">
                  <dt class="w-60">サイトURL</dt>
                  <dd>https://smartsprouts.jp</dd>
                </dl>
                <dl class="flex flex-col lg:flex-row gap-2">
                  <dt class="w-60">サイト説明</dt>
                  <dd>
                    Smart
                    Sproutsは、あなたの成長をサポートするためのプラットフォームです。
                  </dd>
                </dl>
                <dl class="flex flex-col lg:flex-row gap-2">
                  <dt class="w-60">サイトロゴ</dt>
                  <dd></dd>
                </dl>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
