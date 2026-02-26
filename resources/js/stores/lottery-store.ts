import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useLotteryStore = defineStore('lottery', () => {
  const highlightedNumber = ref<string>('')
  const selectedNumbers = ref<string[]>([])

  const isHighlighted = (number: string) => number === highlightedNumber.value
  const isSelected = (number: string) => selectedNumbers.value.includes(number)

  const selectNumber = (number: string) => {
    selectedNumbers.value.push(number)
  }

  const deselectNumber = (number: string) => {
    const index = selectedNumbers.value.findIndex((selectedNumber) => selectedNumber === number)

    selectedNumbers.value.splice(index, 1)
  }

  return {
    highlightedNumber,
    isHighlighted,
    selectedNumbers,
    selectNumber,
    isSelected,
    deselectNumber,
  }
})
