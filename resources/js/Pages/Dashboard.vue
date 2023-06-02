<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import DashboardCard from '@/Components/DashboardCard.vue';

const props = defineProps({
    task_count: Number
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Tasks -->
                    <!-- <Link :href="route('bookkeeping')">
                        <DashboardCard >
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                            <template #title>Financeiro</template>
                            <template #value>
                                <div class="flex flex-col gap-y-2">
                                    <div v-if="financial_records <= 0">Nenhum lançamento</div>
                                    <div v-else>{{props.financial_records}} lançamento<span v-if="props.financial_records >= 2">s</span></div>
                                    <div title="Saldo" class="rounded-xl border-2"
                                    :class="{'bg-red-200 border-red-400': props.balance_bg_color < 0,'bg-yellow-200 border-yellow-400': props.balance_bg_color == 0,'bg-green-200 border-green-400': props.balance_bg_color > 0,}">R$ {{ props.balance }}</div>
                                </div>
                            </template>
                        </DashboardCard>
                    </Link> -->
                    oe
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
