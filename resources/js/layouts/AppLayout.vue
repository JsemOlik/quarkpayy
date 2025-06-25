<script setup lang="ts">
import AppHeaderLayout from '@/layouts/app/AppHeaderLayout.vue';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    variant?: 'header' | 'sidebar';
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    variant: 'header', // default for non-admin
});
</script>

<template>
    <component
        :is="props.variant === 'sidebar' ? AppSidebarLayout : AppHeaderLayout"
        :breadcrumbs="props.breadcrumbs"
    >
        <slot />
    </component>
</template>
