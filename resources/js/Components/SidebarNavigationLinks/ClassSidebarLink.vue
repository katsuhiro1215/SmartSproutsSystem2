<script setup>
import AdminSidebar from "@/Components/Navigations/AdminSidebar.vue";

const menuItems = [
  {
    name: "class.index",
    label: "ダッシュボード",
    icon: "/upload/sports.png",
    route: "admin.class.index",
  },
  {
    name: "lesson.index",
    label: "レッスン",
    icon: "/upload/sports.png",
    route: "admin.lesson.index",
  },
  {
    name: "courseCategory.index",
    label: "カテゴリー",
    icon: "/upload/sports.png",
    route: "admin.lesson.index",
  },
  {
    name: "course.index",
    label: "コース",
    icon: "/upload/sports.png",
    route: "admin.lesson.index",
  },
];
</script>

<template>
  <AdminSidebar :menuItems="menuItems" />
</template>