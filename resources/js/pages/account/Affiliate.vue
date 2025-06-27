<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/account/Layout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Affiliate settings',
        href: '/settings/affiliate',
    },
];

// Dummy stats (replace with real data as needed)
const visitors = ref(0);
const signups = ref(0);
const earnings = ref(0);
const affiliateLink = ref('https://demo.paymenteer.org?ref=AuLbVdYlhG');
const copied = ref(false);

function copyLink() {
    navigator.clipboard.writeText(affiliateLink.value).then(() => {
        copied.value = true;
        setTimeout(() => (copied.value = false), 1500);
    });
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Affiliate settings" />
        <SettingsLayout>
            <div class="w-full min-h-screen -mx-8 md:-mx-12 lg:-mx-16 xl:-mx-32 px-0">
                <div class="py-10 px-4 sm:px-8 lg:px-16 xl:px-32">
                    <h1 class="text-4xl font-extrabold text-white mb-8 tracking-tight">Affiliate Dashboard</h1>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-2xl p-8 border border-neutral-700 shadow-lg flex items-center gap-4 hover:scale-[1.025] transition-transform group">
                            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-blue-600/10 group-hover:bg-blue-600/20 transition-colors">
                                <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/></svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-white mb-1">Visitors</div>
                                <div class="text-sm text-neutral-400 mb-2">Total Visitors</div>
                                <div class="text-3xl font-extrabold text-white">{{ visitors }}</div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-2xl p-8 border border-neutral-700 shadow-lg flex items-center gap-4 hover:scale-[1.025] transition-transform group">
                            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-green-600/10 group-hover:bg-green-600/20 transition-colors">
                                <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 17l-4 4m0 0l-4-4m4 4V3"/></svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-white mb-1">Signups</div>
                                <div class="text-sm text-neutral-400 mb-2">Total Signups</div>
                                <div class="text-3xl font-extrabold text-white">{{ signups }}</div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-2xl p-8 border border-neutral-700 shadow-lg flex items-center gap-4 hover:scale-[1.025] transition-transform group">
                            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-yellow-500/10 group-hover:bg-yellow-500/20 transition-colors">
                                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 9c-4.418 0-8-1.79-8-4V7c0-2.21 3.582-4 8-4s8 1.79 8 4v6c0 2.21-3.582 4-8 4z"/></svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-white mb-1">Earnings</div>
                                <div class="text-sm text-neutral-400 mb-2">Total Earnings</div>
                                <div class="text-3xl font-extrabold text-white">${{ earnings }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="max-w-2xl">
                        <div class="text-2xl font-bold text-white mb-2">Affiliate Link</div>
                        <div class="text-sm text-neutral-400 mb-4">Share this link to earn rewards for every signup!</div>
                        <div class="flex items-center gap-3 bg-neutral-900 border border-neutral-700 rounded-xl px-4 py-3 shadow-inner">
                            <input
                                class="flex-1 rounded-lg bg-transparent text-white px-2 py-2 focus:outline-none text-base select-all"
                                :value="affiliateLink"
                                readonly
                            />
                            <button
                                @click="copyLink"
                                :class="[
                                    'px-6 py-2 rounded-lg font-semibold transition-all focus:outline-none focus:ring-2',
                                    copied ? 'bg-green-600 text-white animate-pulse' : 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-400'
                                ]"
                            >
                                <span v-if="!copied">Copy</span>
                                <span v-else>Copied!</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
