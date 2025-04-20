<template>
    <Link :href="href">
        <Button class="cursor-pointer">
            <slot />
        </Button>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from "@/components/ui/button"

defineProps({
    href: {
        type: String,
        required: true,
    },
})
</script>