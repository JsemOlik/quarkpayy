<template>
  <div class="rounded-xl bg-neutral-900/80 dark:bg-neutral-900 shadow p-6 border border-neutral-800 overflow-x-auto">
    <div class="font-semibold text-white mb-2">Support</div>
    <div class="w-full min-w-[500px]">
      <table class="w-full text-sm text-left">
        <thead>
          <tr class="text-neutral-400 border-b border-neutral-800">
            <th class="py-2 whitespace-nowrap">Subject</th>
            <th class="whitespace-nowrap">Status</th>
            <th class="whitespace-nowrap">User</th>
            <th class="whitespace-nowrap">Created At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="ticket in tickets" :key="ticket.id" class="border-b border-neutral-800 last:border-b-0">
            <td class="py-2 text-white whitespace-nowrap">{{ ticket.subject }}</td>
            <td class="whitespace-nowrap">
              <span class="px-2 py-1 rounded text-xs font-semibold" :class="ticket.status === 'Open' ? 'bg-green-900 text-green-400' : 'bg-neutral-800 text-neutral-400'">
                {{ ticket.status }}
              </span>
            </td>
            <td class="text-white whitespace-nowrap">{{ ticket.user }}</td>
            <td class="text-neutral-400 whitespace-nowrap">{{ ticket.createdAt }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  tickets: Array<{
    id: number;
    subject: string;
    status: string;
    user: string;
    createdAt: string;
  }>;
}>()
</script> 