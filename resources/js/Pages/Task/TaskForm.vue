<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, nextTick } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import FieldSet from '@/Components/Fieldset.vue';

//Props
const props = defineProps({
    task: Object,
    users: Object
})

//Refs
const tasks = ref(props.tasks)
const addingTask = ref(false);
const taskName = ref(null);
const workers = ref(props.users);

//Global variables used for jQuery DataTables
let taskDatatable = null

//Functions/methods
onMounted(() => {
    
})

const taskForm = useForm({
    name: '',
    description: '',
    status: 1,
    deadline: '',
    priority: 1,
    workers: ''

});

const submit = () => {
    taskForm.post(route('tasks.store'), {
        preserveState: true,
        preserveScroll: true,
        onError: () => {
            Swal.fire({
                icon: 'error',
                text: 'Error! Check messages!'
            })
        }, 
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                text: 'Task added successfully!'
            })
        },
        onFinish: () => {
            taskForm.reset()
        }
    });
}

</script>

<template>
    <Head title="Tasks Form" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"><span v-if="props.task == null || props.task == undefined">Add</span><span v-else>Edit</span> Task Form</h2>
        </template>

        <MainContainer>
            <form @submit.prevent="submit">
                <FieldSet :label="'Required fields'">
                    <div class="flex flex-wrap gap-x-2">
                        <!-- Task Name -->
                        <div class="mt-2 grow">
                            <InputLabel for="name" value="Task name"/>
                            <TextInput
                                id="name"
                                ref="taskName"
                                v-model="taskForm.name"
                                class="mt-1 block w-full"
                                type="text"
                                required
                                autofocus
                            />
                            <InputError :message="taskForm.errors.taskName" class="mt-2" />
                        </div>
                        <!-- Status -->
                        <div class="mt-2 grow">
                            <InputLabel for="status" value="Status"/>
                            <select id="status" v-model="taskForm.status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="1">Not started/pending</option>
                                <option value="2">In progress</option>
                                <option value="3">Halted/suspended</option>
                                <option value="4">Done/finished</option>
                            </select>
                            <InputError :message="taskForm.errors.status" class="mt-2" />
                        </div>
                        <!-- Priority -->
                        <div class="mt-2 grow">
                            <InputLabel for="priority" value="Priority"/>
                            <TextInput
                                id="priority"
                                v-model="taskForm.priority"
                                class="mt-1 block w-full"
                                type="number"
                                min="0"
                                step=1
                                value="1"
                                required
                            />
                            <InputError :message="taskForm.errors.priority" class="mt-2" />
                        </div>
                    </div>
                </FieldSet>

                <FieldSet :label="'Optional fields'">
                    <div class="flex flex-wrap gap-x-2">
                        <!-- Description -->
                        <div class="mt-2 grow">
                            <InputLabel for="description" value="Description"/>
                            <TextInput
                                id="description"
                                v-model="taskForm.description"
                                class="mt-1 block w-full"
                                type="text"
                            />
                            <InputError :message="taskForm.errors.description" class="mt-2" />
                        </div>
                        <!-- Deadline -->
                        <div class="mt-2 grow">
                            <InputLabel for="deadline" value="Deadline"/>
                            <TextInput
                                id="deadline"
                                v-model="taskForm.deadline"
                                class="mt-1 block w-full"
                                type="datetime-local"
                            />
                            <InputError :message="taskForm.errors.deadline" class="mt-2" />
                        </div>
                        <!-- Worker -->
                        <div class="mt-2 grow">
                            <InputLabel for="worker" value="Worker"/>
                            <select
                                id="worker"
                                v-model="taskForm.workers"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                            >
                                <option v-for="worker in workers" :value="worker.id">{{ worker.name }}</option>
                            </select>
                            <InputError :message="taskForm.errors.worker" class="mt-2" />
                        </div>
                    </div>
                </FieldSet>

                <div class="w-full mt-6 flex justify-center gap-x-2">
                    <PrimaryButton :class="{ 'opacity-25': taskForm.processing }" :disabled="taskForm.processing">Add task</PrimaryButton>
                    <SecondaryButton @submit.prevent="submit"  :type="'button'"> Cancel </SecondaryButton>
                </div>
            </form>
        </MainContainer>
    </AuthenticatedLayout>
</template>