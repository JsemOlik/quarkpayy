<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Invoices',
        href: '/invoices',
    },
];

// Dummy invoice data
const invoices = ref([
    {
        id: 1,
        number: 'INV-00001',
        date: '2024-06-01',
        amount: '120.00',
        status: 'Paid',
    },
    {
        id: 2,
        number: 'INV-00002',
        date: '2024-06-10',
        amount: '75.50',
        status: 'Unpaid',
    },
    {
        id: 3,
        number: 'INV-00003',
        date: '2024-06-15',
        amount: '200.00',
        status: 'Paid',
    },
]);

const statusColor = (status: string) => {
    if (status === 'Paid') return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
    if (status === 'Unpaid') return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
    return 'bg-neutral-100 text-neutral-800 dark:bg-neutral-700/30 dark:text-neutral-200';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Invoices" />
        <div class="min-h-screen bg-neutral-50 dark:bg-transparent">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Invoices</h1>
                        <p class="mt-2 text-neutral-600 dark:text-neutral-300">
                            View and manage your invoices.
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex items-center">
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">Your Invoices</h2>
                    </div>
                    <div>
                        <ul>
                            <Link :href="`/invoices/${invoice.id}`" v-for="invoice in invoices" :key="invoice.id"
                                class="flex items-center gap-4 px-6 py-4 cursor-pointer hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-all border-b border-neutral-100 dark:border-neutral-700 last:border-b-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-neutral-900 dark:text-white text-lg">{{ invoice.number }}</span>
                                        <span :class="statusColor(invoice.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                                            {{ invoice.status }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-300 truncate">Date: {{ invoice.date }}</div>
                                </div>
                                <div class="text-base font-medium text-neutral-900 dark:text-white min-w-[100px] text-right">
                                    ${{ invoice.amount }}
                                </div>
                                <Link :href="`/invoices/${invoice.id}`" class="ml-4 text-blue-600 dark:text-blue-400 hover:underline transition-colors" title="View Invoice" @click.stop>
                                    View
                                </Link>
                            </Link>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
