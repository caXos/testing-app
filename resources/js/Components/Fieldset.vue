<script setup>
defineProps(['label']);
</script>

<template>
    <fieldset class="grow border-2 px-1 pb-1 mb-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <legend v-if="label" class="ml-2">{{ label }}</legend>
        <slot />
    </fieldset>
</template>
