export type LotteryResultModel = {
  id: string
  contest: string
  date: string
  numbers: string[]
  even_count: number
  odd_count: number
}

export type LotteryModel = {
  id: number
  slug: string
  label: string
  numbers_per_line: number
  numbers_per_draw: number
  max_numbers: number
}

export type DetailedNumberData = {
  number: string
  occurrences: number
  weight: number
  lightness: number
  last_occurrence_in_contests: number | null
  is_even: boolean
}

export type CalendarDate = {
  day: number
  month: number
  year: number
}

export type MainMetadata = {
  minDate?: string
  maxDate?: string
}
