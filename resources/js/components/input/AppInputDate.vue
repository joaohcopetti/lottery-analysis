<script setup lang="ts">
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { computed } from 'vue'
import AppDatePicker from '../date-picker/AppDatePicker.vue'
import AppInput from './AppInput.vue'

defineProps<{
  datePickerProps?: InstanceType<typeof AppDatePicker>['$props']
}>()

const selectedDate = defineModel<Date | undefined>()
const onDateSelect = (value?: Date) => {
  selectedDate.value = value
}

const inputValue = computed(() => selectedDate.value?.toLocaleDateString(navigator.language) || '')
</script>

<template>
  <Popover
    as="div"
    class="relative"
  >
    <PopoverButton class="w-full text-left">
      <AppInput
        v-bind="$attrs"
        type="date"
        :value="inputValue"
      />
    </PopoverButton>

    <PopoverPanel
      as="div"
      class="absolute left-0 z-50 mt-2 origin-top-right divide-y divide-gray-100 rounded-md border-gray-100 bg-white shadow-lg focus:outline-none"
    >
      <AppDatePicker
        class="p-3"
        :value="selectedDate"
        v-bind="datePickerProps"
        @date-selected="onDateSelect($event)"
      />
    </PopoverPanel>
  </Popover>
</template>
