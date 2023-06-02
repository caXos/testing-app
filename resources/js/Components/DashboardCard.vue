<script setup>
defineProps({
});
</script>

<template>
    <div class="m-2 p-1 border-2 border-gray-300 bg-gray-100 flex flex-col justify-center items-center rounded-2xl min-w-[160px] min-h-[120px] hover:bg-sky-100 text-center">
        <slot name="icon" v-if="$slots.icon" />
        <slot name="title" v-if="$slots.title" />
        <slot name="value" v-if="$slots.value" />
    </div>
</template>
