<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, nextTick } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import HandRaisedIcon from '@/Components/HandRaisedIcon.vue';
import EditIcon from '@/Components/EditIcon.vue';
import AddIcon from '@/Components/AddIcon.vue';

//Props
const props = defineProps({
    tasks: Object,
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
    taskDatatable = $('#tasksDatatable').DataTable({
		responsive: true,
        select: {
            style: 'multi',
            toggleable: true,
            selector: 'td:not(:last-child)'
        },        
        columnDefs: [
            {
                'targets': [5],
                'sortable': false
            },
        ],
        dom: 'Blfrtip',
        buttons: [
            'selectAll',
            'selectNone',
            // {
            //     text: 'Marcar selecionados como visualizados',
            //     action: markSelectedAsSeen,
            //     name: 'mark_selected_as_seen',
            //     enabled: false
            // },
            // {
            //     text: 'Apagar selecionados',
            //     action: deactivateSelected,
            //     name: 'delete_selected',
            //     enabled: false
            // },
        ],
	}).on('select', function () {
        // if (alertsTable.rows({selected: true}).count() > 0) {
        //     alertsTable.button('mark_selected_as_seen:name').enable()
        //     alertsTable.button('delete_selected:name').enable()
        // };
    }).on('deselect', function () {
        // if (alertsTable.rows({selected: true}).count() < 1) {
        //     alertsTable.button('mark_selected_as_seen:name').disable()
        //     alertsTable.button('delete_selected:name').disable()
        // };
    })
})

const openTaskForm = () => {
    addingTask.value = true;

    nextTick(() => taskName.value.focus());
};

const taskForm = useForm({
    name: '',
    description: '',
    status: 1,
    deadlineDay: '',
    deadlineTime: '',
    priority: 1,
    workers: ''

});

const closeModal = () => {
    addingTask.value = false;

    taskForm.reset();
};

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
            tasks.value.push(usePage().props.flash.obj)
            // taskDatatable.data.reload()
            // taskDatatable.clear().draw()
            // taskDatatable.ajax.reload(null,false)
            // taskDatatable.rows().invalidate().draw();
            taskDatatable.clear().rows.add(tasks.value)
        },
        onFinish: () => {
            taskForm.reset(),
            addingTask.value = false
        }
    });
}

const tableRedraw = () => {

}
</script>

<template>
    <Head title="Tasks Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tasks Dashboard</h2>
        </template>

        <MainContainer>
            <table id="tasksDatatable" class="hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks">
                        <th>{{ task.id }}</th>
                        <th>{{ task.name }}</th>
                        <th>{{ task.description }}</th>
                        <th>{{ task.status }}</th>
                        <th>{{ task.deadline }}</th>
                        <th>
                            <div class="flex justify-around content-center">
                                <EditIcon title="Edit task"/>
                                <HandRaisedIcon title="Claim task"/>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </MainContainer>
        
        <!-- Floating Action Button -->
        <div class="absolute right-5 bottom-5" v-if="usePage().props.auth.user.role <= 4">
            <div class="w-10 h-10 rounded-full bg-gray-400 cursor-pointer transition-all hover:scale-125 hover:bg-sky-800 flex justify-center items-center"
                id="addTaskFAB"
                title="Add task"
                @click="openTaskForm"
            >
                <AddIcon />
            </div>
        </div>
        
        <!-- Modal -->
        <Modal :show="addingTask" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create new task
                </h2>

                <form @submit.prevent="submit">
                    <!-- Task Name -->
                    <div class="mt-6">
                        <InputLabel for="name" value="Task name*"/>
                        <TextInput
                            id="name"
                            ref="taskName"
                            v-model="taskForm.name"
                            class="mt-1 block w-3/4 px-2"
                            required
                        />
                        <InputError :message="taskForm.errors.taskName" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <InputLabel for="description" value="Description"/>
                        <TextInput
                            id="description"
                            v-model="taskForm.description"
                            class="mt-1 block w-3/4 px-2"
                        />
                        <InputError :message="taskForm.errors.description" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="mt-6">
                        <InputLabel for="status" value="Status"/>
                        <TextInput
                            id="status"
                            v-model="taskForm.status"

                            type="number"
                            min="0"
                            step=1
                            value="1"
                            required
                        />
                        <InputError :message="taskForm.errors.status" class="mt-2" />
                    </div>

                    <!-- Deadline -->
                    <div class="mt-6">
                        <InputLabel for="deadline" value="Deadline"/>
                        <TextInput
                            id="deadline"
                            v-model="taskForm.deadline"
                            class="mt-1 block w-3/4 px-2"
                            type="date"
                        />
                        <InputError :message="taskForm.errors.deadline" class="mt-2" />
                    </div>

                    <!-- Priority -->
                    <div class="mt-6">
                        <InputLabel for="priority" value="Priority"/>
                        <TextInput
                            id="priority"
                            v-model="taskForm.priority"
                            class="mt-1 block w-3/4 px-2"
                            type="number"
                            min="0"
                            step=1
                            value="1"
                            required
                        />
                        <InputError :message="taskForm.errors.priority" class="mt-2" />
                    </div>

                    <!-- Worker -->
                    <div class="mt-6">
                        <InputLabel for="worker" value="Worker"/>
                        <select
                            id="worker"
                            v-model="taskForm.workers"
                            class="mt-1 block w-3/4 px-2"
                        >
                            <option v-for="worker in workers" :value="worker.id">{{ worker.name }}</option>
                        </select>
                        <InputError :message="taskForm.errors.worker" class="mt-2" />
                    </div>

                    <div class="w-full mt-6 flex justify-between">
                        <PrimaryButton :class="{ 'opacity-25': taskForm.processing }" :disabled="taskForm.processing">Add task</PrimaryButton>
                        <SecondaryButton @click="closeModal" @submit.prevent="submit"  :type="'button'"> Cancel </SecondaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>