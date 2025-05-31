<script setup>
import QuestionnaireSidebarLink from "@/Components/SidebarNavigationLinks/QuestionnaireSidebarLink.vue";
</script>

<template>
  <div class="w-full flex gap-5">
    <QuestionnaireSidebarLink />
    <div
      class="w-[calc(100%-64px)] sm:w-[calc(100%-80px)] lg:w-[calc(100%-96px)]"
    >
      <slot />
    </div>
  </div>
</template>
