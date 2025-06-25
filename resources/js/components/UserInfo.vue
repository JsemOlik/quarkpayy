<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import type { User } from '@/types';
import { computed } from 'vue';
import md5 from 'blueimp-md5';

interface Props {
    user: User;
    showEmail?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    showEmail: false,
});

const { getInitials } = useInitials();

// Compute whether we should show the avatar image
const showAvatar = computed(() => props.user.avatar && props.user.avatar !== '');

// Compute the Gravatar Wavatar URL
const gravatarUrl = computed(() => {
    const email = props.user.email?.trim().toLowerCase() || '';
    const hash = md5(email);
    return `https://www.gravatar.com/avatar/${hash}?d=wavatar`;
});

// Compute the avatar image to use: user avatar or gravatar
const avatarSrc = computed(() => {
    if (showAvatar.value) return props.user.avatar || '';
    return gravatarUrl.value;
});
</script>

<template>
    <Avatar class="h-8 w-8 overflow-hidden rounded-lg">
        <AvatarImage :src="avatarSrc" :alt="user.name" @error="$event.target.style.display = 'none'" />
        <AvatarFallback class="rounded-lg text-black dark:text-white">
            {{ getInitials(user.name) }}
        </AvatarFallback>
    </Avatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
        <span class="truncate font-medium">{{ user.name }}</span>
        <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{ user.email }}</span>
    </div>
</template>
