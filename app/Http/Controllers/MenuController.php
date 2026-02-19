<?php

namespace App\Http\Controllers;


use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
     // List all menus
    public function index()
    {
        return response()->json(Menu::all());
    }

    // Show a single menu
    public function show(Menu $menu)
    {
        return response()->json($menu);
    }

    // Create a new menu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:128|unique:menus,name',
        ]);

        $menu = Menu::create($validated);

        return response()->json($menu, 201);
    }

    // Update an existing menu
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:128',
                Rule::unique('menus')->ignore($menu->id),
            ],
        ]);

        $menu->update($validated);

        return response()->json($menu);
    }

    // Delete a menu (soft delete)
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['message' => 'Menu deleted']);
    }
}
