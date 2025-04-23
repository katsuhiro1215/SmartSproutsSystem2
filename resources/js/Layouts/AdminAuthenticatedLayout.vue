<script setup>
import AdminHeader from "@/Layouts/AdminHeader.vue";
import AdminFooter from "@/Layouts/AdminFooter.vue";
</script>

<template>
  <div class="w-full h-auto min-h-full overflow-x-hidden overflow-y-auto bg-transparent relative">
    <AdminHeader />

    <main class="relative w-full min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-slate-50 px-5">
      <header v-if="$slots.header" class="p-6 text-slate-700 dark:text-slate-100">
        <slot name="header" />
      </header>
      <div class="w-full">
        <slot />
      </div>
    </main>
    
    <AdminFooter />
  </div>
</template>

<style scoped>
/* Transition for sliding up/down */
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: height 0.3s ease, opacity 0.3s ease;
}

.slide-fade-enter,
.slide-fade-leave-to {
  height: 0;
  opacity: 0;
}

.slide-fade-enter-from,
.slide-fade-leave-active {
  height: 6rem; /* Adjust according to the height of your Header Center */
  opacity: 1;
}
</style>