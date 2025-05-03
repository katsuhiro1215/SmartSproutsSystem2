<script setup>
import { onMounted, ref, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import EmployeeLayout from "@/Components/SidebarLayouts/EmployeeLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import Avatar from "@/Components/Avatar.vue";
import Alert from "@/Components/Alerts/Alert.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import ListView from "@/Components/ListView.vue";
import GridView from "@/Components/GridView.vue";
import Pagination from "@/Components/Pagination.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";

const props = defineProps({
  employees: Array,
  others: Array,
  expiredEmployees: Array,
  expiredOthers: Array,
});

// Lifecycle
onMounted(() => {
  console.log("employees:", props);
});

const form = useForm({});

// Tabs
const tabs = [
  { name: "employees", label: "従業員一覧" },
  { name: "others", label: "その他一覧" },
  { name: "expiredEmployees", label: "削除済従業員一覧" },
  { name: "expiredOthers", label: "削除済その他一覧" },
];
const activeTab = ref("employees");
const viewMode = ref("list");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Employees
const currentEmployees = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreEmployee = (id) => {
  form.put(route("admin.employee.restore", id));
};
</script>

<template>
  <Head title="従業員管理" />

  <AdminAuthenticatedLayout>
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="従業員管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Employee', url: route('admin.employee.index') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <EmployeeLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="従業員一覧" />
          <PageDescription
            description="従業員一覧を表示する画面です。従業員を編集するには、Managerの許可が必要です。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <PrimaryButton buttonType="success">Export</PrimaryButton>
          <PrimaryButton buttonType="success">Import</PrimaryButton>
          <PrimaryButton
            :href="route('admin.employee.create')"
            buttonActionType="button"
            buttonType="indigo"
            ><Plus />新規作成</PrimaryButton
          >
          <div class="flex justify-end items-center gap-2">
            <BackButton :href="route('admin.dashboard')"
              ><Back />ホームへ戻る</BackButton
            >
          </div>
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
                        :items="currentEmployees"
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
                                item.admin_profile &&
                                item.admin_profile.admin_photo_path
                                  ? item.admin_profile.admin_photo_path
                                  : '/upload/user.png'
                              "
                              :alt="
                                item.admin_profile &&
                                item.admin_profile.full_name
                                  ? item.admin_profile.full_name
                                  : ''
                              "
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
                            {{
                              item.admin_profile && item.admin_profile.lastname
                                ? item.admin_profile.lastname
                                : ""
                            }}
                            {{
                              item.admin_profile && item.admin_profile.firstname
                                ? item.admin_profile.firstname
                                : ""
                            }}
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{
                              item.admin_profile &&
                              item.admin_profile.mobile_number
                                ? item.admin_profile.mobile_number
                                : ""
                            }}
                          </td>
                          <td
                            class="flex gap-3 p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <PrimaryButton
                              :href="route('admin.employee.show', item.id)"
                              buttonType="info"
                              class="size-10"
                            >
                              <EyeOutline />
                            </PrimaryButton>
                            <PrimaryButton
                              :href="route('admin.employee.edit', item.id)"
                              buttonType="orange"
                              class="size-10"
                            >
                              <NoteEdit />
                            </PrimaryButton>
                          </td>
                        </template>
                      </ListView>
                    </div>
                    <!-- グリッド表示 -->
                    <div v-else>
                      <GridView :items="currentEmployees.data">
                        <template #renderItem="{ item }">
                          <div class="space-y-2">
                            <div class="flex justify-center">
                              <Avatar
                                :src="
                                  item.admin_profile &&
                                  item.admin_profile.admin_photo_path
                                    ? item.admin_profile.admin_photo_path
                                    : '/upload/user.png'
                                "
                                :alt="
                                  item.admin_profile &&
                                  item.admin_profile.full_name
                                    ? item.admin_profile.full_name
                                    : ''
                                "
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
                              {{ item.admin_profile && item.admin_profile.lastname ? item.admin_profile.lastname : '' }}
                              {{ item.admin_profile && item.admin_profile.firstname ? item.admin_profile.firstname : '' }}
                            </h4>
                            <p
                              class="text-sm text-gray-500 dark:text-gray-400 text-center"
                            >
                              {{ item.admin_profile && item.admin_profile.mobile_number ? item.admin_profile.mobile_number : '' }}
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
                    <div class="flex justify-between items-center">
                      <div class="flex items-center dark:text-white">
                        <div class="mr-2">
                          <span>{{ props[activeTab].current_page }}</span
                          >ページ / <span>{{ props[activeTab].last_page }}</span
                          >ページ中
                        </div>
                      </div>
                      <Pagination :links="props[activeTab].links"></Pagination>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </EmployeeLayout>
  </AdminAuthenticatedLayout>
</template>
