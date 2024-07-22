<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use App\Models\Group;
use App\Models\Item;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $noAccess = session('no_access') ?? false;

        $categories = $noAccess ? [] : Category::all();
        $groups = $noAccess ? [] : Group::all();
        $items = $noAccess ? [] : Item::all();
        $users = $noAccess ? [] : User::all();

        return Inertia::render('Dashboard', [
            'no_access' => $noAccess,
            'categories' => $categories,
            'groups' => $groups,
            'items' => $items,
            'users' => $users,
        ]);
    }
}
