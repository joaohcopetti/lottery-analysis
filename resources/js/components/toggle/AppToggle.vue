<script setup lang="ts">
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

defineEmits(['update:modelValue'])
defineProps<{
  label?: string
  labelClass?: string
}>()

const enabled = defineModel<boolean>({ default: false })
</script>

<template>
  <SwitchGroup>
    <div class="flex items-center">
      <Switch
        :model-value="enabled"
        :class="enabled ? 'bg-blue-600' : 'bg-gray-300'"
        class="relative inline-flex h-6 w-11 cursor-pointer items-center rounded-full"
        @update:model-value="$emit('update:modelValue', $event)"
      >
        <span class="sr-only">{{ label }}</span>

        <span
          :class="enabled ? 'translate-x-6' : 'translate-x-1'"
          class="inline-block h-4 w-4 transform rounded-full bg-white transition"
        />
      </Switch>

      <SwitchLabel
        v-if="label"
        class="ml-3 cursor-pointer"
        :class="labelClass"
      >
        {{ label }}
      </SwitchLabel>
    </div>
  </SwitchGroup>
</template>
