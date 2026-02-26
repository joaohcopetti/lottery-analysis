<script setup lang="ts">
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'

defineProps<{
  tabs: { slot: string; label: string }[]
}>()
</script>

<template>
  <div class="w-full">
    <TabGroup>
      <TabList class="flex gap-1 rounded-xs p-1">
        <Tab
          v-for="tab in tabs"
          :key="`tab-${tab.slot}`"
          v-slot="{ selected }"
          as="template"
        >
          <button
            :class="[
              'w-full rounded-sm py-2.5 text-sm leading-5 font-medium transition-all',
              'ring-white/60 ring-offset-2 ring-offset-blue-400',
              selected
                ? 'bg-blue-600 font-semibold text-white'
                : 'cursor-pointer bg-gray-200 text-gray-900 hover:bg-gray-300',
            ]"
          >
            {{ tab.label }}
          </button>
        </Tab>
      </TabList>

      <TabPanels class="mt-2">
        <TabPanel
          v-for="tab in tabs"
          :key="`tab-panel-${tab.slot}`"
          class="px-1"
        >
          <slot :name="tab.slot" />
        </TabPanel>
      </TabPanels>
    </TabGroup>
  </div>
</template>
