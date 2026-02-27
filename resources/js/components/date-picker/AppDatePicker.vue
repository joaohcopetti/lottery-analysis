<script setup lang="ts">
import { CalendarDate } from '@/types'
import { clone } from 'lodash-es'
import { computed, onMounted, provide, ref, watch } from 'vue'
import CalendarTable from './CalendarTable.vue'
import DatePickerHeader from './DatePickerHeader.vue'
import { calendarDateKey, maxDateKey, selectedDateKey } from './date-picker-injection-keys'

const emit = defineEmits<{
  dateSelected: [value?: Date]
}>()

const props = defineProps<{
  value?: Date
  minDate?: string
  maxDate?: string
}>()

const date = props.value || new Date()

const selectedDate = ref<Date>()
const calendarDate = ref<CalendarDate>({
  day: date.getDate(),
  month: date.getMonth(),
  year: date.getFullYear(),
})

const firstDate = computed(() => {
  const { day, month, year } = calendarDate.value
  const date = new Date(year, month, day)

  date.setDate(1)
  date.setDate(date.getDate() - date.getDay())

  return date
})

const lastDate = computed(() => {
  const { day, month, year } = calendarDate.value
  const date = new Date(year, month, day)

  date.setDate(0)
  date.setMonth(date.getMonth() + 1)
  date.setDate(date.getDate() + (6 - date.getDay()))

  return date
})

const dates = computed(() => {
  const _dates = []
  const date = firstDate.value

  while (firstDate.value <= lastDate.value) {
    _dates.push(clone(date))
    date.setDate(date.getDate() + 1)
  }

  return _dates
})

watch(
  () => selectedDate.value,
  (value) => {
    emit('dateSelected', value)
  },
)

onMounted(() => {
  selectedDate.value = props.value
})

provide(calendarDateKey, calendarDate)
provide(selectedDateKey, selectedDate)
provide(maxDateKey, props.maxDate)
</script>

<template>
  <div class="w-fit">
    <DatePickerHeader :min-date="minDate" />

    <hr class="my-3 border-gray-200" />

    <CalendarTable :dates="dates" />
  </div>
</template>
