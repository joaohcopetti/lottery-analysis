<script setup lang="ts">
import { HTMLAttributes } from 'vue'

defineProps<{
  bodyProps?: HTMLAttributes
}>()
</script>

<template>
  <div>
    <div
      v-if="$slots['title']"
      class="ml-4 inline-flex items-center rounded-t bg-blue-600 px-3 py-1 text-sm font-semibold whitespace-nowrap text-white shadow"
    >
      <slot name="title" />
    </div>

    <div
      class="rounded p-3 shadow"
      v-bind="bodyProps"
    >
      <slot name="body" />
    </div>
  </div>
</template>
