<script setup lang="ts">
import AppBadge from '@/components/badge/AppBadge.vue'
import { dateToLocaleString } from '@/lib/utils'
import { LotteryResultModel } from '@/types'
import { computed } from 'vue'
import ResultsListCardItemNumber from './ResultsListCardItemNumber.vue'

const props = defineProps<{
  result: LotteryResultModel
}>()

const date = computed(() => dateToLocaleString(props.result.date))

const numbersCount = computed(() => props.result.numbers.length)
const isAllOdd = computed(() => props.result.odd_count === numbersCount.value)
const isAllEven = computed(() => props.result.even_count === numbersCount.value)
</script>

<template>
  <li
    class="px-3 py-2"
    :class="{
      'bg-blue-100': isAllEven,
      'bg-amber-100': isAllOdd,
    }"
  >
    <div class="flex items-center gap-2">
      <span class="text-xs font-bold text-gray-600">Concurso</span>

      <AppBadge
        v-if="isAllOdd || isAllEven"
        size="sm"
        :color="isAllOdd ? 'warning' : 'primary'"
      >
        {{ isAllOdd ? 'TODOS ÍMPARES' : 'TODOS PARES' }}
      </AppBadge>
    </div>

    <div>
      <span class="mr-1 font-semibold">{{ result.contest }}</span>

      <span class="text-xs text-gray-600">({{ date }})</span>
    </div>

    <div class="flex flex-row justify-between gap-4">
      <ResultsListCardItemNumber
        v-for="number in result.numbers"
        :key="`results-list-card-number-${number}`"
        :number="number"
        show-even-line
      />
    </div>
  </li>
</template>
