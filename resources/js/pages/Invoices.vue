<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/account/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Invoice settings',
        href: '/invoices',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Invoice settings" /><div class="w-full h-full p-12">
            <h1>skibidi</h1>
        </div>
    </AppLayout>
</template>
