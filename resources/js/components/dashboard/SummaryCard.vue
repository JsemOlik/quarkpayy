<template>
  <div class="rounded-xl bg-neutral-900/80 dark:bg-neutral-900 shadow p-6 flex flex-col justify-between min-h-[120px] border border-neutral-800">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm text-neutral-400 font-medium">{{ title }}</div>
        <div class="text-2xl font-bold text-white mt-1">{{ value }}</div>
      </div>
      <slot name="icon"></slot>
    </div>
    <div class="mt-2 text-xs text-green-400 flex items-center gap-1">
      <span>{{ subtext }}</span>
      <slot name="indicator"></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string;
  value: string | number;
  subtext?: string;
}>()
</script> 