<script setup lang="ts">
import { computed } from 'vue'

const emit = defineEmits(['update:model-value'])
const props = withDefaults(
  defineProps<{
    label?: string
    type?: 'text' | 'date'
  }>(),
  {
    label: '',
    type: 'text',
  },
)

const inputValue = defineModel<string>()

const inputType = computed(() => (props.type === 'date' ? 'text' : props.type))
const isDate = computed(() => props.type === 'date')

const onInput = (event: Event) => {
  const target = event.target as HTMLInputElement

  emit('update:model-value', target.value)
}
</script>

<template>
  <div class="relative">
    <label>
      <span
        v-if="label"
        class="inline-block pb-1 text-sm font-semibold"
      >
        {{ label }}
      </span>

      <div
        class="relative rounded border border-gray-400 bg-gray-100 px-3 py-2 outline-blue-200 transition-colors focus-within:outline-4 hover:bg-gray-200"
      >
        <input
          class="outline-0"
          :value="inputValue"
          :type="inputType"
          :class="{
            'w-[calc(100%-1.5rem)]': isDate,
            'w-full': !isDate,
          }"
          v-bind="$attrs"
          @input="onInput"
        />

        <IPhCalendar
          v-if="isDate"
          class="absolute top-1/2 right-0 -translate-1/2 text-lg text-gray-500"
        />
      </div>
    </label>
  </div>
</template>
