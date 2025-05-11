<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import ClassLayout from "@/Components/SidebarLayouts/ClassLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import Alert from "@/Components/Alerts/Alert.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import ListView from "@/Components/ListView.vue";
import GridView from "@/Components/GridView.vue";
import Badge from "@/Components/Badge.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import Restore from "vue-material-design-icons/Restore.vue";
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({
  allCourseSchedules: Object,
  courseSchedules: Object,
  deletedCourseSchedules: Object,
});

// Lifecycle
onMounted(() => {
  console.log("courseSchedules:", props);
});

const form = useForm({});

// Tabs
const tabs = [
  { name: "allCourseSchedules", label: "全コーススケジュール一覧" },
  { name: "courseSchedules", label: "コーススケジュール一覧" },
  { name: "deletedCourseSchedules", label: "削除済コーススケジュール一覧" },
];
const activeTab = ref("courseSchedules");
const viewMode = ref("list");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Course Schedules
const currentCourseSchedules = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreCourseSchedule = (id) => {
  form.put(route("admin.courseSchedule.restore", id));
};

// 削除処理 (削除、完全削除) --- アラート表示
const showAlert = ref(false);
const currentEntity = ref(null);
const entityType = ref("");
const requestDeletion = (entity, type) => {
  currentEntity.value = entity;
  entityType.value = type;
  showAlert.value = true;
};
const confirmDeletion = () => {
  if (entityType.value === "delete") {
    form.delete(route("admin.courseSchedule.destroy", currentEntity.value.id));
  } else if (entityType.value === "forceDelete") {
    form.delete(
      route("admin.courseSchedule.forceDelete", currentEntity.value.id)
    );
  }
  showAlert.value = false;
};
const cancelDeletion = () => {
  showAlert.value = false;
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
            {
              name: 'Course Schedule',
              url: route('admin.courseSchedule.index'),
            },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Alert -->
    <Alert
      :isVisible="showAlert"
      :message="`コーススケジュールを削除しますか？`"
      @confirm="confirmDeletion"
      @cancel="cancelDeletion"
    />
    <!-- Main Contents -->
    <ClassLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="コーススケジュール一覧" />
          <PageDescription
            description="コーススケジュール一覧を表示する画面です。"
          />
        </div>
        <div class="flex flex-wrap justify-end items-center gap-2">
          <PrimaryButton
            :href="route('admin.courseSchedule.bulkDelete')"
            buttonType="danger"
            ><TrashCanOutline
              class="mr-2"
            />コーススケジュール一括削除</PrimaryButton
          >
          <PrimaryButton
            :href="route('admin.courseSchedule.create')"
            buttonType="indigo"
            ><Plus class="mr-2" />コーススケジュール新規作成</PrimaryButton
          >
          <BackButton :href="route('admin.dashboard')"
            ><Back />ホームへ戻る</BackButton
          >
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
                        :items="currentCourseSchedules"
                        :headers="[
                          'SL',
                          '営業日',
                          '曜日',
                          '営業時間',
                          'status',
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
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.course_date }}
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.day_of_week }}
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.start_time }} - {{ item.end_time }}
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <Badge v-if="item.status == '1'" type="success">
                              OPEN
                            </Badge>
                            <Badge v-if="item.status == '0'" type="danger">
                              CLOSE
                            </Badge>
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <div class="flex gap-3">
                              <PrimaryButton
                                v-if="
                                  activeTab === 'allCourseSchedules' ||
                                  'courseSchedules'
                                "
                                :href="
                                  route('admin.courseSchedule.show', item.id)
                                "
                                buttonType="info"
                                class="size-10"
                              >
                                <EyeOutline />
                              </PrimaryButton>
                              <PrimaryButton
                                v-if="
                                  activeTab === 'allCourseSchedules' ||
                                  'courseSchedules'
                                "
                                :href="
                                  route('admin.courseSchedule.edit', item.id)
                                "
                                buttonType="warning"
                                class="size-10"
                              >
                                <NoteEdit />
                              </PrimaryButton>
                              <DangerButton
                                v-if="
                                  activeTab === 'allCourseSchedules' ||
                                  'courseSchedules'
                                "
                                @click="requestDeletion(item, 'delete')"
                                buttonType="danger"
                                class="size-10"
                              >
                                <TrashCanOutline />
                              </DangerButton>
                              <PrimaryButton
                                v-if="activeTab === 'deletedCourseSchedules'"
                                @click="restoreCourseSchedule(item.id)"
                                buttonType="success"
                              >
                                <Restore class="mr-2" />
                                <span>復活</span>
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'deletedCourseSchedules'"
                                @click="requestDeletion(item, 'forceDelete')"
                                buttonType="danger"
                              >
                                <TrashCanOutline class="mr-2" />
                                <span>完全削除</span>
                              </DangerButton>
                            </div>
                          </td>
                        </template>
                      </ListView>
                    </div>
                    <!-- グリッド表示 -->
                    <div v-else>
                      <GridView :items="currentCourseSchedules.data">
                        <template #renderItem="{ item }">
                          <div class="space-y-2">
                            <h3
                              class="text-base font-medium text-gray-900 dark:text-white text-center"
                            >
                              {{ item.course_date }} ( {{ item.day_of_week }} )
                            </h3>
                            <div class="flex justify-center"></div>
                            <div class="flex justify-center gap-3 mt-4">
                              <PrimaryButton
                                :href="
                                  route('admin.courseSchedule.show', item.id)
                                "
                                buttonType="info"
                                class="size-10"
                              >
                                <EyeOutline />
                              </PrimaryButton>
                              <PrimaryButton
                                :href="
                                  route('admin.courseSchedule.edit', item.id)
                                "
                                buttonType="warning"
                                class="size-10"
                              >
                                <NoteEdit />
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'courseSchedules'"
                                @click="requestDeletion(item, 'delete')"
                                buttonType="danger"
                                class="size-10"
                              >
                                <TrashCanOutline />
                              </DangerButton>
                              <PrimaryButton
                                v-if="activeTab === 'deletedCourseSchedules'"
                                @click="restoreCourseSchedule(item.id)"
                                buttonType="success"
                              >
                                <Restore class="mr-2" />
                                <span>復活</span>
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'deletedCourseSchedules'"
                                @click="requestDeletion(item, 'forceDelete')"
                                buttonType="danger"
                              >
                                <TrashCanOutline class="mr-2" />
                                <span>完全削除</span>
                              </DangerButton>
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
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
