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
import FlashMessage from "@/Components/FlashMessage.vue";
import PageSizeSelector from "@/Components/PageSizeSelector.vue";
import ListView from "@/Components/ListView.vue";
import GridView from "@/Components/GridView.vue";
import Avatar from "@/Components/Avatar.vue";
import Badge from "@/Components/Badge.vue";
import Pagination from "@/Components/Pagination.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
// Components - Form
import TextInput from "@/Components/Forms/TextInput.vue";
//icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";
import ViewList from "vue-material-design-icons/ViewList.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";

// Props
const props = defineProps({
  allLessons: Object,
  lessons: Object,
  deletedLessons: Object,
});

// Lifecycle
onMounted(() => {
  console.log("allLessons:", props);
});

// Form
const form = useForm({});

// Tabs
const tabs = [
  { name: "allLessons", label: "全レッスン一覧" },
  { name: "lessons", label: "レッスン一覧" },
  { name: "deletedLessons", label: "削除済レッスン一覧" },
];
const activeTab = ref("allLessons");
const viewMode = ref("list");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Lessons
const currentLessons = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreLesson = (id) => {
  form.put(route("admin.lesson.restore", id));
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
    form.delete(route("admin.lesson.destroy", currentEntity.value.id));
  } else if (entityType.value === "forceDelete") {
    form.delete(route("admin.lesson.forceDelete", currentEntity.value.id));
  }
  showAlert.value = false;
};
const cancelDeletion = () => {
  showAlert.value = false;
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
          <PageSubTitle title="レッスン一覧" />
          <PageDescription description="レッスン一覧を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <PrimaryButton
            :href="route('admin.lesson.create')"
            buttonType="indigo"
            ><Plus />レッスン新規作成</PrimaryButton
          >
          <BackButton :href="route('admin.class.index')"
            ><Back />戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5">
        <Card>
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
              >
                <TextInput
                  id="search"
                  type="text"
                  name="search"
                  class="block w-full"
                  placeholder="検索してください。"
                  v-model="search"
                />
                <PrimaryButton
                  @click="searchSchools"
                  buttonActionType="button"
                  buttonType="primary"
                  class="absolute right-0 bg-transparent text-black"
                >
                  <Magnify />
                </PrimaryButton>
              </div>
              <div class="flex justify-end gap-4">
                <!-- 表示順変更 -->
                <SortSelector :sortOptions="sortOptions" />
                <!-- 表示件数変更 -->
                <PageSizeSelector />
                <PrimaryButton
                  @click="viewMode = 'list'"
                  :class="{ 'bg-indigo-300': viewMode === 'list' }"
                  buttonType="pink"
                  :iconOnly="true"
                >
                  <ViewList />
                </PrimaryButton>
                <PrimaryButton
                  @click="viewMode = 'grid'"
                  :class="{ 'bg-indigo-300': viewMode === 'grid' }"
                  buttonType="info"
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
                        :items="currentLessons"
                        :headers="[
                          'SL',
                          'レッスン画像',
                          'レッスン名',
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
                            <Avatar :src="item.lesson_photo_path ? `/storage/lessons/${item.lesson_photo_path}` : '/upload/sports.png'" size="lg" />
                          </td>
                          <td
                            class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            {{ item.name }}
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
                            class="flex gap-3 p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                          >
                            <PrimaryButton
                              :href="route('admin.lesson.show', item.id)"
                              buttonType="info"
                              class="size-10"
                            >
                              <EyeOutline />
                            </PrimaryButton>
                            <PrimaryButton
                              :href="route('admin.lesson.edit', item.id)"
                              buttonType="orange"
                              class="size-10"
                            >
                              <NoteEdit />
                            </PrimaryButton>
                            <DangerButton
                              @click="requestDeletion(item, 'delete')"
                              buttonType="danger"
                              class="size-10"
                            >
                              <TrashCanOutline />
                            </DangerButton>
                            <PrimaryButton
                              v-if="activeTab === 'deletedLessons'"
                              @click="restoreLesson(item.id)"
                              buttonType="success"
                              size="10"
                            >
                              <RestoreIcon />
                            </PrimaryButton>
                            <DangerButton
                              v-if="activeTab === 'deletedLessons'"
                              @click="requestDeletion(item, 'forceDelete')"
                              buttonType="danger"
                              size="10"
                            >
                              <TrashCanOutline />
                            </DangerButton>
                          </td>
                        </template>
                      </ListView>
                    </div>
                    <!-- グリッド表示 -->
                    <div v-else>
                      <GridView :items="currentLessons.data">
                        <template #renderItem="{ item }">
                          <div class="flex justify-center mb-4">
                            <Avatar :src="item.lesson_photo_path ? `/storage/lessons/${item.lesson_photo_path}` : '/upload/sports.png'" size="lg" />
                          </div>
                          <h3
                            class="text-base font-medium text-gray-900 dark:text-white text-center"
                          >
                            {{ item.name }}
                          </h3>
                          <div class="flex justify-center my-2">
                            <Badge v-if="item.status == '1'" type="success">
                              OPEN
                            </Badge>
                            <Badge v-if="item.status == '0'" type="danger">
                              CLOSE
                            </Badge>
                          </div>
                          <div class="flex justify-center gap-3 mt-4">
                            <PrimaryButton
                              :href="route('admin.lesson.show', item.id)"
                              buttonType="info"
                              size="10"
                            >
                              <EyeOutline />
                            </PrimaryButton>
                            <PrimaryButton
                              :href="route('admin.lesson.edit', item.id)"
                              buttonType="orange"
                              size="10"
                            >
                              <NoteEdit />
                            </PrimaryButton>
                            <DangerButton
                              @click="requestDeletion(item, 'delete')"
                              buttonType="danger"
                              size="10"
                            >
                              <TrashCanOutline />
                            </DangerButton>
                            <PrimaryButton
                              v-if="activeTab === 'deletedLessons'"
                              @click="restoreLesson(item.id)"
                              buttonType="success"
                              size="10"
                            >
                              <RestoreIcon />
                            </PrimaryButton>
                            <DangerButton
                              v-if="activeTab === 'deletedLessons'"
                              @click="requestDeletion(item, 'forceDelete')"
                              buttonType="danger"
                              size="10"
                            >
                              <TrashCanOutline />
                            </DangerButton>
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
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
