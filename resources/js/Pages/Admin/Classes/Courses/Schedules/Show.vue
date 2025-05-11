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
// Components - Organization
import CourseScheduleInfo from "./_components/CourseScheduleInfo.vue";
// Icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";
import Web from "vue-material-design-icons/Web.vue";
import Facebook from "vue-material-design-icons/Facebook.vue";
import Twitter from "vue-material-design-icons/Twitter.vue";
import Instagram from "vue-material-design-icons/Instagram.vue";
import Youtube from "vue-material-design-icons/YouTube.vue";

const props = defineProps({
  courseSchedule: Object,
});

const activeTab = ref("courseScheduleInfo");

const tabs = [{ name: "コーススケジュール情報", key: "courseScheduleInfo" }];

const setActiveTab = (tab) => {
  activeTab.value = tab;
};
</script>

<template>
  <Head title="コーススケジュール管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="コーススケジュール管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Course Schedule', url: route('admin.courseSchedule.index') },
            {
              name: 'Show',
              url: route('admin.courseSchedule.show', courseSchedule.id),
            },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <ClassLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="コーススケジュール詳細" />
          <PageDescription
            description="コースのスケジュールの詳細を表示する画面です。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.courseSchedule.index')"
            ><Back />店舗一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full lg:w-1/3">
          <template #content>
            <div class="flex flex-col items-center space-y-6">
              <Avatar :src="'/upload/schedule.png'" size="xl" alt="Schedule Image" />
              <h3 class="text-center mt-4">{{ courseSchedule.store.name }}</h3>
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
              <div
                class="w-full space-y-4"
                v-if="activeTab === 'courseScheduleInfo'"
              >
                <CourseScheduleInfo :courseSchedule="courseSchedule" />
              </div>
            </div>
          </template>
        </Card>
      </div>
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
