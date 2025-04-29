<script setup>
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
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
//icon
import Plus from "vue-material-design-icons/Plus.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Badge from "@/Components/Badge.vue";

// Props
const props = defineProps({
  organizations: Array,
});
</script>

<template>
  <Head title="組織管理" />

  <AdminAuthenticatedLayout>
    <!-- Header -->
    <template #header>
      <div class="flex sm:flex-row items-center justify-between">
        <PageTitle title="組織管理" />
        <Breadcrumb
          :items="[
            { name: 'Home', url: route('admin.dashboard') },
            { name: 'Organization', url: route('admin.organization.index') },
          ]"
        />
      </div>
    </template>
    <!-- Flash Message -->
    <FlashMessage />
    <!-- Main Contents -->
    <SettingLayout>
      <div class="flex justify-between">
        <div class="flex flex-col gap-2">
          <PageSubTitle title="組織一覧" />
          <PageDescription description="組織一覧を表示する画面です。" />
        </div>
        <div class="flex justify-end items-center gap-2">
          <PrimaryButton
            :href="route('admin.organization.create')"
            buttonType="indigo"
            ><Plus />新規組織作成</PrimaryButton
          >
          <BackButton :href="route('admin.dashboard')"
            ><Back />ホームへ戻る</BackButton
          >
        </div>
      </div>
      <div class="w-full flex flex-col p-5">
        <Card
          v-for="organization in organizations"
          :key="organization.id"
          class="w-full"
        >
          <template #content>
            <div class="flex items-center justify-between gap-4">
              <div class="w-1/6">
                <Avatar
                  :src="
                    organization.organization_photo_path
                      ? `/storage/organizations/${organization.organization_photo_path}`
                      : '/upload/workspace.png'
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
                  {{ organization.name }}
                </h3>
                <div
                  v-if="organization.type === '法人'"
                  class="flex flex-col space-y-2 text-slate-600 dark:text-slate-300"
                >
                  <dl class="hidden md:flex gap-2 text-sm">
                    <dt>Location:</dt>
                    <dd>{{ organization.full_address }}</dd>
                  </dl>
                  <dl class="flex gap-2 text-sm">
                    <dt>Type:</dt>
                    <dd>{{ organization.type }}</dd>
                  </dl>
                  <dl class="flex gap-2 text-sm">
                    <dt>Email:</dt>
                    <dd>{{ organization.email }}</dd>
                  </dl>
                  <dl class="flex gap-2 text-sm">
                    <dt>Phone:</dt>
                    <dd>{{ organization.phone_number }}</dd>
                  </dl>
                </div>
              </div>
              <div class="w-1/6 flex justify-center items-center">
                <Badge v-if="organization.status == '1'" type="success">
                  OPEN
                </Badge>
                <Badge v-if="organization.status == '0'" type="danger">
                  CLOSE
                </Badge>
                <Badge v-if="organization.status == null" type="warning">
                  PENDING
                </Badge>
              </div>
              <div class="w-1/6 flex flex-col justify-end items-center gap-4">
                <PrimaryButton
                  :href="route('admin.organization.show', organization.id)"
                  buttonType="info"
                  class="size-10"
                >
                  <EyeOutline />
                </PrimaryButton>
                <PrimaryButton
                  :href="route('admin.organization.edit', organization.id)"
                  buttonType="warning"
                  class="size-10"
                >
                  <NoteEdit />
                </PrimaryButton>
              </div>
            </div>
          </template>
        </Card>
      </div>
    </SettingLayout>
  </AdminAuthenticatedLayout>
</template>
