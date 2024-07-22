<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Group::all());
        }

        $groups = Group::all();
        return Inertia::render('Dashboard', ['groups' => $groups]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Group::create($request->all());

        return back()->with('success', 'Группа успешно создана.');
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group->update($request->all());

        return back()->with('success', 'Группа успешно обновлена.');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return back()->with('success', 'Группа успешно удалена.');
    }
}
