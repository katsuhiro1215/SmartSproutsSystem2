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
import Avatar from "@/Components/Avatar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import ListView from "@/Components/ListView.vue";
import GridView from "@/Components/GridView.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";

const props = defineProps({
  admins: Object,
  expiredAdmins: Object,
});

// Lifecycle
onMounted(() => {
  console.log("admins:", props);
});

const form = useForm({});

// Tabs
const tabs = [
  { name: "admins", label: "管理者一覧" },
  { name: "expiredAdmins", label: "削除済管理者一覧" },
];
const activeTab = ref("admins");
const viewMode = ref("list");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Admins
const currentAdmins = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreAdmin = (id) => {
  form.put(route("admin.admin.restore", id));
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
          <PageSubTitle title="管理者一覧" />
          <PageDescription
            description="管理者一覧を表示する画面です。管理者を追加するには、オーナーの許可が必要です。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.dashboard')"><Back />ホームへ戻る</BackButton>
        </div>
      </div>
      <div class="w-full flex flex-col lg:flex-row gap-5 p-5">
        <Card class="w-full">
          <template #content>
            <div class="w-full flex flex-wrap gap-2 mb-4">
              <PrimaryButton
                v-for="tab in tabs"
                :key="tab.name"
                buttonType="primary"
                :class="{ 'bg-indigo-300': activeTab === tab.name }"
                @click="switchTab(tab.name)"
              >
                {{ tab.label }}
              </PrimaryButton>
            </div>
            <div class="flex justify-between items-center mb-4">
              <div
                class="relative flex justify-start items-center md:w-2/3 lg:w-1/3"
              ></div>
              <div class="flex justify-end gap-4">
                <PrimaryButton
                  @click="viewMode = 'list'"
                  :class="{ 'bg-indigo-300': viewMode === 'list' }"
                  buttonType="pink"
                >
                  <ViewList />
                </PrimaryButton>
                <PrimaryButton
                  @click="viewMode = 'grid'"
                  :class="{ 'bg-indigo-300': viewMode === 'grid' }"
                  buttonType="info"
                  iconSrc="/upload/grid-icon.svg"
                  :iconOnly="true"
                >
                  <DotsGrid />
                </PrimaryButton>
              </div>
            </div>
            <div
              class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
            >
              <div class="p-6 w-full items-center">
                <div class="tab-content pt-0">
                  <div
                    v-for="tab in tabs"
                    :key="tab.name"
                    class="tab-pane space-y-4"
                    role="tabpanel"
                    v-show="activeTab === tab.name"
                  >
                    <!-- リスト表示 -->
                    <div v-if="viewMode === 'list'">
                      <ListView
                        :items="currentAdmins"
                        :headers="[
                          'SL',
                          '基本情報',
                          '名前',
                          '連絡先',
                          'Action',
                        ]"
                      >
                        <template #renderItem="{ item, index }">
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ index + 1 }}
                          </td>
                          <td
                            class="flex items-center gap-3 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white p-4"
                          >
                            <Avatar
                              :src="
                                item.admin_profile.admin_photo_path
                                  ? item.admin_profile.admin_photo_path
                                  : '/upload/user.png'
                              "
                              :alt="item.admin_profile.full_name"
                              size="lg"
                              class="rounded-full"
                            />
                            <div class="flex flex-col gap-1">
                              <span>
                                {{ item.username }}
                              </span>
                              <span>{{ item.email }}</span>
                            </div>
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.admin_profile.lastname }}
                            {{ item.admin_profile.firstname }}
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.admin_profile.mobile_number }}
                          </td>
                          <td
                            class="flex gap-3 p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <PrimaryButton
                              :href="route('admin.admin.show', item.id)"
                              buttonType="info"
                              class="size-10"
                            >
                              <EyeOutline />
                            </PrimaryButton>
                          </td>
                        </template>
                      </ListView>
                    </div>
                    <!-- グリッド表示 -->
                    <div v-else>
                      <GridView :items="currentAdmins.data">
                        <template #renderItem="{ item }">
                          <div class="space-y-2">
                            <div class="flex justify-center">
                              <Avatar
                                :src="
                                  item.admin_profile.admin_photo_path
                                    ? item.admin_profile.admin_photo_path
                                    : '/upload/user.png'
                                "
                                :alt="item.admin_profile.full_name"
                                size="lg"
                                class="rounded-full"
                              />
                            </div>
                            <h3
                              class="text-base font-medium text-gray-900 dark:text-white text-center"
                            >
                              {{ item.username }}
                            </h3>
                            <p
                              class="text-sm text-gray-500 dark:text-gray-400 text-center"
                            >
                              {{ item.email }}
                            </p>
                            <h4
                              class="text-sm text-gray-500 dark:text-gray-400 text-center"
                            >
                              {{ item.admin_profile.lastname }}
                              {{ item.admin_profile.firstname }}
                            </h4>
                            <p
                              class="text-sm text-gray-500 dark:text-gray-400 text-center"
                            >
                              {{ item.admin_profile.mobile_number }}
                            </p>
                            <div class="flex justify-center gap-3 mt-4">
                              <PrimaryButton
                                :href="route('admin.admin.show', item.id)"
                                buttonType="info"
                                class="size-10"
                              >
                                <EyeOutline />
                              </PrimaryButton>
                            </div>
                          </div>
                        </template>
                      </GridView>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
