<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "user.index",
    label: "ユーザー",
    icon: "/upload/user.png",
    route: "admin.user.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>