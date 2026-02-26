<script setup lang="ts">
import { useAppStore } from '@/stores/app-store'
import { router } from '@inertiajs/vue3'
import MainNavbar from './navbar/MainNavbar.vue'
import MainSidebar from './sidebar/MainSidebar.vue'
import { SidebarItemProps } from './sidebar/MainSidebarItem.vue'

const appStore = useAppStore()

defineProps<{
  sidebarItems: SidebarItemProps[]
}>()

router.on('navigate', () => {
  appStore.refreshRouteKey()
})
</script>

<template>
  <div>
    <MainSidebar
      :key="appStore.currentRouteKey"
      :items="sidebarItems"
    />

    <MainNavbar :key="appStore.currentRouteKey" />

    <div
      class="ml-[calc(var(--spacing)*4+110px)] pt-14"
      style=""
    >
      <slot />
    </div>
  </div>
</template>
