import { useLotteryStore } from '@/stores/lottery-store'
import { DetailedNumberData } from '@/types'
import { computed, ComputedRef, HTMLAttributes } from 'vue'

const LIGHTNESS_THRESHOLD = 55

const NUMBER_CLASSES = {
  DEFAULT: 'transition-all',
  SHARED: 'outline-3 cursor-pointer',
  get HIGHLIGHTED() {
    return this.SHARED + ' scale-110 outline-green-500'
  },
  get SELECTED() {
    return this.SHARED + ' outline-green-500 shadow-[0_0px_5px_5px] shadow-green-400'
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

  const numberElAttrs = computed<HTMLAttributes>(() => {
    const classes: any = [NUMBER_CLASSES.DEFAULT]
    const style: HTMLAttributes['style'] = {}

    if (lotteryStore.isHeatmapEnabled) {
      classes.push(isDark.value ? 'text-gray-200' : 'text-gray-800')
      style.backgroundColor = heatColor.value
    }

    if (!lotteryStore.isHeatmapEnabled) {
      classes.push(' bg-gray-300')
    }

    if (isNumberHighlighted.value) {
      classes.push(NUMBER_CLASSES.HIGHLIGHTED)
    }

    if (isNumberSelected.value) {
      classes.push(NUMBER_CLASSES.SELECTED)
    }

    return {
      class: classes,
      style,
      onFocusin: highlightNumber,
      onFocusout: unhighlightNumber,
      onMouseover: highlightNumber,
      onMouseleave: unhighlightNumber,
      onClick: toggleNumberSelect,
    }
  })

  return {
    heatColor,
    isDark,
    isNumberHighlighted,
    isNumberSelected,
    numberElAttrs,
    paddedNumber,
  }
}
