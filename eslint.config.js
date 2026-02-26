import eslintPluginPrettierRecommended from 'eslint-plugin-prettier/recommended'
import vue from 'eslint-plugin-vue'

import { defineConfigWithVueTs, vueTsConfigs } from '@vue/eslint-config-typescript'

export default defineConfigWithVueTs(
  vue.configs['flat/recommended'],
  vueTsConfigs.recommended,
  eslintPluginPrettierRecommended,
  {
    ignores: [
      'vendor',
      'node_modules',
      'public',
      'bootstrap/ssr',
      'tailwind.config.js',
      'resources/js/actions',
      'resources/js/routes',
    ],
  },
  {
    rules: {
      '@typescript-eslint/no-explicit-any': 'off',
      'vue/padding-line-between-tags': ['error', [{ blankLine: 'always', prev: '*', next: '*' }]],
      'vue/component-name-in-template-casing': ['warn', 'PascalCase'],
      'vue/padding-line-between-blocks': ['warn', 'always'],
      'vue/html-self-closing': [
        'error',
        {
          html: {
            void: 'any',
          },
        },
      ],
    },
  },
)
