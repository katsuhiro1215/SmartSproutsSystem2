<script>
import { ref } from "vue";

export default {
  setup() {
    // State to track menu visibility
    const isOpen = ref(false);

    // Sample menu items
    const menuItems = ref([
      { title: "タイトル1", icon: "/upload/layout.png" },
      { title: "タイトル2", icon: "/upload/layout.png" },
      { title: "タイトル3", icon: "/upload/layout.png" },
      { title: "タイトル4", icon: "/upload/layout.png" },
      { title: "タイトル5", icon: "/upload/layout.png" },
      { title: "タイトル6", icon: "/upload/layout.png" },
    ]);

    // Method to toggle menu visibility
    const toggleMenu = () => {
      isOpen.value = !isOpen.value;
    };

    return {
      isOpen,
      menuItems,
      toggleMenu,
    };
  },
};
</script>

<template>
  <div class="relative flex">
    <!-- Trigger Button -->
    <button @click="toggleMenu" class="relative">
      <img src="/upload/layout.png" alt="Menu Icon" width="32" />
    </button>

    <!-- Menu Grid -->
    <div
      v-if="isOpen"
      class="absolute w-60 bg-red-300 top-12 -left-2 grid grid-cols-3 gap-4 p-4 shadow-lg rounded-sm z-10"
    >
      <!-- Arrow on Top -->
      <div class="absolute -top-2 left-4 w-4 h-4 rotate-45 bg-red-300" />

      <!-- Grid Menu Items -->
      <div v-for="(item, index) in menuItems" :key="index" class="flex flex-col justify-center items-center gap-2">
        <img :src="item.icon" alt="Menu Item Icon" width="32" />
        <span class="text-sm">{{ item.title }}</span>
      </div>
    </div>
  </div>
</template>
