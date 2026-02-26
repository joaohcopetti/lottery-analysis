<script setup lang="ts">
import { chunk } from 'lodash-es'
import { computed } from 'vue'
import CalendarTableHeader from './CalendarTableHeader.vue'
import CalendarTableWeek from './CalendarTableWeek.vue'

const props = defineProps<{
  dates: Date[]
}>()

const weeks = computed(() => chunk(props.dates, 7))
</script>

<template>
  <table>
    <CalendarTableHeader />

    <tbody>
      <CalendarTableWeek
        v-for="(week, index) in weeks"
        :key="`week-${index}`"
        :week="week"
      />
    </tbody>
  </table>
</template>
