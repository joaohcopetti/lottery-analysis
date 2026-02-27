<script setup lang="ts">
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import IPhFunnel from 'virtual:icons/ph/funnel-fill'
import MainSidebarFilterForm from './MainSidebarFilterForm.vue'
import MainSidebarItem from './MainSidebarItem.vue'
</script>

<template>
  <Popover class="relative z-20 w-full">
    <PopoverButton class="w-full outline-0">
      <MainSidebarItem
        class="w-full"
        label="Filtro"
        slug="filter"
        :icon="IPhFunnel"
      />
    </PopoverButton>

    <Transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="translate-y-1 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-100 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="translate-y-1 opacity-0"
    >
      <PopoverPanel
        class="absolute top-4 left-[calc(110px+10px)] z-20 h-[300px] w-[400px] rounded bg-white p-3 shadow-lg"
      >
        <div
          class="absolute top-4 left-0 -translate-x-full border-8 border-t-transparent border-r-white border-b-transparent border-l-transparent"
        />

        <MainSidebarFilterForm />
      </PopoverPanel>
    </Transition>
  </Popover>
</template>
