<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/account/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Credit settings',
        href: '/settings/credits',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Credit settings" />

        <SettingsLayout>
           <h1>credits</h1>
        </SettingsLayout>
    </AppLayout>
</template>
