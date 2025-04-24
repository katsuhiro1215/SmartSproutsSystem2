<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "settings.index",
    label: "一般設定",
    icon: "/upload/family.png",
    route: "admin.setting.index",
  },
  {
    name: "admin.index",
    label: "管理者",
    icon: "/upload/family.png",
    route: "admin.admin.index",
  },
  {
    name: "settings.index",
    label: "オーナー",
    icon: "/upload/family.png",
    route: "admin.owner.show",
    params: { id: 1 },
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>