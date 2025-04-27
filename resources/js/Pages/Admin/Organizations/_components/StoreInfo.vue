<script setup>
import { defineProps } from "vue";
// Components
import Avatar from "@/Components/Avatar.vue";
import Card from "@/Components/Cards/Card.vue";
import Badge from "@/Components/Badge.vue";
// Components - Buttons
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
// Icons
import EyeOutline from "vue-material-design-icons/EyeOutline.vue";

const props = defineProps({
  organization: Object,
});
</script>

<template>
  <div class="flex justify-between items-center">
    <h3>店舗情報</h3>
    <div class="flex justify-end items-center gap-2"></div>
  </div>
  <!-- Stores -->
  <div
    v-if="organization.stores && organization.stores.length"
    class="space-y-6"
  >
    <div
      class="flex flex-col gap-4 p-4 dark:bg-slate-600"
      v-for="(store, index) in organization.stores"
      :key="index"
    >
      <div class="flex items-center gap-4">
        <input type="radio" name="" id="" checked />
        <h4>店舗 - {{ index + 1 }}</h4>
      </div>
      <Card>
        <template #content>
          <div class="flex items-center justify-between gap-4">
            <div class="w-1/6">
              <Avatar
                :src="
                  store.store_photo_path
                    ? store.store_photo_path
                    : '/upload/store.png'
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
                {{ store.name }}
              </h3>
              <div
                class="flex flex-col space-y-2 text-slate-600 dark:text-slate-300"
              >
                <dl class="hidden md:flex gap-2 text-sm">
                  <dt>Location:</dt>
                  <dd>{{ store.address1 }}</dd>
                </dl>
                <dl class="flex gap-2 text-sm">
                  <dt>Type:</dt>
                  <dd>{{ store.type }}</dd>
                </dl>
                <dl class="flex gap-2 text-sm">
                  <dt>Email:</dt>
                  <dd>{{ store.email }}</dd>
                </dl>
                <dl class="flex gap-2 text-sm">
                  <dt>Phone:</dt>
                  <dd>{{ store.phone_number }}</dd>
                </dl>
              </div>
            </div>
            <div class="w-1/6 flex justify-center items-center">
              <Badge v-if="store.status == '1'" type="success">
                OPEN
              </Badge>
              <Badge v-if="store.status == '0'" type="danger">
                CLOSE
              </Badge>
              <Badge v-if="store.status == null" type="warning">
                PENDING
              </Badge>
            </div>
            <div class="w-1/6 flex flex-col justify-end items-center gap-4">
              <PrimaryButton
                :href="route('admin.store.show', store.id)"
                buttonType="info"
                class="size-10"
              >
                <EyeOutline />
              </PrimaryButton>
            </div>
          </div>
        </template>
      </Card>
    </div>
  </div>
  <div v-if="!stores || !stores.length">
    <p>店舗情報を登録してください。</p>
  </div>
</template>
