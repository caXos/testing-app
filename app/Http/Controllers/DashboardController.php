<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Displays the main Dashboard
     * param: none
     * return: Dashboard view
     */
    public function index() {
        try {
            $taskCount = count(Task::where('status','<=', 3)->where('active','=',true)->get());
            return Inertia::render('Dashboard', ['taskCount' => $taskCount]);
        } catch (Exception $e) {
            return Inertia::render('Errors/Error', ['error' => $response_message]);
        }
    }
}
