<script setup lang="ts">
import AppCard from '@/components/card/AppCard.vue'
import { DetailedNumberData } from '@/types'
import IPhInfo from 'virtual:icons/ph/info-bold'
import GeneralDataInputDate from './partials/GeneralDataInputDate.vue'
import GeneralDataUnluckyNumbers from './partials/GeneralDataUnluckyNumbers.vue'

defineProps<{
  unluckyNumbers: DetailedNumberData[]
  minDate?: string
  maxDate?: string
}>()
</script>

<template>
  <AppCard
    :header-icon="IPhInfo"
    :body-props="{ class: 'h-[calc(100vh-80px)]' }"
  >
    <template #header> Dados gerais </template>

    <template #body>
      <GeneralDataInputDate
        :min-date="minDate"
        :max-date="maxDate"
      />

      <GeneralDataUnluckyNumbers :unlucky-numbers="unluckyNumbers" />
    </template>
  </AppCard>
</template>
