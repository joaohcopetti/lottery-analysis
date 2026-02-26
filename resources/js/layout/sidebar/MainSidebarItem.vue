<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

export type SidebarItemProps = {
  label: string
  slug: string
  url?: string
  icon: any
}

const props = defineProps<SidebarItemProps>()

defineEmits<{
  click: []
}>()

const isActive = computed(
  () =>
    route().params.loteria === props.slug ||
    (!route().params.loteria && props.slug === 'mega-sena'),
)
</script>

<template>
  <Component
    :is="url ? Link : 'span'"
    :href="url"
    class="w-full"
    :class="[
      'flex cursor-pointer flex-col items-center justify-center py-3 transition-colors',
      isActive
        ? 'bg-blue-100 text-blue-700'
        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900',
    ]"
  >
    <Component
      :is="icon"
      class="h-6 w-6"
    />

    <span class="mt-1 text-xs font-medium">{{ label }}</span>
  </Component>
</template>
