<script setup lang="ts">
import { getMonthName } from '@/lib/utils'
import { CalendarDate } from '@/types'
import { kebabCase, upperFirst } from 'lodash-es'
import IPhArrowLeftBold from 'virtual:icons/ph/arrow-left-bold'
import IPhArrowRightBold from 'virtual:icons/ph/arrow-right-bold'
import { computed, inject, ref, type Ref } from 'vue'
import AppButton from '../button/AppButton.vue'
import AppDropdown, { type AppDropdownItem } from '../dropdown/AppDropdown.vue'
import { calendarDateKey } from './date-picker-injection-keys'

const props = defineProps<{
  minDate?: string
}>()
const minDate = ref<Date>(new Date(props.minDate + ' 00:00'))
const selectedDate = inject(calendarDateKey) as Ref<CalendarDate>

const monthsOptions = computed(() => {
  const isSelectedYearMin = minDate.value.getFullYear() === selectedDate.value.year
  const minMonth = minDate.value.getMonth()

  return Array.from({ length: 12 }).map((_, monthIndex) => {
    const monthName = getMonthName(monthIndex)

    return {
      key: kebabCase(monthName),
      label: upperFirst(monthName),
      value: monthIndex,
      disabled: isSelectedYearMin && monthIndex < minMonth,
    } satisfies AppDropdownItem
  })
})

const yearsOptions = computed(() => {
  const yearsLength = new Date().getFullYear() - minDate.value.getFullYear()

  return Array.from({ length: yearsLength + 1 }).map((_, index) => {
    const date = new Date()
    const year = date.getFullYear() - index

    return {
      key: `${year}`,
      label: `${year}`,
      value: year,
    } satisfies AppDropdownItem
  })
})

const incrementMonth = () => {
  if (selectedDate.value.month === 11) {
    selectedDate.value.month = 0
    selectedDate.value.year++

    return
  }

  selectedDate.value.month++
}

const decrementMonth = () => {
  if (selectedDate.value.month === 0) {
    selectedDate.value.month = 11
    selectedDate.value.year--

    return
  }

  selectedDate.value.month--
}
</script>

<template>
  <div class="flex items-center justify-between gap-2">
    <AppButton
      :icon="IPhArrowLeftBold"
      color="light"
      @click="decrementMonth"
    />

    <div class="w-full font-bold">
      <AppDropdown
        class="inline-block w-1/2"
        :items="monthsOptions"
        :button-props="{ color: 'light', label: upperFirst(getMonthName(selectedDate.month)) }"
        :menu-props="{ class: 'w-40 max-h-52' }"
        @item-click="selectedDate.month = $event.value"
      />

      <AppDropdown
        class="inline-block w-1/2"
        :items="yearsOptions"
        :button-props="{ color: 'light', label: `${selectedDate.year}` }"
        :menu-props="{ class: 'w-30 max-h-52' }"
        @item-click="selectedDate.year = $event.value"
      />
    </div>

    <AppButton
      :icon="IPhArrowRightBold"
      color="light"
      @click="incrementMonth"
    />
  </div>
</template>
