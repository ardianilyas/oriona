<template>
    <Link :href="href" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 transition-all ease-in-out">
        <MoveLeft size="20" />
        Back to previous
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { MoveLeft } from 'lucide-vue-next';
defineProps({
    href: {
        type: String,
        required: true
    }
});
</script>