<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";
// Layouts
import AdminAuthenticatedLayout from "@/Layouts/AdminAuthenticatedLayout.vue";
// Components
import StoreLayout from "@/Components/SidebarLayouts/StoreLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import PageSubTitle from "@/Components/PageSubTitle.vue";
import PageDescription from "@/Components/PageDescription.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Card from "@/Components/Cards/Card.vue";
import Alert from "@/Components/Alerts/Alert.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import Badge from "@/Components/Badge.vue";
import SimpleTable from "@/Components/Tables/SimpleTable.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//  Components - Forms
import FormGroup from "@/Components/Forms/FormGroup.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import InputError from "@/Components/Forms/InputError.vue";
//icon
import Back from "vue-material-design-icons/ArrowLeft.vue";
import TrashCanOutline from "vue-material-design-icons/TrashCanOutline.vue";
import Magnify from "vue-material-design-icons/Magnify.vue";

const form = useForm({
  year: "",
  month: "",
});

const schedules = ref([]);
const selectedSchedules = ref([]);
const showTable = ref(false);

const searchSchedules = async () => {
  try {
    const response = await axios.post(route("admin.storeSchedule.search"), {
      year: form.year,
      month: form.month,
    });

    console.log(response.data);
    schedules.value = response.data.map((schedule) => {
      const [business_date, start_time] = schedule.start_date.split(" ");
      const [, end_time] = schedule.end_date.split(" ");
      return {
        ...schedule,
        business_date,
        start_time,
        end_time,
      };
    });

    selectedSchedules.value = schedules.value.map((schedule) => schedule.id);
    showTable.value = true;
  } catch (error) {
    console.error("検索中にエラーが発生しました:", error);
  }
};

// 全選択の状態
const allSelected = ref(true);

// 全選択/全解除のトグル
const toggleAll = () => {
  allSelected.value = !allSelected.value;
  if (allSelected.value) {
    selectedSchedules.value = schedules.value.map((schedule) => schedule.id);
  } else {
    selectedSchedules.value = [];
  }
};

// 個別のチェックボックスの状態を監視
watch(selectedSchedules, (newSelected) => {
  allSelected.value = newSelected.length === schedules.value.length;
});

// ローディング
const isLoading = ref(false);
const loadingText = ref("");
// 削除確認ダイアログの表示
const showAlert = ref(false);

// 削除ボタンを押した際にアラートを表示
const handleDeleteClick = () => {
  if (selectedSchedules.value.length === 0) {
    alert("削除するスケジュールを選択してください。");
    return;
  }
  showAlert.value = true;
};

// 削除処理
const confirmDeletion = () => {
  // console.log(
  //   "送信するデータ:",
  //   JSON.stringify({ ids: selectedSchedules.value })
  // ); // データを確認

  isLoading.value = true;
  loadingText.value = "削除中";

  axios
    .post(route("admin.storeSchedule.bulkDestroy"), {
      ids: selectedSchedules.value, // 送信データ
    })
    .then(() => {
      isLoading.value = false;
      loadingText.value = "";
      showAlert.value = false;

      // サーバーからのリダイレクトURLを取得して遷移
      if (response.data.redirect) {
        window.location.href = response.data.redirect;
      }
    })
    .catch((error) => {
      // console.error("削除中にエラーが発生しました:", error);
      isLoading.value = false;
      loadingText.value = "";
    });
};

// キャンセル処理
const cancelDeletion = () => {
  showAlert.value = false;
};
</script>

<template>
  <Head title="店舗スケジュール管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="店舗スケジュール一括削除" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Store Schedule', url: route('admin.storeSchedule.index') },
            {
              name: 'Bulk Delete',
              url: route('admin.storeSchedule.bulkDelete'),
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
      :message="`店舗スケジュールを削除しますか？`"
      @confirm="confirmDeletion"
      @cancel="cancelDeletion"
    />
    <!-- Main Contents -->
    <StoreLayout>
      <div class="flex justify-between p-5">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="店舗スケジュール一括削除" />
          <PageDescription
            description="店舗スケジュールを一括削除する画面です。"
          />
        </div>
        <div class="flex flex-wrap justify-end items-center gap-2">
          <BackButton :href="route('admin.storeSchedule.index')"
            ><Back />店舗スケジュール一覧へ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full p-5 space-y-6">
        <Card class="w-full">
          <template #content>
            <form @submit.prevent="searchSchedules" class="space-y-6">
              <div class="w-full space-y-4">
                <div class="flex flex-col lg:flex-row gap-4">
                  <FormGroup class="w-full">
                    <InputLabel for="year" value="年" />
                    <TextInput
                      id="year"
                      type="number"
                      v-model="form.year"
                      required
                    />
                  </FormGroup>
                  <FormGroup class="w-full">
                    <InputLabel for="month" value="月" />
                    <TextInput
                      id="month"
                      type="number"
                      v-model="form.month"
                      required
                    />
                  </FormGroup>
                </div>
                <PrimaryButton buttonType="primary" type="submit">
                  <Magnify class="mr-2" />
                  検索
                </PrimaryButton>
              </div>
            </form>
          </template>
        </Card>
        <Card v-if="showTable" class="w-full">
          <template #content>
            <div class="space-y-4">
              <SimpleTable>
                <template #header>
                  <tr>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      SL
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      <input
                        type="checkbox"
                        :checked="allSelected"
                        @change="toggleAll"
                      />
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      店舗名
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      営業日
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      開始時間
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      終了時間
                    </th>
                    <th
                      class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400"
                    >
                      ステータス
                    </th>
                  </tr>
                </template>
                <template #body>
                  <tr v-for="(schedule, index) in schedules" :key="schedule.id">
                    <td>{{ index + 1 }}</td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      <input
                        type="checkbox"
                        v-model="selectedSchedules"
                        :value="schedule.id"
                      />
                    </td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ schedule.store.name }}
                    </td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ schedule.business_date }}
                    </td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ schedule.start_time }}
                    </td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      {{ schedule.end_time }}
                    </td>
                    <td
                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                      <Badge v-if="schedule.status == '1'" type="success">
                        OPEN
                      </Badge>
                      <Badge v-if="schedule.status == '0'" type="danger">
                        CLOSE
                      </Badge>
                    </td>
                  </tr>
                </template>
              </SimpleTable>
              <DangerButton @click="handleDeleteClick">
                <TrashCanOutline class="mr-2" />
                一括削除
              </DangerButton>
            </div>
          </template>
        </Card>
      </div>
    </StoreLayout>
  </AdminAuthenticatedLayout>
</template>
