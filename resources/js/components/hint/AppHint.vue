<script setup lang="ts">
import IPhInfoFill from 'virtual:icons/ph/info-fill'
</script>

<template>
  <div class="flex items-center gap-2 text-sm text-gray-500">
    <IPhInfoFill />

    <div>
      <slot />
    </div>
  </div>
</template>
