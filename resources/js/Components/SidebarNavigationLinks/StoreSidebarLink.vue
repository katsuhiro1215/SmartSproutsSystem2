<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "store.index",
    label: "店舗",
    icon: "/upload/store.png",
    route: "admin.store.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>