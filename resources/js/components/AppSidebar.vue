<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Landmark, ShoppingBag, ServerCrash, FolderOpen, Box, Headset, Users, Settings2, Ticket, CircleDollarSign, Cog, ShieldCheck, Puzzle, CreditCard, Server, RefreshCcw, Mails, Archive, CircleAlert, LockKeyhole, FileCog  } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const headerNavItems: NavItem[] = [
{
        title: 'Dashboard',
        href: '/admin',
        icon: LayoutGrid,
    },
];

const mainNavItems: NavItem[] = [
    {
        title: 'Invoices',
        href: '/admin/invoices',
        icon: Landmark,
    },
    {
        title: 'Orders',
        href: '/admin/invoices',
        icon: ShoppingBag,
    },
    {
        title: 'Services',
        href: '/admin/services',
        icon: ServerCrash,
    },    
    {
        title: 'Categories',
        href: '/admin/categories',
        icon: FolderOpen,
    },
    {
        title: 'Products',
        href: '/admin/products',
        icon: Box,
    },  
    {
        title: 'Users',
        href: '/admin/users',
        icon: Users,
    },
    {
        title: 'Tickets',
        href: '/admin/tickets',
        icon: Headset,
    },
];

const configNavItems: NavItem[] = [
    {
        title: 'Config Options',
        href: '/admin/config-options',
        icon: Settings2,
    },
    {
        title: 'Coupons',
        href: '/admin/coupons',
        icon: Ticket,
    },
    {
        title: 'Currencies',
        href: '/admin/currencies',
        icon: CircleDollarSign,
    },
    {
        title: 'User Properties',
        href: '/admin/user-properties',
        icon: FileCog,
    },
    {
        title: 'Roles',
        href: '/admin/roles',
        icon: ShieldCheck,
    },
];

const extensionsNavItems: NavItem[] = [
    {
        title: 'Extensions',
        href: '/admin/extensions',
        icon: Puzzle,
    },
    {
        title: 'Gateways',
        href: '/admin/gateways',
        icon: CreditCard,
    },
    {
        title: 'Servers',
        href: '/admin/server',
        icon: Server,
    },
];

const systemNavItems: NavItem[] = [
    {
        title: 'Settings',
        href: '/admin/settings',
        icon: Cog,
    },
    {
        title: 'Updates',
        href: '/admin/updates',
        icon: RefreshCcw,
    },
];

const otherNavItems: NavItem[] = [
    {
        title: 'Email Logs',
        href: '/admin/email-logs',
        icon: Mails,
    },
    {
        title: 'Email Templates',
        href: '/admin/email-templates',
        icon: Archive,
    },
    {
        title: 'Failed Jobs',
        href: '/admin/failed-jobs',
        icon: CircleAlert,
    },
    {
        title: 'Oauth Clients',
        href: '/admin/oauth-clients',
        icon: LockKeyhole,
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader> 
        <SidebarContent>   
            <NavMain :items="headerNavItems" /> 
            <NavMain :items="mainNavItems" group-label="Administration" />
            <NavMain :items="configNavItems" group-label="Configuration" />
            <NavMain :items="extensionsNavItems" group-label="Extensions" />
            <NavMain :items="systemNavItems" group-label="System" />
            <NavMain :items="otherNavItems" group-label="Other" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
