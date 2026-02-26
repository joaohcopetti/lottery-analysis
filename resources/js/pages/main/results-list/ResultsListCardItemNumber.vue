<script setup lang="ts">
import { useLotteryNumber } from '@/composables/use-lottery-number'
import { DetailedNumberData } from '@/types'
import { computed, ComputedRef, inject } from 'vue'
import { lotteryNumbersKey } from '../injection-keys'

const props = withDefaults(
  defineProps<{
    number: string | number
    showEvenLine?: boolean
  }>(),
  {
    showEvenLine: false,
  },
)

const numbers = inject(lotteryNumbersKey) as ComputedRef<DetailedNumberData[]>

const number = computed(() => numbers.value.find((number) => number.number === props.number)!)

const { numberElAttrs, paddedNumber } = useLotteryNumber(number)
</script>

<template>
  <div class="flex flex-col items-center">
    <button
      class="flex size-10 items-center justify-center rounded-full text-lg font-bold"
      tabindex="1"
      type="button"
      v-bind="numberElAttrs"
    >
      {{ paddedNumber }}
    </button>

    <div
      v-if="showEvenLine"
      class="mt-1 h-1 w-full rounded-xs"
      :class="{
        'bg-blue-400': number.is_even,
        'bg-amber-400': !number.is_even,
      }"
    />
  </div>
</template>
