<script setup>
import NavLink from '@/Components/NavLink.vue';

const defaultMenuItems = [
  { name: 'home', route: 'admin.dashboard', label: 'ホーム', icon: '/upload/house.png' },
  { name: 'user', route: 'admin.dashboard', label: '顧客', icon: '/upload/family.png' },
  { name: 'admin', route: 'admin.employee.index', label: '従業員', icon: '/upload/employees.png' },
  { name: 'store', route: 'admin.dashboard', label: '店舗', icon: '/upload/store.png' },
  { name: 'class', route: 'admin.dashboard', label: 'クラス', icon: '/upload/sports.png' },
  { name: 'event', route: 'admin.dashboard', label: 'イベント', icon: '/upload/event.png' },
  { name: 'announcement', route: 'admin.dashboard', label: '告知', icon: '/upload/announcement.png' },
  { name: 'fee', route: 'admin.dashboard', label: '会計', icon: '/upload/salary.png' },
  { name: 'website', route: 'admin.dashboard', label: 'Webサイト', icon: '/upload/mobile.png' },
  { name: 'ec', route: 'admin.dashboard', label: 'EC', icon: '/upload/shopping.png' },
  { name: 'questionnaire', route: 'admin.dashboard', label: 'アンケート', icon: '/upload/note.png' },
  { name: 'contact', route: 'admin.dashboard', label: 'お問い合わせ', icon: '/upload/email.png' },
  { name: 'widget', route: 'admin.dashboard', label: 'ウィジェット', icon: '/upload/menu.png' },
  { name: 'settings', route: 'admin.setting.index', label: '設定', icon: '/upload/settings.png' },
];
</script>

<template>
  <nav class="w-full flex items-center bg-blue-400">
    <ul class="hidden w-full md:flex flex-wrap items-center gap-6 px-4 py-2 overflow-hidden">
      <li v-for="item in defaultMenuItems" :key="item.name">
        <NavLink
          :href="route(item.route)"
          :active="route().current(item.route)"
          class="flex-col gap-2"
        >
          <img :src="item.icon" :alt="item.label" width="32" />
          <span class="text-sm">{{ item.label }}</span>
        </NavLink>
      </li>
    </ul>
  </nav>
</template>