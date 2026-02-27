<script setup lang="ts">
import { useRoute } from '@/../../vendor/tightenco/ziggy'
import AppButton from '@/components/button/AppButton.vue'
import AppInputDate from '@/components/input/AppInputDate.vue'
import { useForm } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const route = useRoute()
const form = useForm<{ date: Date | undefined }>({
  date: undefined,
})

const onSubmit = () => {
  form
    .transform((data) => ({
      ...data,
      date: data.date?.toISOString().split('T')[0],
    }))
    .get(window.location.href)
}

const populateForm = () => {
  const routeParams = route().params

  if (routeParams.date) {
    form.date = new Date(routeParams.date + ' 00:00:00')
  }
}

onMounted(() => {
  populateForm()
})
</script>

<template>
  <form
    class="flex h-full flex-col"
    @submit.prevent="onSubmit"
  >
    <div class="grow">
      <AppInputDate
        id="date"
        v-model="form.date"
        label="A partir de: "
        name="date"
        placeholder="dd/mm/aaaa"
      />
    </div>

    <div class="text-right">
      <AppButton
        :loading="form.processing"
        label="Aplicar"
        class="font-semibold"
      />
    </div>
  </form>
</template>
