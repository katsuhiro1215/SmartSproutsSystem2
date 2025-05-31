<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "questionnaire.index",
    label: "アンケート",
    icon: "/upload/store.png",
    route: "admin.questionnaire.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>