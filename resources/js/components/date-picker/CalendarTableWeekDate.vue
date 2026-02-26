<script setup lang="ts">
import { CalendarDate } from '@/types'
import { computed, inject, Ref } from 'vue'
import { calendarDateKey, maxDateKey, selectedDateKey } from './date-picker-injection-keys'

const props = defineProps<{
  date: Date
}>()

const calendarDate = inject(calendarDateKey) as Ref<CalendarDate>
const selectedDate = inject(selectedDateKey) as Ref<Date | undefined>
const maxDate = inject(maxDateKey) as string | undefined

const isDateToday = computed(() => props.date.toDateString() === new Date().toDateString())
const isDateDisabled = computed(
  () => !isDateMonthCalendarMonth.value || isDateGreaterThanMaxDate.value,
)

const isDateMonthCalendarMonth = computed(() => props.date.getMonth() === calendarDate.value.month)

const isDateGreaterThanMaxDate = computed(() => {
  if (!maxDate) {
    return false
  }
  const date = new Date(maxDate)
  date.setMilliseconds(0)
  date.setSeconds(0)
  date.setMinutes(0)
  date.setHours(0)

  return props.date > date
})

const isDateSelected = computed(
  () => props.date.toDateString() === selectedDate.value?.toDateString(),
)

const selectDate = (date: Date) => {
  if (selectedDate.value?.toDateString() === props.date.toDateString()) {
    selectedDate.value = undefined
    return
  }

  selectedDate.value = date
}
</script>

<template>
  <td class="p-1 text-center">
    <span
      class="relative flex size-8 cursor-pointer items-center justify-center rounded-full text-sm transition-colors"
      :class="{
        'font-semibold': isDateToday,
        'pointer-events-none text-gray-400': isDateDisabled,
        'bg-blue-500 font-bold text-white hover:bg-blue-600': isDateSelected,
        'hover:bg-gray-200 active:bg-gray-300': !isDateSelected,
      }"
      @click="selectDate(date)"
    >
      <span
        v-if="isDateToday"
        class="absolute bottom-2 h-0.5 w-1/2"
        :class="{
          'bg-green-500': !isDateSelected,
          'bg-green-300': isDateSelected,
        }"
      />
      {{ date.getDate() }}
    </span>
  </td>
</template>
