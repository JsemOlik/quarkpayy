<template>
    <Head title="Moje Tickety" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-neutral-50 dark:bg-transparent">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="mb-8 flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Moje Tickety</h1>
                    <button type="button" @click="showCreateModal = true"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                        Vytvořit Ticket
                    </button>
                </div>
                <div class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">Moje Tickety</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed">
                            <thead class="bg-neutral-50 dark:bg-neutral-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-12">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-40">Předmět</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-24">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-24">Priorita</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-32">Kategorie</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-28">Vytvořeno</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-32">Akce</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                <tr v-for="ticket in tickets" :key="ticket.id">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-white">#{{ ticket.id }}</td>
                                    <td class="px-4 py-4 text-sm text-neutral-900 dark:text-white max-w-[10rem] truncate">{{ ticket.subject }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span :class="getStatusClass(ticket.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                                            {{ getStatusText(ticket.status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span :class="getPriorityClass(ticket.priority)" class="px-2 py-1 text-xs font-medium rounded-full">
                                            {{ getPriorityText(ticket.priority) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-300">
                                        {{ getCategoryText(ticket.category) }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-300">
                                        {{ ticket.created }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <Link :href="route('tickets.reply', ticket.id)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Otevřít</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Create Ticket Modal -->
                <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 animate-in fade-in duration-200">
                    <div class="bg-white dark:bg-neutral-800 rounded-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto animate-in zoom-in-95 duration-200">
                        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Vytvořit nový ticket</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Předmět</label>
                                <input v-model="newTicketForm.subject" type="text" class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Popis</label>
                                <textarea v-model="newTicketForm.description" rows="4" class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2"></textarea>
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end space-x-3">
                            <button @click="showCreateModal = false" class="px-4 py-2 border border-neutral-300 dark:border-neutral-600 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-all duration-200 transform hover:scale-105 active:scale-95">Zrušit</button>
                            <button @click="createTicket" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">Vytvořit ticket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tickets', href: '/tickets/create' },
];

const showCreateModal = ref(false);
const tickets = ref<any[]>([]);

const newTicketForm = ref({
    subject: '',
    priority: 'medium',
    category: 'technical',
    description: '',
});

const getStatusClass = (status: string) => {
    const classes: Record<string, string> = {
        open: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        in_progress: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        resolved: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        closed: 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
    };
    return classes[status] || classes.open;
};

const getStatusText = (status: string) => {
    const texts: Record<string, string> = {
        open: 'Otevřené',
        in_progress: 'V řešení',
        resolved: 'Vyřešené',
        closed: 'Uzavřené',
    };
    return texts[status] || 'Neznámé';
};

const getPriorityClass = (priority: string) => {
    const classes: Record<string, string> = {
        low: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        medium: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        high: 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
        urgent: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    };
    return classes[priority] || classes.medium;
};

const getPriorityText = (priority: string) => {
    const texts: Record<string, string> = {
        low: 'Nízká',
        medium: 'Střední',
        high: 'Vysoká',
        urgent: 'Urgentní',
    };
    return texts[priority] || 'Střední';
};

const getCategoryText = (category: string) => {
    const texts: Record<string, string> = {
        technical: 'Technické',
        gameplay: 'Gameplay',
        player_report: 'Nahlášení hráče',
        other: 'Ostatní',
    };
    return texts[category] || 'Ostatní';
};

const fetchTickets = async () => {
    const response = await axios.get('/api/my-tickets');
    tickets.value = response.data;
};

const createTicket = async () => {
    await axios.post('/api/my-tickets', newTicketForm.value);
    showCreateModal.value = false;
    newTicketForm.value = { subject: '', priority: 'medium', category: 'technical', description: '' };
    fetchTickets();
};

onMounted(() => {
    fetchTickets();
});
</script> 