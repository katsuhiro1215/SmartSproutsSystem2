<script setup>
import EmployeeSidebarLink from "@/Components/SidebarNavigationLinks/EmployeeSidebarLink.vue";
</script>

<template>
  <div class="w-full flex gap-5">
    <EmployeeSidebarLink />
    <div
      class="w-[calc(100%-64px)] sm:w-[calc(100%-80px)] lg:w-[calc(100%-96px)]"
    >
      <slot />
    </div>
  </div>
</template>
