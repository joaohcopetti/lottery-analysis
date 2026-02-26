<script setup lang="ts">
import { SidebarItemProps } from '@/layout/sidebar/MainSidebarItem.vue'
import { DetailedNumberData, LotteryModel, LotteryResultModel, MainMetadata } from '@/types'
import { computed, provide } from 'vue'
import { lotteryKey, lotteryNumbersKey } from './injection-keys'
import ResultsHeatmapCard from './results-heatmap/ResultsHeatmapCard.vue'
import ResultsListCard from './results-list/ResultsListCard.vue'

const props = defineProps<{
  results: LotteryResultModel[]
  numbers: DetailedNumberData[]
  metadata: MainMetadata
  lottery: LotteryModel
  sidebarItems: SidebarItemProps[]
}>()

const numbers = computed(() => props.numbers)

provide(lotteryNumbersKey, numbers)
provide(lotteryKey, props.lottery)
</script>

<template>
  <div class="flex h-[calc(100vh-var(--spacing)*14)]">
    <main class="flex-1">
      <div class="flex gap-4">
        <ResultsHeatmapCard :numbers="numbers" />

        <ResultsListCard
          class="max-h-[calc(100vh-var(--spacing)*14)]"
          :results="results"
        />
      </div>

      <!-- <div class="w-1/2">
        <GeneralDataCard
          :unlucky-numbers="unluckyNumbers"
          :min-date="metadata.minDate"
          :max-date="metadata.maxDate"
        />
      </div> -->
    </main>
  </div>
</template>
