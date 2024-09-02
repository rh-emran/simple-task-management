<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class TeammateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_teammate')->only(['index', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teammates = User::whereHas('roles', function ($query) {
            $query->where('name', 'teammate');
        })->get();

        return view('teammate.index', compact('teammates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teammate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_id' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'position' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $teammate = User::create([
            'name' => $request->name,
            'employee_id' => $request->employee_id,
            'position' => $request->position,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Assign 'Teammate' role to the new user
        $teammateRole = Role::where('name', 'teammate')->first();
        $teammate->roles()->attach($teammateRole->id);

        return redirect()->route('teammates.index');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
