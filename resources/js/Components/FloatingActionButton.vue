<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps(['model', 'destiny', 'args']);

const title = computed(() => 'Add '+props.model);

</script>
<script>

</script>

<template>
    <div id="fab" class="w-10 h-10 rounded-full bg-gray-400 cursor-pointer transition-all hover:scale-125 hover:bg-sky-800 flex justify-center items-center" :title="title" type="button" >
        <Link :href="route(destiny,args)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </Link>
    </div>
</template>
