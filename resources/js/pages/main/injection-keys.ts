import { DetailedNumberData, LotteryModel } from '@/types'
import { ComputedRef, InjectionKey } from 'vue'

export const lotteryNumbersKey = Symbol() as InjectionKey<ComputedRef<DetailedNumberData[]>>
export const lotteryKey = Symbol() as InjectionKey<LotteryModel>
