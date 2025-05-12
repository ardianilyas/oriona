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

            <div v-if="isManager">
                <form class="flex items-center gap-4" @submit.prevent="sendInvitation">
                    <Input v-model="formInvite.email" class="max-w-sm" type="text" placeholder="Invite member using email" />
                    <Button type="submit" size="sm">
                        <SendIcon />
                        Send Invitation
                    </Button>
                </form>
                <InputError :message="formInvite.errors.email" />
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
                            <TableHead>Join Date</TableHead>
                            <TableHead>Jobs</TableHead>
                            <TableHead>Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="(member, index) in members" :key="member.id">
                            <TableCell> {{ index + 1 }} </TableCell>
                            <TableCell> {{ member?.name }} </TableCell>
                            <TableCell> {{ member?.email }} </TableCell>
                            <TableCell> {{ member?.pivot.created_at }} </TableCell>
                            <TableCell> {{ member?.pivot.role }} </TableCell>
                            <TableCell> 
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="outline"> Change Role </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem 
                                        v-for="(role, index) in roles" :key="index"
                                        @click="updateRole(member?.id, role as string)">
                                            {{ role }}
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </Card>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Card from '@/components/Card.vue';
import InputError from '@/components/InputError.vue';
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
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { useInitials } from '@/composables/useInitials';
import { toast } from 'vue-sonner';

const props = defineProps({
    project: Object,
    roles: Array,
    isManager: Boolean,
});

const formRole = useForm<{ role: string }>({
    role: ''
});

const formInvite = useForm<{ email: string }>({
    email: ''
});

const members = props.project?.members;

const { getInitials } = useInitials();

function sendInvitation() {
    formInvite.post(route('dashboard.projects.invite', props.project?.id), {
        onSuccess: () => {
            toast.success('Invitation sent');
            formInvite.reset();
        },
        onError: (errors) => {
            toast.error(errors.email ?? errors[0]);
        }
    })
}

function updateRole(userId: string, newRole:string) {
    formRole.role = newRole;
    formRole.post(route('dashboard.projects.members.role', {
        project: props.project?.id,
        user: userId
    }), {
        onSuccess: () => {
            toast.success(`Role updated to ${newRole}`);
            const member = members.find(m => m.id === userId);
            if(member) {
                member.pivot.role = newRole
            }
        }
    });
}
</script>