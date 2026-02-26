import '../css/app.css'

import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import MainLayout from './layout/MainLayout.vue'
const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const pinia = createPinia()

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) => {
    const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue', { eager: true })
    const page = pages[`./pages/${name}.vue`]

    page.default.layout = MainLayout

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(autoAnimatePlugin)
      .use(pinia)
      .mount(el)
  },
  progress: {
    color: 'var(--color-blue-500)',
    delay: 0,
  },
})
