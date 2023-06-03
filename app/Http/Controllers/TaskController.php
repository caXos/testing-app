<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks = Task::where('active','=',true)->get();
            if (count($tasks) > 0) {
                foreach($tasks as $task) {
                    switch($task->status){
                        case 1:
                            $task->statusString = "Pending";
                            break;
                        case 2:
                            $task->statusString = "In progress";
                            break;
                        case 3:
                            $task->statusString = "Suspended";
                            break;
                        case 4:
                            $task->statusString = "Done";
                            break;
                        default:
                            break;
                    }
                    if ($task->description == null) $task->description = '';
                    if ($task->deadline == null) $task->deadline = 'Not specified';
                    $task->workers = json_decode($task->workers);
                    // if ($task->workers != null) $task->workers = User::find($task->workers)->get(['name']);
                    // else $task->workers = 'None';
                }
            }
            $users = User::where('active','=',true)->where('role','<=',4)->get();
            return Inertia::render('Task/TaskDashboard', ['tasks'=>$tasks, 'users'=>$users]);
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-01] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role <= 4) {
            try {
                $tasks = Task::where('active','=',true)->where('status','<=',3)->get();
                $users = User::where('active','=',true)->where('role','<=',4)->get(['name', 'id']);
                return Inertia::render('Task/TaskForm', ['tasks'=>$tasks, 'users'=>$users]);
            } catch (Exception $e) {
                $errorMessage = "Contact an admin and inform error code: [TC-02] \n".$e->getMessage();
                return Inertia::render('Errors/Error', ['error' => $errorMessage]);
            }
        } else {
            $errorMessage = "[TC-03]: User not allowed to open create tasks form!";
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);
        try {
            $newTask = new Task([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'deadline' => $request->deadline,
                'priority' => $request->priority,
                'workers' => json_encode($request->workers),
                'active' => true
            ]);
            $newTask->save();
            return redirect()->route('tasks');
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-03] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Task $task)
    {
        try {
            $task = Task::find($request->id);
            $task->workers = json_decode($task->workers);
            $users = User::where('active','=',true)->where('role','<=',4)->get(['name', 'id']);
            return Inertia::render('Task/TaskForm', ['task'=>$task, 'users'=>$users]);
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-04] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = Task::find($request->id);
        $this->authorize('update', $task);
        try {
            $task->name = $request->name;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->deadline = $request->deadline;
            $task->priority = $request->priority;
            $task->workers = json_encode($request->workers);
            $task->active = true;
            $task->save();
            return redirect()->route('tasks');
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-05] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
        $task = Task::find($request->id);
        $this->authorize('delete', $task);
        try {
            $task->delete();
            return redirect()->route('tasks');
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-06] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }
}
