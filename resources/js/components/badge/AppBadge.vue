<script setup lang="ts">
const BADGE_COLORS_CLASS_MAP = {
  primary: 'bg-blue-500 text-blue-100',
  warning: 'bg-amber-500 text-amber-900',
}

const SIZES_CLASS_MAP = {
  sm: 'px-1.5 py-0.5 text-[10px]',
  md: 'px-2 py-1 text-[12px]',
}

withDefaults(
  defineProps<{
    color?: keyof typeof BADGE_COLORS_CLASS_MAP
    size?: keyof typeof SIZES_CLASS_MAP
  }>(),
  {
    color: 'primary',
    size: 'md',
  },
)
</script>

<template>
  <span
    class="flex items-center rounded-full font-bold"
    :class="[BADGE_COLORS_CLASS_MAP[color], SIZES_CLASS_MAP[size]]"
  >
    <slot />
  </span>
</template>
