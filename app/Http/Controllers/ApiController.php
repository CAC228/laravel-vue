<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ApiController extends Controller
{
    public function getItems(Request $request) {
        $query = Item::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        $items = $query->paginate(10);
        return response()->json(['items' => $items]);
    }

    public function getItem($id) {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    public function getCategories(Request $request) {
        $query = Category::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        $categories = $query->paginate(10);
        return response()->json(['categories' => $categories]);
    }
}