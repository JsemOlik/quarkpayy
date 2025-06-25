<template>
  <Head title="Dashboard" />
  <AppLayout :breadcrumbs="breadcrumbs" variant="sidebar">
    <div class="min-h-screen">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-white mb-8">Dashboard</h1>
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <SummaryCard
            title="Revenue"
            :value="revenueValue"
            :subtext="revenueSubtext"
          >
            <template #indicator>
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg>
            </template>
          </SummaryCard>
          <SummaryCard
            title="Tickets"
            :value="ticketsValue"
            :subtext="ticketsSubtext"
          >
            <template #indicator>
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg>
            </template>
          </SummaryCard>
          <SummaryCard
            title="Services"
            :value="servicesValue"
            :subtext="servicesSubtext"
          >
            <template #indicator>
              <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/></svg>
            </template>
          </SummaryCard>
        </div>
        <!-- Chart & Support -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
          <div class="lg:col-span-2">
            <RevenueChart />
          </div>
          <SupportTable :tickets="supportTickets" />
        </div>
        <!-- Active Users -->
        <div class="mb-8">
          <ActiveUsers :users="activeUsers" />
        </div>
        <!-- Admin Logs -->
        <div>
          <AdminLogs :logs="adminLogs" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import SummaryCard from '@/components/dashboard/SummaryCard.vue';
import RevenueChart from '@/components/dashboard/RevenueChart.vue';
import SupportTable from '@/components/dashboard/SupportTable.vue';
import ActiveUsers from '@/components/dashboard/ActiveUsers.vue';
import AdminLogs from '@/components/dashboard/AdminLogs.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
];

// Dummy data for summary cards
const revenueValue = '$1,250.00';
const revenueSubtext = 'Increased by 12.5% (this month)';
const ticketsValue = 8;
const ticketsSubtext = 'Increased by 5.3% (this month)';
const servicesValue = 14;
const servicesSubtext = 'Increased by 2.1% (this month)';

const supportTickets = [
  {
    id: 1,
    subject: 'My server is bricked',
    status: 'Open',
    user: 'Admin Paymenteer',
    createdAt: '2024-10-30 11:23:47',
  },
];

const activeUsers = [
  {
    id: 1,
    name: 'Admin Paymenteer',
    email: 'admin@paymenteer.org',
    lastActive: '0 seconds ago',
  },
  {
    id: 2,
    name: 'Admin Paymenteer',
    email: 'admin@paymenteer.org',
    lastActive: '1 second ago',
  },
  {
    id: 3,
    name: 'Admin Paymenteer',
    email: 'admin@paymenteer.org',
    lastActive: '8 minutes ago',
  },
  {
    id: 4,
    name: 'Admin Paymenteer',
    email: 'admin@paymenteer.org',
    lastActive: '16 minutes ago',
  },
];

const adminLogs = [
  { id: 1, message: 'Admin Paymenteer created a new server', time: '2 minutes ago' },
  { id: 2, message: 'Admin Paymenteer suspended a service', time: '10 minutes ago' },
  { id: 3, message: 'Admin Paymenteer updated billing info', time: '1 hour ago' },
  { id: 4, message: 'Admin Paymenteer responded to a ticket', time: '2 hours ago' },
];
</script>