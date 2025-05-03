<script setup>
import UserSidebarLink from "../SidebarNavigationLinks/UserSidebarLink.vue";
</script>

<template>
  <div class="w-full flex gap-5">
    <UserSidebarLink />
    <div
      class="w-[calc(100%-64px)] sm:w-[calc(100%-80px)] lg:w-[calc(100%-96px)]"
    >
      <slot />
    </div>
  </div>
</template>
