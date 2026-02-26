<script setup lang="ts">
import AppContainer from '@/components/container/AppContainer.vue'
import AppHint from '@/components/hint/AppHint.vue'
import { DetailedNumberData } from '@/types'
import IPhWarningDiamondFill from 'virtual:icons/ph/warning-diamond-fill'
import ResultsListCardItemNumber from '../../results-list/ResultsListCardItemNumber.vue'

defineProps<{
  unluckyNumbers: DetailedNumberData[]
}>()
</script>

<template>
  <AppContainer class="mb-3">
    <template #title> <IPhWarningDiamondFill class="mr-1" /> Jogos sem cair</template>

    <template #body>
      <AppHint class="mb-3">Não cai há mais de 20 jogos</AppHint>

      <div class="flex flex-wrap justify-evenly gap-3">
        <div
          v-for="number in unluckyNumbers"
          :key="number.number"
          class="w-14"
        >
          <ResultsListCardItemNumber :number="number.number" />

          <span class="mt-2 block text-center text-xs text-gray-500">
            {{ number.last_occurrence_in_contests }}
            jogos
          </span>
        </div>
      </div>
    </template>
  </AppContainer>
</template>
