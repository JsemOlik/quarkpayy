<template>
  <div class="rounded-xl bg-neutral-900/80 dark:bg-neutral-900 shadow p-6 border border-neutral-800">
    <div class="font-semibold text-white mb-2">Active Users ({{ users.length }})</div>
    <div>
      <div v-for="user in users" :key="user.id" class="flex items-center justify-between py-2 border-b border-neutral-800 last:border-b-0">
        <div>
          <div class="font-semibold text-white">{{ user.name }}</div>
          <div class="text-xs text-neutral-400">{{ user.email }}</div>
        </div>
        <div class="text-xs text-neutral-400">{{ user.lastActive }}</div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  users: Array<{
    id: number;
    name: string;
    email: string;
    lastActive: string;
  }>;
}>()
</script> 