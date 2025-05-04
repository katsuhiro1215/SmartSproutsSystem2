<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "user.index",
    label: "ユーザー",
    icon: "/upload/user.png",
    route: "admin.user.index",
  },
  {
    name: "studnet.index",
    label: "生徒",
    icon: "/upload/children.png",
    route: "admin.student.index",
  },
  {
    name: "guardian.index",
    label: "保護者",
    icon: "/upload/parents.png",
    route: "admin.guardian.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>