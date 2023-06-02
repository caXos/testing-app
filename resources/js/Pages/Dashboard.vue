<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';
import DashboardCard from '@/Components/DashboardCard.vue';
import ListIcon from '@/Components/ListIcon.vue';

const props = defineProps({
    taskCount: Number
})

const localTaskCount = ref(props.taskCount)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <MainContainer class="flex justify-center content-center">
            <!-- Tasks -->
            <Link :href="route('tasks')">
                <DashboardCard class="max-w-sm" title="Click to open tasks dashboard">
                    <template #icon>
                        <ListIcon/>
                    </template>
                    <template #title>Tasks</template>
                    <template #value>
                        <div class="flex flex-col gap-y-2">
                            <div v-if="localTaskCount <= 0">No active task</div>
                            <div v-else>{{localTaskCount}} active task<span v-if="localTaskCount >= 2">s</span></div>
                        </div>
                    </template>
                </DashboardCard>
            </Link>
        </MainContainer>
    </AuthenticatedLayout>
</template>
