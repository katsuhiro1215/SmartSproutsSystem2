<script setup>
const menuItems = [
  { name: "Home", href: "#", isActive: true },
  { name: "Company", href: "#", isActive: false },
  { name: "Marketplace", href: "#", isActive: false },
  { name: "Features", href: "#", isActive: false },
  { name: "Team", href: "#", isActive: false },
  { name: "Contact", href: "#", isActive: false },
];
</script>

<template>
  <nav
    class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1"
    id="mobile-menu-2"
  >
    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
      <li v-for="item in menuItems" :key="item.name">
        <a
          :href="item.href"
          :class="[
            'block py-2 pr-4 pl-3 rounded lg:p-0',
            item.isActive
              ? 'text-white bg-primary-700 lg:bg-transparent lg:text-primary-700 dark:text-white'
              : 'text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700',
          ]"
          :aria-current="item.isActive ? 'page' : null"
        >
          {{ item.name }}
        </a>
      </li>
    </ul>
  </nav>
</template>