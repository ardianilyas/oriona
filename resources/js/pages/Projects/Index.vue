<template>
    <Head title="Projects" />
    <AppLayout>
        <template #title>Projects</template>
        <template #desc>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque accusantium saepe delectus!
        </template>

        
        <Card>
            <ButtonLink :href="route('dashboard.projects.create')">
                <PlusIcon />
                Create Project
            </ButtonLink>
            <Table class="mt-2">
                <TableCaption>Project list</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>No</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Created at</TableHead>
                        <TableHead>Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="(project, index) in projects" :key="project">
                        <TableCell> {{ index + 1 }} </TableCell>
                        <TableCell> {{ project.name }} </TableCell>
                        <TableCell> {{ project.description }} </TableCell>
                        <TableCell> {{ project.status }} </TableCell>
                        <TableCell> {{ project.created_at }} </TableCell>
                        <TableCell class="flex gap-3">
                            <Button @click="openEditDialog(project)">
                                <PencilIcon />
                            </Button>
                            <Button @click="confirmDelete(project)" variant="destructive">
                                <Trash2Icon />
                            </Button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </Card>

        <!-- Edit dialog -->
        <Dialog v-model:open="isEditDialogOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Edit Project</DialogTitle>
                    <DialogDescription>Edit project details</DialogDescription>
                </DialogHeader>
                <form @submit.prevent="submitEdit" class="[&>div]:mb-4 min-w-full">
                    <div>
                        <Label>Name</Label>
                        <Input v-model="editForm.name" type="text" />
                        <InputError :message="editForm.errors.name" />
                    </div>
                    <div>
                        <Label>Description</Label>
                        <Input v-model="editForm.description" type="text" />
                        <InputError :message="editForm.errors.description" />
                    </div>
                    <div>
                        <Label>Status</Label>
                        <Select class="w-full" v-model="editForm.status">
                            <SelectTrigger>
                                <SelectValue placeholder="Select status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="active">Active</SelectItem>
                                <SelectItem value="completed">Completed</SelectItem>
                                <SelectItem value="archived">Archived</SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                    <div>
                        <Label>Repository URL (optional)</Label>
                        <Input v-model="editForm.repository_url" type="text" />
                        <InputError :message="editForm.errors.repository_url" />
                    </div>
                    <div class="flex gap-4">
                        <Button type="button" @click="closeEditDialog" variant="outline">
                            Cancel
                        </Button>
                        <Button type="submit" :disabled="editForm.processing">Update</Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>

        <!-- Delete dialog -->
        <Dialog v-model:open="isDeleteOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Confirm Delete</DialogTitle>
                    <DialogDescription>
                        Are you sure want to delete <b>{{ selectedProject?.name }}</b> ? This action cannot be undone.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button variant="outline">Cancel</Button>
                    </DialogClose>
                    <form @submit.prevent="deleteProject">
                        <Button type="submit" variant="destructive">Delete</Button>
                    </form>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import ButtonLink from '@/components/ButtonLink.vue';
import { Button } from "@/components/ui/button"
import Card from '@/components/Card.vue';
import InputError from '@/components/InputError.vue';
import { PlusIcon, PencilIcon, Trash2Icon } from 'lucide-vue-next';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { Label } from "@/components/ui/label"
import { Input } from "@/components/ui/input"
import { toast } from 'vue-sonner';

interface Project {
    id: string,
    name: string,
    status: string,
    description: string,
    repository_url: string,
}

defineProps({
    projects: Object
});

const isEditDialogOpen = ref(false);
const isDeleteOpen = ref(false);
const selectedProject = ref();
const deleteForm = useForm({})
const editForm = useForm({
    id: '',
    name: '',
    status: '',
    description: '',
    repository_url: ''
});

const openEditDialog = (project: Project) => {
    editForm.id = project.id
    editForm.name = project.name
    editForm.status = project.status
    editForm.description = project.description
    editForm.repository_url = project.repository_url
    isEditDialogOpen.value = true
}

const closeEditDialog = () => {
    isEditDialogOpen.value = false;
    editForm.reset();
    editForm.clearErrors();
}

const submitEdit = () => {
    editForm.patch(route('dashboard.projects.update', editForm.id), {
        onSuccess: () => {
            closeEditDialog()
            toast.success("Project edited successfully")
        }
    })
}

const confirmDelete = (project: Project) => {
    selectedProject.value = project;
    isDeleteOpen.value = true;
}

const deleteProject = () => {
    if(selectedProject.value) {
        deleteForm.delete(route('dashboard.projects.destroy', selectedProject.value.id), {
            onSuccess: () => {
                isDeleteOpen.value = false
                toast.success("Project deleted")
            }
        })
    }
}

</script>