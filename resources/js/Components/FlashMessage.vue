<script setup>
import { ref, watchEffect } from 'vue';
import { usePage } from '@inertiajs/vue3';

const $page = usePage();
const isVisible = ref(true);

watchEffect(() => {
  if ($page.props.flash.success || $page.props.flash.error) {
    isVisible.value = true;
    setTimeout(() => {
      isVisible.value = false;
    }, 3000);
  }
});
</script>

<template>
  <transition name="fade">
    <div
      v-if="isVisible"
      class="absolute top-4 right-4 min-w-40 px-4 py-2 rounded-md text-xs sm:text-sm md:text-base"
      :class="{
        'bg-green-300 text-green-700': $page.props.flash.status === 'success',
        'bg-blue-300 text-blue-700': $page.props.flash.status === 'info',
        'bg-yellow-300 text-yellow-700': $page.props.flash.status === 'warning',
        'bg-red-300 text-red-700': $page.props.flash.status === 'danger',
      }"
    >
      <span>
        {{ $page.props.flash.message }}
      </span>
    </div>
  </transition>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}
</style>