<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
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
  allStudents: Object,
  students: Object,
  deletedStudents: Object,
});

// Lifecycle
onMounted(() => {
  console.log("students:", props);
});

const form = useForm({});

// Tabs
const tabs = [
  { name: "allStudents", label: "全生徒一覧" },
  { name: "students", label: "生徒一覧" },
  { name: "deletedStudents", label: "削除済生徒一覧" },
];
const activeTab = ref("students");
const viewMode = ref("list");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Students
const currentStudents = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreStudent = (id) => {
  form.put(route("admin.student.restore", id));
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
    form.delete(route("admin.student.destroy", currentEntity.value.id));
  } else if (entityType.value === "forceDelete") {
    form.delete(route("admin.student.forceDelete", currentEntity.value.id));
  }
  showAlert.value = false;
};
const cancelDeletion = () => {
  showAlert.value = false;
};
</script>

<template>
  <Head title="生徒管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="生徒管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Student', url: route('admin.student.index') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Alert -->
    <Alert
      :isVisible="showAlert"
      :message="`生徒を削除しますか？`"
      @confirm="confirmDeletion"
      @cancel="cancelDeletion"
    />
    <!-- Main Contents -->
    <UserLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="生徒一覧" />
          <PageDescription description="生徒一覧を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <PrimaryButton
            :href="route('admin.student.create')"
            buttonType="indigo"
            ><Plus />生徒新規作成</PrimaryButton
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
                        :items="currentStudents"
                        :headers="['SL', '基本情報', '会員種別', 'Action']"
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
                              :src="'/upload/user.png'"
                              :alt="item.full_name"
                              size="lg"
                              class="rounded-full"
                            />
                            <div class="flex flex-col gap-1">
                              <span>
                                {{ item.full_name }}
                              </span>
                            </div>
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <Badge
                              v-if="item.membershipOption.name == '会員'"
                              type="success"
                            >
                              会員
                            </Badge>
                            <Badge
                              v-if="item.membershipOption.name == '非会員'"
                              type="danger"
                            >
                              非会員
                            </Badge>
                            <Badge
                              v-if="item.membershipOption.name == '仮会員'"
                              type="info"
                            >
                              仮会員
                            </Badge>
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <div class="flex gap-3">
                              <PrimaryButton
                                v-if="activeTab === 'students'"
                                :href="route('admin.student.show', item.id)"
                                buttonType="info"
                                class="size-10"
                              >
                                <EyeOutline />
                              </PrimaryButton>
                              <PrimaryButton
                                v-if="activeTab === 'students'"
                                :href="route('admin.student.edit', item.id)"
                                buttonType="warning"
                                class="size-10"
                              >
                                <NoteEdit />
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'students'"
                                @click="requestDeletion(item, 'delete')"
                                buttonType="danger"
                                class="size-10"
                              >
                                <TrashCanOutline />
                              </DangerButton>
                              <PrimaryButton
                                v-if="activeTab === 'deletedStudents'"
                                @click="restoreStudent(item.id)"
                                buttonType="success"
                              >
                                <Restore class="mr-2" />
                                <span>復活</span>
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'deletedStudents'"
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
                      <GridView :items="currentStudents.data">
                        <template #renderItem="{ item }">
                          <div class="space-y-2">
                            <div class="flex justify-center">
                              <Avatar
                                :src="'/upload/children.png'"
                                :alt="item.full_name"
                                size="lg"
                                class="rounded-full"
                              />
                            </div>
                            <h3
                              class="text-base font-medium text-gray-900 dark:text-white text-center"
                            >
                              {{ item.full_name }}
                            </h3>
                            <div class="flex justify-center">
                              <Badge
                                v-if="item.membershipOption.name == '会員'"
                                type="success"
                              >
                                会員
                              </Badge>
                              <Badge
                                v-if="item.membershipOption.name == '非会員'"
                                type="danger"
                              >
                                非会員
                              </Badge>
                              <Badge
                                v-if="item.membershipOption.name == '仮会員'"
                                type="info"
                              >
                                仮会員
                              </Badge>
                            </div>
                            <div class="flex justify-center gap-3 mt-4">
                              <PrimaryButton
                                v-if="activeTab === 'students'"
                                :href="route('admin.student.show', item.id)"
                                buttonType="info"
                                class="size-10"
                              >
                                <EyeOutline />
                              </PrimaryButton>
                              <PrimaryButton
                                v-if="activeTab === 'students'"
                                :href="route('admin.student.edit', item.id)"
                                buttonType="warning"
                                class="size-10"
                              >
                                <NoteEdit />
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'students'"
                                @click="requestDeletion(item, 'delete')"
                                buttonType="danger"
                                class="size-10"
                              >
                                <TrashCanOutline />
                              </DangerButton>
                              <PrimaryButton
                                v-if="activeTab === 'deletedStudents'"
                                @click="restoreUser(item.id)"
                                buttonType="success"
                              >
                                <Restore class="mr-2" />
                                <span>復活</span>
                              </PrimaryButton>
                              <DangerButton
                                v-if="activeTab === 'deletedStudents'"
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
    </UserLayout>
  </AdminAuthenticatedLayout>
</template>
