<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import EventLayout from "@/Components/SidebarLayouts/EventLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Avatar from "@/Components/Avatar.vue";
import Card from "@/Components/Cards/Card.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
// Icons
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
  allEvents: Object,
  events: Object,
  deletedEvents: Object,
});

// Lifecycle
onMounted(() => {
  console.log("allEvents:", props);
});

// Form
const form = useForm({});

// Tabs
const tabs = [
  { name: "allEvents", label: "全イベント一覧" },
  { name: "events", label: "イベント一覧" },
  { name: "deletedEvents", label: "削除済イベント一覧" },
];
const activeTab = ref("events");
const switchTab = (tabName) => {
  activeTab.value = tabName;
};

// Events
const currentEvents = computed(() => {
  return props[activeTab.value];
});

// 復活処理
const restoreEvent = (id) => {
  form.put(route("admin.event.restore", id));
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
    form.delete(route("admin.event.destroy", currentEntity.value.id));
  } else if (entityType.value === "forceDelete") {
    form.delete(route("admin.event.forceDelete", currentEntity.value.id));
  }
  showAlert.value = false;
};
const cancelDeletion = () => {
  showAlert.value = false;
};
</script>

<template>
  <Head title="イベント管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="イベント管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Event', url: route('admin.event.index') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <EventLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="イベント一覧" />
          <PageDescription description="イベント一覧を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <PrimaryButton :href="route('admin.event.create')" buttonType="indigo"
            ><Plus />イベント新規作成</PrimaryButton
          >
          <BackButton :href="route('admin.dashboard')"
            ><Back />ホームへ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col p-5">
        <Card class="w-full">
          <template #content>
            <div class="w-full flex flex-wrap gap-2">
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
          </template>
        </Card>
        <div class="w-full flex flex-col">
          <Card
            v-for="item in currentEvents"
            :key="item.id"
            class="w-full"
          >
            <template #content>
              <div class="flex items-center justify-between gap-4">
                <div class="w-1/6">
                  <Avatar
                    :src="
                      '/upload/event.png'
                    "
                    size="xxl"
                  />
                </div>
                <div
                  class="w-3/6 flex flex-col gap-3 items-start justify-between"
                >
                  <h3
                    class="text-lg font-semibold text-slate-800 dark:text-slate-100"
                  >
                    {{ item.name }}
                  </h3>
                  <div
                    class="flex flex-col space-y-2 text-slate-600 dark:text-slate-300"
                  >
                    <dl class="flex gap-2 text-sm">
                      <dt>開催期間:</dt>
                      <dd>{{ item.event_start_date }} - {{ item.event_end_date }}</dd>
                    </dl>
                    <dl class="flex gap-2 text-sm">
                      <dt>申込期間:</dt>
                      <dd>{{ item.application_start_date }} - {{ item.application_end_date }}</dd>
                    </dl>
                  </div>
                </div>
                <div class="w-1/6 flex justify-center items-center">
                  <Badge v-if="item.status == '1'" type="success"> OPEN </Badge>
                  <Badge v-if="item.status == '0'" type="danger"> CLOSE </Badge>
                  <Badge v-if="item.status == null" type="warning">
                    PENDING
                  </Badge>
                </div>
                <div class="w-1/6 flex flex-col justify-end items-center gap-4">
                  <PrimaryButton
                    :href="route('admin.event.show', item.id)"
                    buttonType="info"
                  >
                    <EyeOutline />
                  </PrimaryButton>
                  <PrimaryButton
                    :href="route('admin.event.edit', item.id)"
                    buttonType="warning"
                  >
                    <NoteEdit />
                  </PrimaryButton>
                </div>
              </div>
            </template>
            <template #empty>
              <div class="text-center text-slate-600 dark:text-slate-300">
                イベントはありません。
              </div>
            </template>
          </Card>
        </div>
      </div>
    </EventLayout>
  </AdminAuthenticatedLayout>
</template>
