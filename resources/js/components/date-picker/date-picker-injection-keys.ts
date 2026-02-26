import { CalendarDate } from '@/types'
import { InjectionKey, type Ref } from 'vue'

export const calendarDateKey = Symbol() as InjectionKey<Ref<CalendarDate>>
export const selectedDateKey = Symbol() as InjectionKey<Ref<Date | undefined>>
export const maxDateKey = Symbol() as InjectionKey<string | undefined>
