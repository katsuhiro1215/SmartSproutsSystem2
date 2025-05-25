<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "event.index",
    label: "イベント",
    icon: "/upload/store.png",
    route: "admin.event.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>