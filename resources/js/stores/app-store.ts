import { defineStore } from 'pinia'
import { ref } from 'vue'

const getRouteKey = () => {
  const params = Object.entries(route().params).join('&')

  return route().current() + params
}

export const useAppStore = defineStore('app-store', () => {
  const currentRouteKey = ref<string | undefined>(getRouteKey())

  const refreshRouteKey = () => {
    currentRouteKey.value = getRouteKey()
  }

  return {
    currentRouteKey,
    refreshRouteKey,
  }
})
