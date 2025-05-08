<template>
    <span :class="statusClass" class="text-sm px-4 py-1 rounded-full">
        {{ status }}
    </span>
</template>

<script setup lang="ts">
import { computed } from 'vue';
const props = defineProps({
    status: {
        type: String,
        required: true
    }
});
const statusClass = computed(() => {
    switch (props.status) {
        case 'active':
            return 'bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300';
        case 'completed':
            return 'bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300';
        case 'archived': 
            return 'bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300';
        default:
            return '';
    }
});
</script>