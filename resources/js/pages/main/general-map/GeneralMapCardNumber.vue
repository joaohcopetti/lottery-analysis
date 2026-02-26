<script setup lang="ts">
import { useLotteryNumber } from '@/composables/use-lottery-number'
import { DetailedNumberData } from '@/types'
import { computed } from 'vue'

const props = defineProps<{
  number: DetailedNumberData
}>()

const number = computed(() => props.number)

const { numberElAttrs, paddedNumber } = useLotteryNumber(number)
</script>

<template>
  <button
    class="flex h-full w-full min-w-[75px] flex-col items-center justify-center rounded"
    v-bind="numberElAttrs"
    tabindex="0"
    type="button"
  >
    <div class="font-bold">{{ paddedNumber }}</div>

    <div class="text-xs font-bold">{{ number.occurrences }}</div>

    <div class="text-[.7rem] font-bold opacity-80">
      <template v-if="number.last_occurrence_in_contests !== null">
        <template v-if="number.last_occurrence_in_contests > 0">
          Há {{ number.last_occurrence_in_contests }} jogos
        </template>

        <template v-else>Último jogo</template>
      </template>

      <template v-else>&nbsp;</template>
    </div>
  </button>
</template>
