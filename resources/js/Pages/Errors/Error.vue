<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';

const props = defineProps({
    error: Object
})

</script>

<template>
    <Head title="Erro" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                Erro
            </h2>
        </template>

        <MainContainer>
            {{ error }}
        </MainContainer>
    </AuthenticatedLayout>
</template>
