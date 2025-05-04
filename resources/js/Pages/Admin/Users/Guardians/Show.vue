<script setup>
import { onMounted, ref, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import UserLayout from "@/Components/SidebarLayouts/UserLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import Avatar from "@/Components/Avatar.vue";
// Components - Buttons
import BackButton from "@/Components/Buttons/BackButton.vue";
// Components - User
import StudentInfo from "./_components/StudentInfo.vue";
import UserInfo from "./_components/UserInfo.vue";
import GuardianInfo from "./_components/GuardianInfo.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";

const props = defineProps({
  guardian: Object,
  users: Array,
  students: Array,
});

const activeTab = ref("guardianInfo");

const tabs = [
  { name: "保護者情報", key: "guardianInfo" },
  { name: "ユーザー情報", key: "userInfo" },
  { name: "生徒情報", key: "studentInfo" },
];

const setActiveTab = (tab) => {
  activeTab.value = tab;
};
</script>

<template>
  <Head title="保護者管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="保護者管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Guardian', url: route('admin.guardian.index') },
            { name: 'Show', url: route('admin.guardian.show', guardian.id) },
          ]"
        />
      </div>
    </template>
    <!-- Main Contents -->
    <UserLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="保護者詳細" />
          <PageDescription description="保護者詳細を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.guardian.index')"
            ><Back />保護者一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full lg:w-1/3 xl:w-1/4">
          <template #content>
            <div class="flex flex-col items-center space-y-4">
              <Avatar alt="Site Logo" size="xl" :src="'/upload/parents.png'" />
              <h3>{{ guardian.full_name }}</h3>
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
              <div class="w-full space-y-4" v-if="activeTab === 'guardianInfo'">
                <GuardianInfo :guardian="guardian" />
              </div>
              <div class="w-full space-y-4" v-if="activeTab === 'userInfo'">
                <UserInfo :users="users" />
              </div>
              <div class="w-full space-y-4" v-if="activeTab === 'studentInfo'">
                <StudentInfo :students="students" />
              </div>
            </div>
          </template>
        </Card>
      </div>
    </UserLayout>
  </AdminAuthenticatedLayout>
</template>
