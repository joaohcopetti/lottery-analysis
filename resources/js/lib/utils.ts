export const getMonthName = (monthZeroBased: number) =>
  new Date(1900, monthZeroBased, 1).toLocaleDateString(navigator.language, {
    month: 'long',
  })

export const dateToLocaleString = (date: string, options?: Intl.DateTimeFormatOptions) => {
  return new Date(date + ' 00:00').toLocaleDateString(navigator.language, options)
}
