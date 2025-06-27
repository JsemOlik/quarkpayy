<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { computed } from 'vue';

interface InvoiceItem {
    description: string;
    qty: number;
    price: string;
}

interface Invoice {
    id: number;
    number: string;
    date: string;
    amount: string;
    status: string;
    items: InvoiceItem[];
    user: any;
}

const page = usePage();
const invoice = (page.props.invoice as Invoice);

const breadcrumbItems: BreadcrumbItem[] = [
    { title: 'Invoices', href: '/invoices' },
    { title: invoice.number, href: `/invoices/${invoice.id}` },
];

const statusColor = (status: string) => {
    if (status === 'Paid') return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
    if (status === 'Unpaid') return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
    return 'bg-neutral-100 text-neutral-800 dark:bg-neutral-700/30 dark:text-neutral-200';
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head :title="`Invoice ${invoice.number}`" />
        <div class="min-h-screen bg-neutral-50 dark:bg-transparent">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Invoice {{ invoice.number }}</h1>
                        <p class="mt-2 text-neutral-600 dark:text-neutral-300">
                            Invoice details and breakdown.
                        </p>
                    </div>
                    <span :class="statusColor(invoice.status)" class="px-3 py-1 text-sm font-medium rounded-full">{{ invoice.status }}</span>
                </div>
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden p-6">
                    <div class="mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-300">Invoice Number</div>
                            <div class="font-semibold text-neutral-900 dark:text-white">{{ invoice.number }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-300">Date</div>
                            <div class="font-semibold text-neutral-900 dark:text-white">{{ invoice.date }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-300">Amount</div>
                            <div class="font-semibold text-neutral-900 dark:text-white">${{ invoice.amount }}</div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="text-base font-semibold mb-2 text-neutral-900 dark:text-white">Items</div>
                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="border-b border-neutral-200 dark:border-neutral-700">
                                    <th class="text-left py-2">Description</th>
                                    <th class="text-right py-2">Quantity</th>
                                    <th class="text-right py-2">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, idx) in invoice.items" :key="idx" class="border-b border-neutral-100 dark:border-neutral-700 last:border-b-0">
                                    <td class="py-2">{{ item.description }}</td>
                                    <td class="py-2 text-right">{{ item.qty }}</td>
                                    <td class="py-2 text-right">${{ item.price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 