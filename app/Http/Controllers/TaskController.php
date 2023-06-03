<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
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
            $tasks = Task::where('active','=',true)->where('status','<=',3)->get();
            $users = User::where('active','=',true)->where('role','<=',4)->get();
            return Inertia::render('Task/TaskDashboard', ['tasks'=>$tasks, 'users'=>$users]);
        } catch (Exception $e) {
            $errorMessage = "Contact an admin and inform error code: [TC-01] \n".$e->getMessage();
            return Inertia::render('Errors/Error', ['error' => $errorMessage]);
        }
    }

    /**
     * Sends refreshed data to the DataTable
     */
    public function refreshedData() {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role <= 4) {
            try {
                $users = User::where('active','=',true)->where('role','<=',3)->get();
                return redirect()->back();
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
                'deadlineTime' => "23:59:59",
                'priority' => $request->priority,
                'workers' => json_encode($request->workers),
                'active' => true
            ]);
            $newTask->save();
            return redirect()->back()->with('obj',$newTask);
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
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
