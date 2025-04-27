<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  organization: Object,
});
</script>

<template>
  <div class="space-y-4">
    <div class="w-full flex justify-between items-center">
      <h3 class="text-lg p-3 border-b-2 border-b-orange-400">組織</h3>
      <PrimaryButton
        :href="route('admin.organization.edit', organization.id)"
        buttonType="warning"
        ><NoteEdit class="mr-2" />編集</PrimaryButton
      >
    </div>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">タイプ</dt>
      <dd class="w-full lg:w-3/4">{{ organization.type }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">組織名</dt>
      <dd class="w-full lg:w-3/4">{{ organization.name }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">組織概要</dt>
      <dd class="w-full lg:w-3/4">
        {{ organization.description }}
      </dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">メールアドレス</dt>
      <dd class="w-full lg:w-3/4">{{ organization.email }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">郵便番号</dt>
      <dd class="w-full lg:w-3/4">{{ organization.postalcode }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">住所</dt>
      <dd class="w-full lg:w-3/4">{{ organization.full_address }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">電話番号</dt>
      <dd class="w-full lg:w-3/4">{{ organization.phone_number }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">FAX番号</dt>
      <dd class="w-full lg:w-3/4">{{ organization.fax_number }}</dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">ステータス</dt>
      <dd class="w-full lg:w-3/4">
        <Badge v-if="organization.status == '1'" type="success"> OPEN </Badge>
        <Badge v-if="organization.status == '0'" type="danger"> CLOSE </Badge>
        <Badge v-if="organization.status == null" type="warning">
          PENDING
        </Badge>
      </dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">設立日</dt>
      <dd class="w-full lg:w-3/4">{{ organization.established_date }}</dd>
    </dl>
  </div>
</template>