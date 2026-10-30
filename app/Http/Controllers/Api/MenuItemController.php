<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        return response()->json(MenuItem::with('category', 'variants')->get());
    }

    public function show($id)
    {
        return response()->json(MenuItem::with('category', 'variants')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'uuid', 'exists:menu_categories,id'],
            'code' => ['required', 'string', 'max:50', 'unique:menu_items,code'],
            'name' => ['required', 'string', 'max:150'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'prep_time_minutes' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $item = MenuItem::create($validated);
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $validated = $request->validate([
            'category_id' => ['sometimes', 'uuid', 'exists:menu_categories,id'],
            'code' => ['sometimes', 'string', 'max:50', 'unique:menu_items,code,' . $item->id],
            'name' => ['sometimes', 'string', 'max:150'],
            'base_price' => ['sometimes', 'numeric', 'min:0'],
            'prep_time_minutes' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Menu item deleted successfully']);
    }
}
