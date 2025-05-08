<template>
    <Head title="Create Project" />
    <AppLayout>
        <template #title>Create Project</template>
        <template #desc> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Blanditiis maiores cum eligendi. </template>
        
        <BackLink :href="route('dashboard.projects.index')" />

        <Card class="max-w-2xl">
            <form @submit.prevent="submit" class="[&>div]:mb-4" >
                <div>
                    <Label>Name</Label>
                    <Input v-model="form.name" type="text" placeholder="Saturn project" />
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <Label>Description</Label>
                    <Input v-model="form.description" type="text" placeholder="Project description" />
                    <InputError :message="form.errors.description" />
                </div>
                <div>
                    <Label>Repository url (optional)</Label>
                    <Input v-model="form.repository_url" type="text" placeholder="https://github.com/username/project-name" />
                    <InputError :message="form.errors.repository_url" />
                </div>
                <div>
                    <Button type="submit">Create project</Button>
                </div>
            </form>
        </Card>
    </AppLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import BackLink from '@/components/BackLink.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { toast } from 'vue-sonner';
import Card from '@/components/Card.vue';
import { Label } from "@/components/ui/label"
import { Input } from "@/components/ui/input"
import InputError from '@/components/InputError.vue';
import { Button } from "@/components/ui/button"

const form = useForm({
    name: '',
    description: '',
    repository_url: '',
});

function submit() {
    form.post(route('dashboard.projects.store'), {
        onSuccess: () => toast.success('Project created successfully!'),
        onError: (e) => toast.error(e.name)
    })
}
</script>