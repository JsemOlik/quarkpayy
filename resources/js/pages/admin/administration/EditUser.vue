<template>
  <Head title="Upravit uživatele" />
  <AppLayout :breadcrumbs="breadcrumbs" variant="sidebar">
    <div class="min-h-screen bg-neutral-50 dark:bg-transparent flex flex-col md:flex-row">
      <!-- Sidebar / Topnav -->
      <aside class="w-full md:w-64 flex md:flex-col flex-row py-4 md:py-8 px-2 md:px-4 border-b md:border-b-0 md:border-r border-neutral-800">
        <nav class="flex md:flex-col flex-row gap-2 w-full justify-between md:justify-start">
          <button
            class="flex items-center gap-3 px-2 md:px-3 py-2 rounded-lg text-sm font-medium transition w-full md:w-auto justify-center md:justify-start"
            :class="currentTab === 'edit' ? 'bg-white/10 text-blue-400' : 'text-neutral-200 hover:bg-white/5 hover:text-white'"
            @click="currentTab = 'edit'"
          >
            <Pencil :size="20" :stroke-width="2.2" :class="currentTab === 'edit' ? 'text-blue-400' : 'text-neutral-400 group-hover:text-white'" />
            <span class="hidden md:inline">Edit User</span>
          </button>
          <button
            class="flex items-center gap-3 px-2 md:px-3 py-2 rounded-lg text-sm font-medium transition text-neutral-200 hover:bg-white/5 hover:text-white w-full md:w-auto justify-center md:justify-start"
            disabled
          >
            <ShoppingCart :size="20" :stroke-width="2.2" class="text-neutral-400 group-hover:text-white" />
            <span class="hidden md:inline">Products/Services</span>
          </button>
          <button
            class="flex items-center gap-3 px-2 md:px-3 py-2 rounded-lg text-sm font-medium transition text-neutral-200 hover:bg-white/5 hover:text-white w-full md:w-auto justify-center md:justify-start"
            disabled
          >
            <FileText :size="20" :stroke-width="2.2" class="text-neutral-400 group-hover:text-white" />
            <span class="hidden md:inline">Invoices</span>
          </button>
          <button
            class="flex items-center gap-3 px-2 md:px-3 py-2 rounded-lg text-sm font-medium transition text-neutral-200 hover:bg-white/5 hover:text-white w-full md:w-auto justify-center md:justify-start"
            disabled
          >
            <FileText :size="20" :stroke-width="2.2" class="text-neutral-400 group-hover:text-white" />
            <span class="hidden md:inline">Credits</span>
          </button>
        </nav>
      </aside>
      <!-- Main Content -->
      <div class="flex-1 max-w-2xl mx-auto px-2 sm:px-4 lg:px-8 py-8 w-full">
        <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-6">Upravit uživatele</h1>
        <form @submit.prevent="submit">
          <div class="space-y-6">
            <div>
              <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">Jméno</label>
              <input id="name" v-model="form.name" type="text" class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white px-3 py-2" />
            </div>
            <div class="flex flex-col md:flex-row gap-4">
              <div class="flex-1">
                <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">Email</label>
                <input id="email" v-model="form.email" type="email" class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white px-3 py-2" />
              </div>
              <div class="flex-1">
                <label for="password" class="block text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">Nové heslo</label>
                <div class="flex items-center w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800">
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    id="password"
                    v-model="form.password"
                    autocomplete="new-password"
                    class="flex-1 bg-transparent border-none focus:ring-0 text-neutral-900 dark:text-white px-3 py-2 rounded-lg focus:outline-none"
                  />
                  <button type="button" @click="showPassword = !showPassword" tabindex="-1"
                    class="h-10 w-10 flex items-center justify-center text-neutral-400 hover:text-neutral-200 focus:outline-none bg-transparent border-none rounded-lg">
                    <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592m3.104-2.727A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.43 5.818M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L6 6" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <div>
              <label for="role" class="block text-sm font-medium text-neutral-700 dark:text-neutral-200 mb-1">Role</label>
              <select id="role" v-model="form.role" class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white px-3 py-2">
                <option value="admin">Admin</option>
                <option value="support">Support Agent</option>
                <option value="user">Uživatel</option>
              </select>
            </div>
          </div>
          <div class="mt-8 flex justify-end gap-2">
            <button type="button" @click="goBack" class="px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-700 transition">Zpět</button>
            <button type="submit" :disabled="form.processing" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition disabled:opacity-50">Uložit změny</button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { User } from '@/types';
import { Pencil, ShoppingCart, FileText } from 'lucide-vue-next';

const page = usePage();
const user = page.props.user as User;

const breadcrumbs = [
  { title: 'Dashboard', href: '/dashboard' },
  { title: 'Uživatelé', href: '/admin/users' },
  { title: user.name, href: `/admin/users/${user.id}/edit` },
];

const form = useForm({
  name: user.name,
  email: user.email,
  role: user.role ?? 'user',
  password: '',
});

const showPassword = ref(false);
const currentTab = ref('edit');

function submit() {
  form.put(`/admin/users/${user.id}`, {
    onSuccess: () => {
      router.visit('/admin/users');
    },
  });
}

function goBack() {
  router.visit('/admin/users');
}
</script> 