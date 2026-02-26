<script setup lang="ts">
import { SidebarItemProps } from '@/layout/sidebar/MainSidebarItem.vue'
import IMdiClover from 'virtual:icons/mdi/clover'
import IPhFunnel from 'virtual:icons/ph/funnel-fill'
import SidebarItem from './MainSidebarItem.vue'

defineProps<{
  items: SidebarItemProps[]
}>()
</script>

<template>
  <aside
    class="fixed z-10 mt-10 flex h-full w-[110px] flex-col items-center overflow-auto bg-white shadow-xl"
  >
    <SidebarItem
      label="Filtro"
      slug="filter"
      :icon="IPhFunnel"
    />

    <div class="h-0.5 w-full bg-gray-400" />

    <SidebarItem
      v-for="item in items"
      :key="item.slug"
      v-bind="{ ...item, icon: IMdiClover }"
    />
  </aside>
</template>
