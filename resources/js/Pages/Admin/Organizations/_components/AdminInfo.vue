<script setup>
import { defineProps } from "vue";
// Components
import Avatar from "@/Components/Avatar.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import Plus from "vue-material-design-icons/Plus.vue";
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";
import Card from "@/Components/Cards/Card.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
import Back from "vue-material-design-icons/ArrowLeft.vue";

const props = defineProps({
  admins: Array,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <div class="w-auto">
      <h3>管理者情報</h3>
    </div>
    <div class="flex justify-end items-center gap-2">
    </div>
  </div>
  <!-- Students -->
  <div v-if="admins && admins.length" class="space-y-6">
    <div
      class="flex flex-col gap-4 p-4 dark:bg-slate-600"
      v-for="(admin, index) in admins"
      :key="index"
    >
      <div class="flex items-center gap-4">
        <input type="radio" name="" id="" checked />
        <h4>生徒 - {{ index + 1 }}</h4>
      </div>
      <div class="flex flex-col lg:flex-row ms-5 gap-4">
        <div class="w-full lg:w-[200px]">
          <Card>
            <template #content>
              <div class="flex justify-center">
                <Avatar :src="admin.admin_photo_path" size="sm" />
              </div>
              <h3 class="text-center mt-4">{{ admin.username }}</h3>
              <hr class="my-5" />
              <div class="flex justify-center">
                <PrimaryButton
                  :href="route('admin.admin.show', admin.id)"
                  buttonType="info"
                  ><EyeOutline />詳細</PrimaryButton
                >
              </div>
            </template>
          </Card>
        </div>
        <div class="w-full lg:w-[calc(100%-200px)]">
          <Card>
            <template #content>
              <div class="flex flex-col space-y-4">
                <dl class="space-y-2">
                  <dt>名前</dt>
                  <dd class="bg-slate-500 p-4">
                    {{ admin.adminProfile.full_name }}
                  </dd>
                </dl>
                <dl class="space-y-2">
                  <dt>フリガナ</dt>
                  <dd class="bg-slate-500 p-4">
                    {{ admin.adminProfile.full_name_kana }}
                  </dd>
                </dl>
                <dl class="space-y-2">
                  <dt>生年月日</dt>
                  <dd class="bg-slate-500 p-4">
                    {{ admin.adminProfile.birth }}
                  </dd>
                </dl>
                <dl class="space-y-2">
                  <dt>緊急連絡先</dt>
                  <dd class="bg-slate-500 p-4">
                    {{ admin.adminProfile.mobile_number }}
                  </dd>
                </dl>
              </div>
            </template>
          </Card>
        </div>
      </div>
    </div>
  </div>
</template>
