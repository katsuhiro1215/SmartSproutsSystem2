<script setup>
import { defineProps } from "vue";
// Components
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Badge from "@/Components/Badge.vue";
// Icons
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  store: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>店舗</h3>
    <PrimaryButton
      :href="route('admin.store.edit', store.id)"
      buttonType="warning"
      ><NoteEdit class="mr-2" />編集</PrimaryButton
    >
  </div>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">組織名</dt>
    <dd class="w-full lg:w-3/4">{{ store.organization.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">店舗名</dt>
    <dd class="w-full lg:w-3/4">{{ store.name }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">店舗タイプ</dt>
    <dd class="w-full lg:w-3/4">{{ store.type }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">店舗コード</dt>
    <dd class="w-full lg:w-3/4">{{ store.code }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">テーマカラー</dt>
    <dd class="w-full lg:w-3/4">{{ store.theme_color }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">組織内容</dt>
    <dd class="w-full lg:w-3/4">{{ store.description }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">メールアドレス</dt>
    <dd class="w-full lg:w-3/4">{{ store.email }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">郵便番号</dt>
    <dd class="w-full lg:w-3/4">{{ store.postalcode }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">住所</dt>
    <dd class="w-full lg:w-3/4">{{ store.full_address }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">電話番号</dt>
    <dd class="w-full lg:w-3/4">{{ store.phone_number }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">FAX番号</dt>
    <dd class="w-full lg:w-3/4">{{ store.fax_number ? store.fax_number : '未登録' }}</dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">組織ステータス</dt>
    <dd class="w-full lg:w-3/4">
      <Badge v-if="store.status == '1'" type="success"> OPEN </Badge>
      <Badge v-if="store.status == '0'" type="danger"> CLOSE </Badge>
      <Badge v-if="store.status == null" type="warning"> PENDING </Badge>
    </dd>
  </dl>
  <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
    <dt class="w-full lg:w-1/4">設立日</dt>
    <dd class="w-full lg:w-3/4">
      {{ store.established_date }}
    </dd>
  </dl>
</template>