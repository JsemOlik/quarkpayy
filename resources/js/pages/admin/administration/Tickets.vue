<template>

    <Head title="Tickety" />
    <AppLayout :breadcrumbs="breadcrumbs" variant="sidebar">
        <div class="min-h-screen bg-neutral-50 dark:bg-transparent">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header Section -->
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Support Tickets</h1>
                        <p class="mt-2 text-neutral-600 dark:text-neutral-300">
                            Správa a řešení podporních požadavků od hráčů
                        </p>
                    </div>
                    <button type="button" @click="showCreateModal = true"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                        Vytvořit Ticket
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/30">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Otevřené</p>
                                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ openCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-300">V řešení</p>
                                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ inProgressCount }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/30">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Vyřešené</p>
                                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ resolvedCount }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-neutral-100 dark:bg-neutral-700">
                                <svg class="w-6 h-6 text-neutral-600 dark:text-neutral-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-neutral-600 dark:text-neutral-300">Celkem</p>
                                <p class="text-2xl font-bold text-neutral-900 dark:text-white">{{ totalCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div
                    class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 p-6 mb-8">
                    <div class="flex flex-wrap gap-4 items-center">
                        <div>
                            <label
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Status</label>
                            <select v-model="selectedStatus"
                                class="rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                                <option value="">Všechny</option>
                                <option value="open">Otevřené</option>
                                <option value="in_progress">V řešení</option>
                                <option value="resolved">Vyřešené</option>
                                <option value="closed">Uzavřené</option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Priorita</label>
                            <select v-model="selectedPriority"
                                class="rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                                <option value="">Všechny</option>
                                <option value="low">Nízká</option>
                                <option value="medium">Střední</option>
                                <option value="high">Vysoká</option>
                                <option value="urgent">Urgentní</option>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Kategorie</label>
                            <select v-model="selectedCategory"
                                class="rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                                <option value="">Všechny</option>
                                <option value="technical">Technické</option>
                                <option value="gameplay">Gameplay</option>
                                <option value="player_report">Nahlášení hráče</option>
                                <option value="other">Ostatní</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tickets Table -->
                <div
                    class="bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-white">Tickets</h2>
                        <div class="flex gap-2" v-if="selectedTickets.length > 0">
                            <button @click="massComplete" 
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                                Označit jako vyřešené
                            </button>
                            <button @click="massDelete" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                                Smazat
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed">
                            <thead class="bg-neutral-50 dark:bg-neutral-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-12">
                                        ID</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-40">
                                        Předmět</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-32 hidden md:table-cell">
                                        Uživatel</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-24">
                                        Status</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-24 hidden sm:table-cell">
                                        Priorita</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-32 hidden lg:table-cell">
                                        Kategorie</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-28 hidden md:table-cell">
                                        Vytvořeno</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-300 uppercase tracking-wider w-32">
                                        Akce</th>
                                    <th class="px-4 py-3 w-8">
                                        <input type="checkbox" v-model="selectAll" @change="toggleSelectAll">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                <tr v-for="ticket in filteredTickets" :key="ticket.id">
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-white">
                                        #{{ ticket.id }}</td>
                                    <td
                                        class="px-4 py-4 text-sm text-neutral-900 dark:text-white max-w-[10rem] truncate">
                                        {{ ticket.subject }}</td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-white hidden md:table-cell">
                                        {{ ticket.user?.name }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span :class="getStatusClass(ticket.status)"
                                            class="px-2 py-1 text-xs font-medium rounded-full">
                                            {{ getStatusText(ticket.status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <span :class="getPriorityClass(ticket.priority)"
                                            class="px-2 py-1 text-xs font-medium rounded-full">
                                            {{ getPriorityText(ticket.priority) }}
                                        </span>
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-300 hidden lg:table-cell">
                                        {{ getCategoryText(ticket.category) }}
                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-sm text-neutral-600 dark:text-neutral-300 hidden md:table-cell">
                                        {{ ticket.created }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <Link :href="route('admin.tickets.show', ticket.id)"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            Otevřít
                                        </Link>
                                    </td>
                                    <td class="px-4 py-4">
                                        <input type="checkbox" :value="ticket.id" v-model="selectedTickets">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-between">
                        <div class="text-sm text-neutral-600 dark:text-neutral-300">
                            Zobrazeno 1 - {{ tickets.length }} z {{ tickets.length }} tickets
                        </div>
                    </div>
                </div>
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
                        <input v-model="newTicket.subject" type="text"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                    </div>
                    <div v-if="userRole === 'admin'">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Uživatel</label>
                        <input v-model="newTicket.user" type="text"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                        <div v-if="newTicketForm.errors.user" class="text-red-600 text-sm mt-1">
                            {{ newTicketForm.errors.user }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Priorita</label>
                        <select v-model="newTicket.priority"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                            <option value="low">Nízká</option>
                            <option value="medium">Střední</option>
                            <option value="high">Vysoká</option>
                            <option value="urgent">Urgentní</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Kategorie</label>
                        <select v-model="newTicket.category"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2">
                            <option value="technical">Technické</option>
                            <option value="gameplay">Gameplay</option>
                            <option value="player_report">Nahlášení hráče</option>
                            <option value="other">Ostatní</option>
                        </select>
                    </div>
                    <div v-if="userRole === 'admin' || newTicket.participants.length > 0" class="space-y-3">
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Účastníci</label>
                        <div v-for="(participant, index) in newTicket.participants" :key="index" class="flex gap-2">
                            <input v-model="newTicket.participants[index]" type="text"
                                class="flex-1 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2"
                                placeholder="Uživatelské jméno">
                            <button type="button" @click="removeParticipantField(index)"
                                class="px-3 py-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <button type="button" @click="addParticipantField"
                            class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            + Přidat dalšího účastníka
                        </button>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Popis</label>
                        <textarea v-model="newTicket.description" rows="4"
                            class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-900 dark:text-white px-3 py-2"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex justify-end space-x-3">
                    <button @click="showCreateModal = false"
                        class="px-4 py-2 border border-neutral-300 dark:border-neutral-600 text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-all duration-200 transform hover:scale-105 active:scale-95">
                        Zrušit
                    </button>
                    <button @click="createTicket" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                        Vytvořit ticket
                    </button>
                </div>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div v-if="showConfirmModal"
            class="fixed inset-0 backdrop-blur-sm bg-white/30 dark:bg-neutral-900/30 flex items-center justify-center z-50 animate-in fade-in duration-200">
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg max-w-sm w-full p-6 text-center animate-in zoom-in-95 duration-200" @click.stop>
                <h3 class="text-lg font-semibold mb-4 text-neutral-900 dark:text-white">Potvrzení Akce</h3>
                <p class="mb-6 text-neutral-700 dark:text-neutral-300">
                    Opravdu chcete
                    <span class="font-bold" :class="{
                        'text-green-600 dark:text-green-400': actionToConfirm === 'complete',
                        'text-red-600 dark:text-red-400': actionToConfirm === 'delete'
                    }">
                        {{ actionToConfirm === 'complete' ? 'vyřešit' : 'smazat' }}
                    </span>
                    vybrané tickety?
                </p>
                <div class="flex justify-center gap-6">
                    <button @click="confirmAction"
                        :class="[
                            'px-4 py-2 text-white rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg',
                            actionToConfirm === 'complete' 
                                ? 'bg-green-600 hover:bg-green-700' 
                                : 'bg-red-600 hover:bg-red-700'
                        ]">
                        Potvrdit
                    </button>
                    <button @click="cancelAction"
                        class="px-4 py-2 bg-neutral-600 hover:bg-neutral-500 text-white rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg">
                        Zrušit
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps<{ tickets: any[], userRole: string }>();

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tickets', href: '/admin/tickets' },
];

const showCreateModal = ref(false);
const showConfirmModal = ref(false);
const actionToConfirm = ref<'complete' | 'delete' | null>(null);
const selectedStatus = ref('');
const selectedPriority = ref('');
const selectedCategory = ref('');
const searchTerm = ref('');

const tickets = ref(props.tickets);
const userRole = props.userRole;

interface NewTicket {
    subject: string;
    user?: string;
    priority: string;
    category: string;
    description: string;
    participants: string[];
}

const newTicket = ref<NewTicket>({
    subject: '',
    user: '',
    priority: 'medium',
    category: 'technical',
    description: '',
    participants: [],
});

const newTicketForm = useForm({
    subject: '',
    user: '',
    priority: 'medium',
    category: 'technical',
    description: '',
    participants: [] as string[],
});

const filteredTickets = computed(() => {
    return tickets.value.filter((ticket) => {
        const matchesStatus = !selectedStatus.value || ticket.status === selectedStatus.value;
        const matchesPriority = !selectedPriority.value || ticket.priority === selectedPriority.value;
        const matchesCategory = !selectedCategory.value || ticket.category === selectedCategory.value;
        const matchesSearch = !searchTerm.value ||
            ticket.subject.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            (ticket.user?.name?.toLowerCase().includes(searchTerm.value.toLowerCase()));
        return matchesStatus && matchesPriority && matchesCategory && matchesSearch;
    });
});

const openCount = computed(() => filteredTickets.value.filter((t) => t.status === 'open').length);
const inProgressCount = computed(() => filteredTickets.value.filter((t) => t.status === 'in_progress').length);
const resolvedCount = computed(() => filteredTickets.value.filter((t) => t.status === 'resolved').length);
const totalCount = computed(() => filteredTickets.value.length);

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

const selectedTickets = ref<number[]>([]);
const selectAll = ref(false);

const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedTickets.value = filteredTickets.value.map((t) => t.id);
    } else {
        selectedTickets.value = [];
    }
};

const massComplete = () => {
    actionToConfirm.value = 'complete';
    showConfirmModal.value = true;
};

const massDelete = () => {
    actionToConfirm.value = 'delete';
    showConfirmModal.value = true;
};

const confirmAction = async () => {
    if (actionToConfirm.value === 'complete') {
        await axios.post('/admin/tickets/mass-complete', { ids: selectedTickets.value });
    } else if (actionToConfirm.value === 'delete') {
        await axios.post('/admin/tickets/mass-delete', { ids: selectedTickets.value });
    }
    showConfirmModal.value = false;
    actionToConfirm.value = null;
    selectedTickets.value = [];
    selectAll.value = false;
    router.reload({ only: ['tickets'] });
    window.location.reload();
};

const cancelAction = () => {
    showConfirmModal.value = false;
    actionToConfirm.value = null;
};

const addParticipantField = () => {
    newTicket.value.participants.push('');
};
const removeParticipantField = (index: number) => {
    newTicket.value.participants.splice(index, 1);
};

const createTicket = () => {
    if (userRole === 'admin') {
        newTicketForm.subject = newTicket.value.subject;
        newTicketForm.user = newTicket.value.user || '';
        newTicketForm.priority = newTicket.value.priority;
        newTicketForm.category = newTicket.value.category;
        newTicketForm.description = newTicket.value.description;
        newTicketForm.participants = newTicket.value.participants;
    } else {
        newTicketForm.subject = newTicket.value.subject;
        newTicketForm.priority = newTicket.value.priority;
        newTicketForm.category = newTicket.value.category;
        newTicketForm.description = newTicket.value.description;
    }
    newTicketForm.post(route('admin.tickets.store'), {
        onSuccess: () => {
            showCreateModal.value = false;
            newTicketForm.reset();
            newTicket.value = { subject: '', user: '', priority: 'medium', category: 'technical', description: '', participants: [] };
            router.reload({ only: ['tickets'] });
        },
    });
};
</script>