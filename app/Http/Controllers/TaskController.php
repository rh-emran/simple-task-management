<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_task,create_task')->only('index');
        $this->middleware('permission:create_task')->only(['create', 'store']);
        $this->middleware('permission:assign_task')->only(['edit', 'update']);
        $this->middleware('permission:view_task')->only('complete');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $teammates = User::whereHas('roles', function ($query) {
            $query->where('name', 'teammate');
        })->get();

        $query = Task::with('project', 'assignedUser');

        if ($request->filled('project_id')) {
            $query->where('project_id', request('project_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', request('status'));
        }

        if ($request->filled('teammate_id')) {
            $query->where('assigned_to', request('teammate_id'));
        }

        if ($user->hasRole('manager')) {
            $projects = Project::all();
        } else {
            $projects = Project::whereHas('tasks', function($query) use ($user) {
                $query->where('assigned_to', $user->id);
            })->get();

            $query->where('assigned_to', $user->id);
        }

        $tasks = $query->get();

        return view('task.index', compact('tasks', 'projects', 'teammates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('task.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'project_id' =>['required', 'exists:projects,id'],
            'description' => ['required', 'string'],
            // 'status' => ['required', 'in:Pending,Working,Done']
        ]);

       Task::create([
            'name' => $request->name,
            'project_id' => $request->project_id,
            'description' => $request->description,
            // 'status' => $request->status
            'status' => 'Pending'
        ]);
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task = $task->load('project');

        $teammates = User::whereHas('roles', function ($query) {
            $query->where('name', 'teammate');
        })->get();

        return view('task.edit', compact('teammates', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            // 'status' => ['required', 'in:Pending,Working,Done'],
            'teammate_id' => ['required', 'exists:users,id'],
        ]);

        $task->update([
            // 'status' => $request->status,
            'status' => 'Working',
            'assigned_to' => $request->teammate_id
        ]);

        return redirect()->route('tasks.index');
    }

    /**
     * Complete the specified resource.
     */
    public function complete(Task $task)
    {
        $task->update(['status' => 'Done']);

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
