<script setup>
import { defineProps } from "vue";
// Components
import Separator from "@/Components/Separator.vue";
import Badge from "@/Components/Badge.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import Plus from "vue-material-design-icons/Plus.vue";
import NoteEdit from "vue-material-design-icons/NoteEdit.vue";

const props = defineProps({
  user: Object,
  userAddresses: Array,
});
</script>

<template>
  <div class="flex justify-between items-center border-b-2 border-b-orange-400">
    <h3 class="text-lg p-3">住所</h3>
    <div class="flex gap-2">
      <PrimaryButton
        :href="route('admin.userAddress.create', props.user.id)"
        buttonType="indigo"
        class="flex items-center"
        ><Plus class="mr-2" />
        {{ userAddresses.length > 0 ? "住所追加" : "住所新規作成" }}
      </PrimaryButton>
    </div>
  </div>
  <div
    v-for="(userAddress, index) in userAddresses"
    :key="userAddress">
    <div class="flex justify-between items-center">
      <h4>住所 - {{ index + 1 }}</h4>
      <PrimaryButton
        :href="route('admin.userAddress.edit', [
          props.user.id,
          userAddress.id,
        ])"
        buttonType="warning"
        ><NoteEdit class="mr-2" />編集</PrimaryButton
      >
    </div>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">郵便番号</dt>
      <dd class="w-full lg:w-3/4">
        {{ userAddress.postalcode }}
      </dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">住所</dt>
      <dd class="w-full lg:w-3/4">
        {{ userAddress.full_address }}
      </dd>
    </dl>
    <dl class="flex flex-col lg:flex-row items-center gap-5 p-4">
      <dt class="w-full lg:w-1/4">デフォルト</dt>
      <dd class="w-full lg:w-3/4">
        <Badge v-if="userAddress.is_default == '1'" type="success">
          Default
        </Badge>
        <Badge v-if="userAddress.is_default == '0'" type="danger">
          Not Default
        </Badge>
      </dd>
    </dl>
    <Separator />
  </div>
</template>