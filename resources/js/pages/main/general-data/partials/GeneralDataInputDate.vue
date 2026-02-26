<script setup lang="ts">
import AppContainer from '@/components/container/AppContainer.vue'
import AppInputDate from '@/components/input/AppInputDate.vue'
import { router } from '@inertiajs/vue3'
import { useUrlSearchParams } from '@vueuse/core'
import { onMounted, ref } from 'vue'

defineProps<{
  minDate?: string
  maxDate?: string
}>()

const urlParams = useUrlSearchParams()

onMounted(() => {
  if (urlParams.date) {
    date.value = new Date(urlParams.date + ' 00:00')
  }
})

const date = ref<Date | undefined>()

const onDateChange = () => {
  const changedDate = date.value?.toISOString().split('T')[0]

  router.reload({ data: { date: changedDate } })
}
</script>

<template>
  <AppContainer class="mb-3">
    <template #title> <IPhCalendarFill class="mr-1" />A partir de </template>

    <template #body>
      <AppInputDate
        v-model="date"
        placeholder="dd/mm/aaaa"
        :date-picker-props="{ minDate, maxDate }"
        @update:model-value="onDateChange"
      />
    </template>
  </AppContainer>
</template>
