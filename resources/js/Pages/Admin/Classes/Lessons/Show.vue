<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";
//Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import ClassLayout from "@/Components/SidebarLayouts/ClassLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Avatar from "@/Components/Avatar.vue";
import Pagination from "@/Components/Pagination.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - Lesson
import LessonInfo from "./_components/LessonInfo.vue";
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
  lesson: Object,
});

const activeTab = ref("lessonInfo");

const tabs = [
  { name: "レッスン情報", key: "lessonInfo" },
];

const setActiveTab = (tab) => {
  activeTab.value = tab;
};
</script>

<template>
  <Head title="レッスン管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="レッスン管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Lesson', url: route('admin.lesson.index') },
            { name: 'Show', url: route('admin.lesson.show', lesson.id) },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <ClassLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="店舗詳細" />
          <PageDescription description="店舗の詳細を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.store.index')"
            ><Back />店舗一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full lg:w-1/3">
          <template #content>
            <div class="flex flex-col items-center space-y-6">
              <Avatar
                :src="
                  lesson.lesson_photo_path
                    ? `/storage/lessons/${lesson.lesson_photo_path}`
                    : '/upload/sports.png'
                "
                size="xl"
                alt="Site Logo"
              />
              <h3 class="text-center mt-4">{{ lesson.name }}</h3>
            </div>
          </template>
        </Card>
        <Card class="w-full lg:w-2/3">
          <template #content>
            <div class="w-full space-y-6">
              <ul
                class="flex justify-around bg-slate-200 dark:bg-slate-700 p-4"
              >
                <li v-for="tab in tabs" :key="tab.key">
                  <a
                    href="#"
                    :class="{
                      'text-gray-500 dark:text-gray-400': activeTab !== tab.key,
                      'text-blue-500 dark:text-blue-400': activeTab === tab.key,
                    }"
                    @click.prevent="setActiveTab(tab.key)"
                  >
                    {{ tab.name }}
                  </a>
                </li>
              </ul>
              <div class="w-full space-y-4" v-if="activeTab === 'lessonInfo'">
                <LessonInfo :lesson="lesson" />
              </div>
            </div>
          </template>
        </Card>
      </div>
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
