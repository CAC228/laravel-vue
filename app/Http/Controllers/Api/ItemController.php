<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()->with('category');

        // Поиск по имени
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Ограничение по группам
        if ($request->user()->group_id) {
            $query->whereJsonDoesntContain('hidden_for_groups', $request->user()->group_id);
        }

        // Постраничная навигация
        $items = $query->paginate(10);

        return response()->json([
            'items' => $items->items(),
            'current_page' => $items->currentPage(),
            'total_pages' => $items->lastPage()
        ]);
    }

    public function show(Request $request, $id)
    {
        $item = Item::with('category')->find($id);

        if (!$item) {
            return response()->json([
                'error_code' => 404,
                'error_message' => 'Товар не найден'
            ], 404);
        }

        // Ограничение по группам
        if ($request->user()->group_id && in_array($request->user()->group_id, $item->hidden_for_groups)) {
            return response()->json([
                'error_code' => 403,
                'error_message' => 'У вас нет доступа к этому товару'
            ], 403);
        }

        return response()->json($item);
    }
}
