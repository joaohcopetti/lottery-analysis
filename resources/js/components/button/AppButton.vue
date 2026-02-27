<script setup lang="ts">
import IPhCircleNotch from 'virtual:icons/ph/circle-notch-bold'
import { computed, useSlots } from 'vue'
import { BUTTON_COLOR_CLASS_MAP } from './types'

export type AppButtonProps = {
  label?: string
  icon?: any
  color?: keyof typeof BUTTON_COLOR_CLASS_MAP
  loading?: boolean
  disabled?: boolean
}

const props = withDefaults(defineProps<AppButtonProps>(), {
  label: '',
  icon: '',
  color: 'primary',
  iconOnly: false,
  loading: false,
  disabled: false,
})

const isIconOnly = computed(() => props.icon && !props.label && !useSlots()['label'])
const isDisabled = computed(() => props.disabled || props.loading)

const buttonClasses = computed(() => {
  const classes = []

  if (isIconOnly.value) {
    classes.push('flex w-10 items-center justify-center')
  }

  if (isDisabled.value) {
    classes.push('cursor-default bg-gray-300 text-gray-500')
  }

  if (!isDisabled.value) {
    classes.push(BUTTON_COLOR_CLASS_MAP[props.color].default)
    classes.push('cursor-pointer')
  }

  return classes
})
</script>

<template>
  <button
    :disabled="isDisabled"
    class="h-10 rounded-md px-3 transition-all"
    :class="buttonClasses"
  >
    <div class="flex items-center gap-1">
      <Component
        :is="loading ? IPhCircleNotch : icon"
        v-if="icon || loading"
        :class="{
          'animate-spin': loading,
        }"
      />

      <div>
        <slot
          v-if="$slots['label']"
          name="label"
        />

        <template v-else>{{ label }}</template>
      </div>
    </div>
  </button>
</template>
