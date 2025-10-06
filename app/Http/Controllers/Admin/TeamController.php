<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.teams.index', ['teams' => Team::with('members')->get()]);

    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        // Passa todos os utilizadores que não são admin para a view
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.teams.create', compact('users'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'members' => ['required', 'array'],
        'members.*' => ['exists:users,id'],
    ]);

    $team = new Team();
    $team->name = $request->name;
    $team->user_id = Auth::id();
    $team->save();

    // Garante que o ID do admin (Auth::id()) está sempre na lista de membros a ser sincronizada.
    $membersToSync = collect($request->members)->push(Auth::id())->unique();
    
    $team->members()->sync($membersToSync);

    return redirect()->route('admin.teams.index')->with('success', 'Equipa criada com sucesso.');
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

    public function search(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 2) return response()->json([]);

        $teams = \App\Models\Team::where('name', 'LIKE', "%{$query}%")->limit(10)->get();

        return response()->json($teams);
    }
}
