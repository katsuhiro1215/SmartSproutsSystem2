<script setup>
import SettingSidebarLink from "@/Components/SidebarNavigationLinks/SettingSidebarLink.vue";
</script>

<template>
  <div class="w-full flex gap-5">
    <SettingSidebarLink />
    <div
      class="w-[calc(100%-64px)] sm:w-[calc(100%-80px)] lg:w-[calc(100%-96px)]"
    >
      <slot />
    </div>
  </div>
</template>
