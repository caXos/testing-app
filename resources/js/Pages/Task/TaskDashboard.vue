<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref, nextTick } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import MainContainer from '@/Components/MainContainer.vue';
import HandRaisedIcon from '@/Components/HandRaisedIcon.vue';
import EditIcon from '@/Components/EditIcon.vue';
import InfoIcon from '@/Components/InfoIcon.vue';
import LeaveTeamIcon from '@/Components/LeaveTeamIcon.vue';
import FAB from '@/Components/FloatingActionButton.vue';
import { useForm } from '@inertiajs/vue3';

//Props
const props = defineProps({
    tasks: Object,
})

//Refs
const tasks = ref(props.tasks)

//Global variables used for jQuery DataTables
let taskDatatable = null

const taskDform = useForm({
    
});

//Functions/methods
onMounted(() => {
    taskDatatable = $('#tasksDatatable').DataTable({
		responsive: true,
        select: {
            style: 'multi',
            toggleable: true
        },        
        columnDefs: [
            {
                'targets': [5],
                'sortable': false
            },
            {
                'targets': [2],
                'width': '15%'
            }
        ],
        dom: 'Blfrtip',
        buttons: [
            'selectAll',
            'selectNone',
            'print',
            'pdf',
            'colvis',
            'searchBuilder',
            {
                text: 'Join selected',
                action: join_selected,
                name: 'join_selected',
                enabled: false
            },
            // {
            //     text: 'Apagar selecionados',
            //     action: deactivateSelected,
            //     name: 'delete_selected',
            //     enabled: false
            // },
        ],
	}).on('select', function () {
        if (taskDatatable.rows({selected: true}).count() > 0) {
            taskDatatable.button('join_selected:name').enable()
        //     taskDatatable.button('delete_selected:name').enable()
        };
    }).on('deselect', function () {
        if (taskDatatable.rows({selected: true}).count() < 1) {
            taskDatatable.button('join_selected:name').disable()
        //     taskDatatable.button('delete_selected:name').disable()
        };
    })
})

const more_information = (id) => {
    let temp = `
        <div class="flex justify-between">
            <span>Task description:</span>
            <span>${props.tasks[id].description}</span>
        </div>
        <div class="flex justify-between">
            <span>Status:</span>
            <span>${props.tasks[id].status} -> ${props.tasks[id].statusString}</span>
        </div>
        <div class="flex justify-between">
            <span>Deadline:</span>
            <span>${props.tasks[id].deadline.toLocaleString()}</span>
        </div>
        <div class="flex justify-between">
            <span>Priority:</span>
            <span>${props.tasks[id].priority}</span>
        </div>
        <div class="flex justify-between">
            <span>Taskforce members:</span>
        `
    if (props.tasks[id].workers != null) {
        for (let i=0; i < props.tasks[id].workers.length; i++ ){
            temp += 
            `<span>${props.tasks[id].workers[i]['name']}</span>`
        }
    } else {
        temp += 
            `<span>Empty</span>`
    }
    temp += `
        </div>
        <div class="flex justify-between">
            <span>Last update:</span>
            <span>${new Date(props.tasks[id].updated_at).toLocaleString()}</span>
        </div>`
    Swal.fire({
        title: props.tasks[id].name,
        html: temp
    })
}

const join_selected = () => {
    Swal.fire({
        title: 'Update pending...',
        text: 'Currently this function is not ready. Wait for next updates!'
    })
}

function isInTeam(index) {
    let haystack = []
    for (let i=0; i < tasks.value[index].workers.length; i++) {
        haystack.push( parseInt(tasks.value[index].workers[i].id) )
    }
    return haystack.includes(usePage().props.auth.user.id)
}

const joinTeam = (id) => {
    let taskIndex = tasks.value.find( (checkId) => {return parseInt(checkId.id) == id} )
    taskDform.post(route('tasks.join.team', [taskIndex.id]), {
        preserveScroll: true,
        onSuccess: (res) => {
            console.log(res)
            tasks.value[taskIndex.id-1].workers.push({
                id: usePage().props.auth.user.id,
                name: usePage().props.auth.user.name
            })
            tasks.value[taskIndex.id-1].statusString = "In progress"
            tasks.value[taskIndex.id-1].status = 2
        }
    })
}

const leaveTeam = (id) => {
    let taskIndex = tasks.value.find( (checkId) => {return parseInt(checkId.id) == id} )
    let workerIndex = tasks.value[taskIndex.id-1].workers.findIndex( (checkId) => {return parseInt(checkId.id) == usePage().props.auth.user.id} )
    taskDform.post(route('tasks.leave.team', [taskIndex.id]), {
        preserveScroll: true,
        onSuccess: (res) => {
            console.log(res)
            tasks.value[taskIndex.id-1].workers.splice(workerIndex,1) //taskIndex needs to be reduced by one because v-for uses 1 to length, instead of 0 to (length-1); workerIndex does not needs to be reduced
        }
    })
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
                    <tr v-for="(task, index) in tasks" >
                        <th :class="{'bg-green-200': task.status == 4}">{{ task.id }}</th>
                        <th :class="{'bg-green-200': task.status == 4}">{{ task.name }}</th>
                        <th :class="{'bg-green-200': task.status == 4}"><div class="truncate max-w-2xl">{{ task.description }}</div></th>
                        <th :class="{'bg-green-200': task.status == 4}">{{ task.statusString }}</th>
                        <th :class="{'bg-green-200': task.status == 4}">{{ task.deadline }}</th>
                        <th :class="{'bg-green-200': task.status == 4}">
                            <div class="flex justify-around content-center">
                                <Link :href="route('tasks.edit', [task.id])">
                                    <EditIcon title="Edit task"/>
                                </Link>
                                <InfoIcon title="More information" @click="more_information(index)"/>
                                <HandRaisedIcon title="Join taskforce" v-if="!(isInTeam(index))" @click="joinTeam(task.id)"/>
                                <LeaveTeamIcon title="Leave team" v-else @click="leaveTeam(task.id)"/>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </MainContainer>
        
        <!-- Floating Action Button -->
        <div class="absolute right-5 bottom-5" v-if="usePage().props.auth.user.role <= 4">
            <FAB :model="'task'" :destiny="'tasks.create'" />
        </div>        
    </AuthenticatedLayout>
</template>