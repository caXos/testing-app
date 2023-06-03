<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onBeforeMount, onMounted, ref, nextTick } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import FieldSet from '@/Components/Fieldset.vue';
import DangerButton from '@/Components/DangerButton.vue';
import AccountIcon from '@/Components/AccountIcon.vue';
import XIcon from '@/Components/XIcon.vue';

//Props
const props = defineProps({
    task: Object,
    users: Object
})

//Refs
const taskName = ref(null);
const taskForce = ref([]);

//Global variables used for jQuery DataTables
let taskDatatable = null


const taskForm = useForm({
    name: '',
    description: '',
    status: 1,
    deadline: '',
    priority: 1,
    workers: 0

});

//Functions/methods
onBeforeMount(() => {
    // props.task.workers
})

onMounted(() => {
    if (props.task != undefined) {
        taskForm.name = props.task.name
        taskForm.description = props.task.description
        taskForm.status = props.task.status
        taskForm.deadline = props.task.deadline
        taskForm.priority = props.task.priority
        taskForce.value = props.task.workers
    }
})


const submit = () => {
    taskForm.workers = taskForce.value
    console.log(taskForm.workers, taskForce.value)
    if (props.task == undefined) {
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
        })
    } else {
        taskForm.post(route('tasks.update', props.task.id), {
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
                    text: 'Task updated successfully!'
                })
            },
            onFinish: () => {
                taskForm.reset()
            }
        })
    }
}

const showDeleteConfirmationModal = () => {
    Swal.fire({
        title: 'Confirm delete?',
        icon: 'question',
        text: 'Are you sure you want to delete this task? This cannot be undone.',
        showCancelButton: true,
        confirmButtonColor: '#B91C1C',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            taskForm.delete(route('tasks.destroy',[props.task.id]),{
                preserveScroll: true,
                preserveState: true,
                onError: () => {
                Swal.fire({
                        icon: 'error',
                        text: 'Error! Check messages!'
                    })
                }, 
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        text: 'Task deleted successfully!'
                    })
                },
                onFinish: () => taskForm.reset()
            })
        }
    })
}

const addTaskmember = (evt) => {
    let id = parseInt(evt.target.value)
    let found = false
    for (let i = 0; i < taskForce.value.length; i++) {
        let haystack = parseInt(taskForce.value[i].id)
        if (id == haystack) found = true
    }
    if ( found == false ) taskForce.value.push({id: evt.target.value, name: evt.target.selectedOptions[0].innerText})
}

const removeTaskMember = (id) => {
    taskForce.value.splice(id, 1)
}

const clearTaskForce = () => {
    taskForce.value = []
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
                            <InputLabel for="worker" value="Add Worker"/>
                            <select
                                id="worker"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                @change="addTaskmember"
                            >
                                <option value="0" selected disabled >Select an user to add to this taskforce</option>
                                <option v-for="worker in props.users" :value="worker.id" >{{ worker.name }}</option>
                            </select>
                            <InputError :message="taskForm.errors.worker" class="mt-2" />
                        </div>
                    </div>

                    <FieldSet :label="'Taskforce'" id="taskForceFieldset" class="relative" v-if="taskForce.length > 0">
                        <div class="grid grid-flow-col gap-x-2 justify-center">
                            <AccountIcon v-for="(member, index) in taskForce" :key="member.id" :name="member.name" @click="removeTaskMember(index)"/>
                            <div class="justify-self-end" title="Remove all" @click="clearTaskForce" v-if="taskForce.length > 0"><XIcon/></div>
                        </div>
                    </FieldSet>
                </FieldSet>

                

                <div class="w-full mt-6 flex justify-center gap-x-2">
                    <PrimaryButton :class="{ 'opacity-25': taskForm.processing }" :disabled="taskForm.processing">
                        <span v-if="props.task == undefined">Add</span><span v-else>Update </span>
                    </PrimaryButton>
                    <Link :href="route('tasks')">
                        <SecondaryButton @submit.prevent="submit"  :type="'button'">
                            Cancel
                        </SecondaryButton>
                    </Link>
                    <DangerButton @submit.prevent="submit"  :type="'button'" v-if="props.task != undefined" @click="showDeleteConfirmationModal">
                        Delete
                    </DangerButton>
                </div>
            </form>
        </MainContainer>
    </AuthenticatedLayout>
</template>