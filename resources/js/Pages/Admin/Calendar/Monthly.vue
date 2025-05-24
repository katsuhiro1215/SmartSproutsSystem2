<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { onMounted, ref, computed } from "vue";
import axios from "axios";
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
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";
import ButtonLink from "@/Components/Buttons/ButtonLink.vue";

const stores = ref([]);
const activeStore = ref(null);
const currentSchedules = ref([]);
const viewMode = ref("month");
const currentStoreName = computed(() => {
  const store = stores.value.find((store) => store.id === activeStore.value);
  return store ? store.name : "店舗が選択されていません";
});
// 店舗情報を取得
const fetchStores = async () => {
  try {
    const response = await axios.get("/api/stores");
    stores.value = response.data.stores;
    if (stores.value.length > 0) {
      activeStore.value = stores.value[0].id; // デフォルトで最初の店舗を選択
      fetchSchedules(activeStore.value); // 最初の店舗のスケジュールを取得
    }
  } catch (error) {
    console.error("店舗情報の取得に失敗しました:", error);
  }
};

// スケジュールを取得
const fetchSchedules = async (storeId) => {
  try {
    const response = await axios.get(
      route("admin.storeSchedule.fetchByStore", storeId)
    );
    currentSchedules.value = response.data.schedules;
  } catch (error) {
    console.error("スケジュールの取得に失敗しました:", error);
  }
};

// 店舗を切り替える
const switchStore = (storeId) => {
  activeStore.value = storeId;
  fetchSchedules(storeId);
};

// 表示モードを切り替える
const switchViewMode = (mode) => {
  viewMode.value = mode;
};

// コンポーネントの初期化時に店舗情報を取得
onMounted(() => {
  fetchStores();
});
</script>

<template>
  <Head title="店舗スケジュール管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="店舗スケジュール管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Store Schedule', url: route('admin.storeSchedule.index') },
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
            description="店舗スケジュール一覧を表示する画面です。"
          />
        </div>
        <div class="flex flex-wrap justify-end items-center gap-2">
          <PrimaryButton
            :href="route('admin.storeSchedule.bulkDelete')"
            buttonType="danger"
            ><TrashCanOutline
              class="mr-2"
            />店舗スケジュール一括削除</PrimaryButton
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
                v-for="store in stores"
                :key="store.id"
                buttonType="primary"
                :class="{ 'bg-indigo-300': activeStore === store.id }"
                @click="switchStore(store.id)"
              >
                {{ store.name }}
              </PrimaryButton>
            </div>
            <div class="flex flex-col">
              <div class="flex justify-between items-center mb-4">
                <div
                  class="relative flex justify-start items-center md:w-2/3 lg:w-1/3"
                >
                  <h2>{{ currentStoreName }} のスケジュール</h2>
                </div>
                <div class="flex justify-end gap-4">
                  <!-- 切り替えボタン -->
                  <PrimaryButton
                    @click="viewMode = 'year'"
                    :class="{ 'bg-indigo-300': viewMode === 'year' }"
                    buttonType="info"
                  >
                    <img src="/upload/year.png" alt="" width="20" height="20" />
                  </PrimaryButton>
                  <PrimaryButton
                    @click="viewMode = 'month'"
                    :class="{ 'bg-indigo-300': viewMode === 'month' }"
                    buttonType="info"
                  >
                    <img
                      src="/upload/month.png"
                      alt=""
                      width="20"
                      height="20"
                    />
                  </PrimaryButton>
                  <PrimaryButton
                    @click="viewMode = 'week'"
                    :class="{ 'bg-indigo-300': viewMode === 'week' }"
                    buttonType="info"
                  >
                    <img src="/upload/week.png" alt="" width="20" height="20" />
                  </PrimaryButton>
                </div>
              </div>
              <div class="flex flex-col lg:flex-row gap-4">
                <div class="w-20 lg:w-1/5">
                  <div class="flex flex-col gap-2">
                    <ButtonLink
                      buttonType="primary"
                      class="w-full"
                      ><Plus class="mr-2" />スケジュール追加</ButtonLink
                    >
                  </div>
                </div>
                <div class="w-full lg:w-4/5">
                  <MonthlyCalendar
                    v-if="viewMode === 'month'"
                    :schedules="currentSchedules"
                    :store-id="activeStore"
                  />
                </div>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
