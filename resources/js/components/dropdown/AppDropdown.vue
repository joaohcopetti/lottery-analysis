<script setup lang="ts">
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { HTMLAttributes } from 'vue'
import AppButton from '../button/AppButton.vue'
import { AppButtonProps } from '../button/types'

export type AppDropdownItem = {
  key: string
  label: string
  value: any
  disabled?: boolean
}

defineEmits(['item-click'])
withDefaults(
  defineProps<{
    items: AppDropdownItem[]
    buttonProps: AppButtonProps
    menuProps?: HTMLAttributes
    label?: string
  }>(),
  {
    label: undefined,
    menuProps: () => ({
      class: 'w-56',
    }),
  },
)
</script>

<template>
  <Menu
    as="div"
    class="relative"
  >
    <MenuButton
      :as="AppButton"
      v-bind="{ label, ...buttonProps }"
      class="w-full"
    >
      <slot name="trigger" />
    </MenuButton>

    <MenuItems
      as="div"
      v-bind="menuProps"
      class="scrollbar-custom absolute left-0 z-50 mt-2 origin-top-right divide-y divide-gray-100 rounded-md border border-gray-100 bg-white shadow-lg focus:outline-none"
    >
      <MenuItem
        v-for="item in items"
        :key="item.key"
        as="button"
        class="flex w-full cursor-pointer items-center p-2 text-sm font-normal transition-colors first:rounded-t-md hover:bg-gray-200 active:bg-gray-300"
        :class="{
          'pointer-events-none text-gray-400': item.disabled,
        }"
        @click="$emit('item-click', item)"
      >
        <slot
          v-if="$slots[`item.${item.key}`]"
          :name="`item.${item.key}`"
        />

        <template v-else>{{ item.label }}</template>
      </MenuItem>
    </MenuItems>
  </Menu>
</template>
