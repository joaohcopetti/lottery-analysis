<script setup lang="ts">
import IMdiClover from 'virtual:icons/mdi/clover'
import IPhChartPieSlice from 'virtual:icons/ph/chart-pie-slice-fill'
import MainNavbarItem, { MainNavbarItemProps } from './MainNavbarItem.vue'

const NAVBAR_ITEMS: MainNavbarItemProps[] = [
  {
    icon: IMdiClover,
    label: 'Visão geral',
    url: route('main', route().params),
  },
  {
    icon: IPhChartPieSlice,
    label: 'Dados estatísticos',
    url: route('stats', route().params),
  },
]
</script>

<template>
  <div class="fixed top-0 left-[110px] z-10 h-10 w-[calc(100%-110px)] bg-white shadow-lg">
    <div class="flex h-full">
      <MainNavbarItem
        v-for="navbarItem in NAVBAR_ITEMS"
        :key="navbarItem.url"
        v-bind="navbarItem"
      />
    </div>
  </div>
</template>
