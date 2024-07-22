<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Поиск по имени
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $categories = $query->get();

        return response()->json([
            'categories' => $categories
        ]);
    }
}
