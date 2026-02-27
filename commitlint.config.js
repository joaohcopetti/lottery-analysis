export default {
  extends: ['@commitlint/config-conventional'],
  rules: {
    'scope-enum': [
      2,
      'always',
      ['llm', 'migration', 'main-controller', 'date-picker', 'dropdown', 'lint-config'],
    ],
  },
}
