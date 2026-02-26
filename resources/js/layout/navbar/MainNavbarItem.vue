<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'

export type MainNavbarItemProps = {
  label: string
  icon: any
  url: string
}

const props = defineProps<MainNavbarItemProps>()

const isActive = computed(() => {
  const itemUrl = props.url.split('?')[0]

  return route(route().current() as string) === itemUrl
})

onMounted(() => {
  //
})
</script>

<template>
  <Link
    :href="url"
    class="flex h-full cursor-pointer items-center gap-1 px-3 text-sm font-medium transition-colors hover:bg-gray-100"
    :class="isActive ? 'bg-blue-100 text-blue-600' : 'text-gray-600'"
  >
    <Component :is="icon" />

    <span>{{ label }}</span>
  </Link>
</template>
