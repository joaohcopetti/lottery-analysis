import { useLotteryStore } from '@/stores/lottery-store'
import { DetailedNumberData } from '@/types'
import { computed, ComputedRef, HTMLAttributes } from 'vue'

const LIGHTNESS_THRESHOLD = 55

const NUMBER_CLASSES = {
  DEFAULT: 'transition-all',
  SHARED: 'outline-3 cursor-pointer',
  get HIGHLIGHTED() {
    return this.SHARED + ' scale-110 outline-green-500 z-[150]'
  },
  get SELECTED() {
    return this.SHARED + ' outline-green-500 shadow-[0_0px_5px_5px] shadow-green-400 z-[100]'
  },
}

export function useLotteryNumber(number: ComputedRef<DetailedNumberData>) {
  const lotteryStore = useLotteryStore()

  const heatColor = computed(() => `hsl(3, 70%, ${number.value.lightness}%)`)
  const isDark = computed(() => number.value.lightness < LIGHTNESS_THRESHOLD)
  const isNumberHighlighted = computed(() => lotteryStore.isHighlighted(number.value.number))
  const isNumberSelected = computed(() => lotteryStore.isSelected(number.value.number))
  const paddedNumber = computed(() => number.value.number.padStart(2, '0'))

  const highlightNumber = () => {
    lotteryStore.highlightedNumber = number.value.number
  }

  const unhighlightNumber = () => {
    lotteryStore.highlightedNumber = ''
  }

  const toggleNumberSelect = () => {
    if (lotteryStore.isSelected(number.value.number)) {
      lotteryStore.deselectNumber(number.value.number)
      return
    }

    lotteryStore.selectNumber(number.value.number)
  }

  const numberElAttrs = computed<HTMLAttributes>(() => ({
    class: [
      NUMBER_CLASSES.DEFAULT,
      {
        'text-gray-200': isDark.value,
        'text-gray-800': !isDark.value,
        [NUMBER_CLASSES.HIGHLIGHTED]: isNumberHighlighted.value,
        [NUMBER_CLASSES.SELECTED]: isNumberSelected.value,
      },
    ],
    style: {
      backgroundColor: heatColor.value,
    },
    onFocusin: highlightNumber,
    onFocusout: unhighlightNumber,
    onMouseover: highlightNumber,
    onMouseleave: unhighlightNumber,
    onClick: toggleNumberSelect,
  }))

  return {
    heatColor,
    isDark,
    isNumberHighlighted,
    isNumberSelected,
    numberElAttrs,
    paddedNumber,
  }
}
