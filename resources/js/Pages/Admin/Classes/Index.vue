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
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({

});
</script>

<template>
  <Head title="クラス管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="クラス管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Class', url: route('admin.class.index') },
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
          <PageSubTitle title="クラス一覧" />
          <PageDescription
            description="クラス一覧を表示する画面です。レッスン、コースカテゴリー、コース、ルーム(班)、コース・スケジュールを設定することができます。"
          />
        </div>
        <div class="flex justify-end items-center gap-2">
          <BackButton :href="route('admin.dashboard')"><Back />戻る</BackButton>
        </div>
      </div>
      <div class="w-full flex flex-col p-5">
        <Card class="w-full">
          <template #content>
            <!--  -->
          </template>
        </Card>
      </div>
    </ClassLayout>
  </AdminAuthenticatedLayout>
</template>
