<script setup lang="ts">
import { omit } from 'lodash-es'
import { twMerge } from 'tailwind-merge'
import { computed, HTMLAttributes } from 'vue'

const HEADER_COLOR_CLASS_MAP = {
  primary: 'bg-gradient-to-r from-blue-900 to-blue-500 text-white',
  danger: 'bg-gradient-to-r from-red-900 to-red-500 text-white',
}

const props = withDefaults(
  defineProps<{
    color?: keyof typeof HEADER_COLOR_CLASS_MAP
    headerIcon?: any
    bodyProps?: HTMLAttributes
  }>(),
  {
    color: 'primary',
    headerIcon: undefined,
    bodyProps: undefined,
    fadeBottom: false,
  },
)

const headerClass = computed(() => {
  const classes = []

  classes.push(HEADER_COLOR_CLASS_MAP[props.color])

  return classes
})
</script>

<template>
  <div class="relative h-fit overflow-hidden rounded shadow-lg">
    <div
      v-if="$slots['header']"
      class="px-4 py-3 text-lg font-bold"
      :class="headerClass"
    >
      <div class="flex items-center">
        <Component
          :is="headerIcon"
          class="mr-2"
        />

        <slot name="header" />
      </div>
    </div>

    <div
      :class="twMerge('relative bg-white p-3', bodyProps?.class || '')"
      v-bind="omit(bodyProps, 'class')"
    >
      <slot name="body" />
    </div>
  </div>
</template>
