<script setup lang="ts">
import { computed, useSlots } from 'vue'
import { AppButtonProps, BUTTON_COLOR_CLASS_MAP } from './types'

const props = withDefaults(defineProps<AppButtonProps>(), {
  label: '',
  icon: '',
  color: 'primary',
  iconOnly: false,
})

const isIconOnly = computed(() => props.icon && !props.label && !useSlots()['label'])
</script>

<template>
  <button
    class="h-10 cursor-pointer rounded-md px-2 transition-all"
    :class="[
      BUTTON_COLOR_CLASS_MAP[color],
      {
        'flex w-10 items-center justify-center': isIconOnly,
      },
    ]"
  >
    <Component
      :is="icon"
      v-if="icon"
    />

    <slot
      v-if="$slots['label']"
      name="label"
    />

    <template v-else>{{ label }}</template>
  </button>
</template>
