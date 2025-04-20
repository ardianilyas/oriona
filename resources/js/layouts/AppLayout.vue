<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Toaster } from "@/components/ui/sonner"
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster position="top-right" richColors closeButton />
        <div class="p-8">
            <h3 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">
                <slot name="title" />
            </h3>
            <p class="text-slate-600 dark:text-slate-300">
                <slot name="desc" />
            </p>
            <div class="my-6">
                <slot />
            </div>
        </div>
    </AppLayout>
</template>
