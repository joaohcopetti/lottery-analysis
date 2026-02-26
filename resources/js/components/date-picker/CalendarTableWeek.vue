<script setup lang="ts">
import CalendarTableWeekDate from './CalendarTableWeekDate.vue'

defineProps<{
  week: Date[]
}>()
</script>

<template>
  <tr>
    <CalendarTableWeekDate
      v-for="date in week"
      :key="date.toDateString()"
      :date="date"
    />
  </tr>
</template>
