<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "employees.index",
    label: "従業員",
    icon: "/upload/family.png",
    route: "admin.employee.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>