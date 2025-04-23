<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { mdiChevronUp, mdiChevronDown } from '@mdi/js';
// Components
import AdminHeaderNavigation from '@/Components/Navigations/AdminHeaderNavigation.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import GridMenu from '@/Components/GridMenu.vue';
// Components - Forms
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
// Icons
import Magnify from 'vue-material-design-icons/Magnify.vue';
import Avatar from '@/Components/Avatar.vue';

const showingNavigationDropdown = ref(false);
const isHeaderCenterVisible = ref(true);
const toggleHeaderCenter = () => {
  isHeaderCenterVisible.value = !isHeaderCenterVisible.value;
};
</script>

<template>
  <header class="w-full z-50">
    <!-- Header Top -->
    <div class="w-full h-12 flex justify-between items-center px-4">
      <div class="flex justify-start items-center gap-4">
        <!-- icon -->
        <GridMenu />
        <!-- Logo -->
        <h1 class="text-green-700 font-bold">
          <a href="" class="flex items-center gap-2">
            <ApplicationLogo width="32" />
            <span>Smart Srpouts</span>
          </a>
        </h1>
        <nav>
          <ul class="flex gap-4">
            <li>
              <NavLink href="">
                <img src="/upload/notification.png" alt="" width="24" />
              </NavLink>
            </li>
            <li>
              <NavLink href="">
                <img src="/upload/gestures.png" alt="" width="24" />
              </NavLink>
            </li>
            <li></li>
          </ul>
        </nav>
        <div class="flex justify-end items-center gap-4">
          <PrimaryButton buttonActionType="button" buttonType="indigo"
            >操作ログ</PrimaryButton
          >
          <PrimaryButton buttonActionType="button" buttonType="warning"
            >イベントログ</PrimaryButton
          >
          <PrimaryButton buttonActionType="button" buttonType="danger"
            >警報ログ</PrimaryButton
          >
        </div>

      </div>
      <ul class="flex items-center gap-4">
        <li>
          <NavLink href="">
            <Magnify width="24" />
          </NavLink>
        </li>
        <li class="flex items-center gap-4">
          <Avatar size="xs" />
          <button @click="showingNavigationDropdown = !showingNavigationDropdown" type="button">
            <svg :width="24" :height="24" viewBox="0 0 24 24">
              <path :d="showingNavigationDropdown ? mdiChevronUp : mdiChevronDown" />
            </svg>
          </button>
          <transition name="slide-fade">
            <div v-if="showingNavigationDropdown" class="absolute top-12 right-0 w-48 bg-white shadow p-4 z-40">
              <ul class="flex flex-col gap-2">
                <li>
                  <NavLink href="" class="flex items-center gap-2">
                    <span>プロフィール</span>
                  </NavLink>
                </li>
                <li>
                  <NavLink href="" class="flex items-center gap-2">
                    <span>設定</span>
                  </NavLink>
                </li>
                <li>
                  <NavLink href="" class="flex items-center gap-2">
                    <span>ヘルプ</span>
                  </NavLink>
                </li>
                <li>
                  <NavLink href="" class="flex items-center gap-2">
                    <span>ログアウト</span>
                  </NavLink>
                </li>
              </ul>
            </div>
          </transition>
        </li>
      </ul>
    </div>
    <!-- Header Center -->
    <transition name="slide-fade">
      <AdminHeaderNavigation v-if="isHeaderCenterVisible" />
    </transition>
    <!-- Header Bottom -->
    <div class="w-full h-6 flex justify-center bg-white">
      <button @click="toggleHeaderCenter" type="button" class="px-6 bg-orange-400 rounded-sm">
        <svg :width="24" :height="24" viewBox="0 0 24 24">
          <path :d="isHeaderCenterVisible ? mdiChevronUp : mdiChevronDown" />
        </svg>
      </button>
    </div>
  </header>
</template>

<style scoped>
/* Transition for sliding up/down */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: height 0.3s ease, opacity 0.3s ease;
}

.slide-fade-enter,
.slide-fade-leave-to {
  height: 0;
  opacity: 0;
}

.slide-fade-enter-from,
.slide-fade-leave-active {
  height: 6rem; /* Adjust according to the height of your Header Center */
  opacity: 1;
}
</style>