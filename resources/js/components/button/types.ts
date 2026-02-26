export const BUTTON_COLOR_CLASS_MAP = {
  primary: 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white',
  light: 'bg-white hover:bg-gray-200 active:bg-gray-300 text-gray-900',
  danger: 'bg-red-700 hover:bg-red-800 active:bg-red-900 text-white',
}

export type AppButtonProps = {
  label?: string
  icon?: any
  color?: keyof typeof BUTTON_COLOR_CLASS_MAP
}
