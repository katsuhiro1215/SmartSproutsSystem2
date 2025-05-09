<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "store.index",
    label: "店舗",
    icon: "/upload/store.png",
    route: "admin.store.index",
  },
  {
    name: "storeSchedule.index",
    label: "スケジュール",
    icon: "/upload/schedule.png",
    route: "admin.storeSchedule.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>