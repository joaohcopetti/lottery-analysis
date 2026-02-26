<script setup lang="ts">
import AppCard from '@/components/card/AppCard.vue'
import { LotteryModel, LotteryResultModel } from '@/types'
import { useVirtualList } from '@vueuse/core'
import IPhListBulletsBold from 'virtual:icons/ph/list-bullets-bold'
import { computed, inject } from 'vue'
import { lotteryKey } from '../injection-keys'
import ResultsListCardItem from './ResultsListCardItem.vue'

const props = defineProps<{
  results: LotteryResultModel[]
}>()
const lottery = inject(lotteryKey) as LotteryModel

const results = computed(() => props.results)

const { list, wrapperProps, containerProps } = useVirtualList(results, {
  itemHeight: 98,
})
</script>

<template>
  <AppCard
    :header-icon="IPhListBulletsBold"
    :body-props="{
      class: `max-h-[calc(100vh-var(--spacing)*34)] min-w-[350px] p-0 ${lottery.slug === 'lotomania' ? 'max-w-[450px]' : ''}`,
      ...containerProps,
    }"
    fade-bottom
  >
    <template #header> Resultados </template>

    <template #body>
      <div v-if="list.length">
        <ul v-bind="{ ...wrapperProps }">
          <ResultsListCardItem
            v-for="result in list"
            :key="result.data.id"
            :result="result.data"
          />
        </ul>
      </div>

      <div
        v-else
        class="my-5 text-center text-sm text-gray-600"
      >
        Nada por aqui
      </div>
    </template>
  </AppCard>
</template>
