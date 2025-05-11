<template>
    <Head title="Project Detail" />
    <AppLayout>
        <template #title> {{ project?.name }} </template>
        <template #desc> {{ project?.description }} </template>

        <Card>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 bg-neutral-200 text-muted-foreground rounded-full flex items-center justify-center"> {{ getInitials(project?.creator.name) }} </div>
                <div>
                    <h3 class="text-lg font-medium"> {{ project?.creator.name }} </h3>
                    <p class="text-sm text-muted-foreground">Project Owner</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Input class="max-w-sm" type="text" placeholder="Invite member using email" />
                <Button size="sm">
                    <SendIcon />
                    Send Invitation
                </Button>
            </div>

        </Card>

        <Card class="mt-6">
            <div class="">
                <h3 class="text-lg font-medium">Project Members</h3>
                <Table>
                    <TableCaption>Project members</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>No</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Start Date</TableHead>
                            <TableHead>Jobs</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(member, index) in members" :key="member.id">
                            <TableCell> {{ index + 1 }} </TableCell>
                            <TableCell> {{ member?.name }} </TableCell>
                            <TableCell> {{ member?.email }} </TableCell>
                            <TableCell> {{ member?.pivot.created_at }} </TableCell>
                            <TableCell> Backend Developer </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </Card>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Card from '@/components/Card.vue';
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import { SendIcon } from 'lucide-vue-next';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { useInitials } from '@/composables/useInitials';

const props = defineProps({
    project: Object
});

const members = props.project?.members;

const { getInitials } = useInitials();
</script>