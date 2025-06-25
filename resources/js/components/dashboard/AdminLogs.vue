<template>
  <div class="rounded-xl bg-neutral-900/80 dark:bg-neutral-900 shadow p-6 border border-neutral-800">
    <div class="font-semibold text-white mb-2">Admin Logs</div>
    <div>
      <div v-for="log in logs" :key="log.id" class="flex items-center justify-between py-2 border-b border-neutral-800 last:border-b-0">
        <div class="text-white">{{ log.message }}</div>
        <div class="text-xs text-neutral-400">{{ log.time }}</div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  logs: Array<{
    id: number;
    message: string;
    time: string;
  }>;
}>()
</script> 