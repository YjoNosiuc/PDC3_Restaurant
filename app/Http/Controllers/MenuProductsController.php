<?php

namespace App\Http\Controllers;

use App\Models\MenuProducts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuProductsController extends Controller
{
     // List all menu-product associations
    public function index()
    {
        $menuProducts = MenuProducts::with(['menu', 'product'])->get();
        return response()->json($menuProducts);
    }

    // Show a single association
    public function show(MenuProducts $menuProduct)
    {
        return response()->json($menuProduct->load(['menu', 'product']));
    }

    // Create a new association
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('menu_products')->where(function ($query) use ($request) {
                    return $query->where('menu_id', $request->menu_id);
                }),
            ],
        ]);

        $menuProduct = MenuProducts::create($validated);

        return response()->json($menuProduct, 201);
    }

    // Update an association
    public function update(Request $request, MenuProducts $menuProduct)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('menu_products')->where(function ($query) use ($request, $menuProduct) {
                    return $query->where('menu_id', $request->menu_id)
                                 ->where('id', '!=', $menuProduct->id);
                }),
            ],
        ]);

        $menuProduct->update($validated);

        return response()->json($menuProduct);
    }

    // Delete an association
    public function destroy(MenuProducts $menuProduct)
    {
        $menuProduct->delete();
        return response()->json(['message' => 'Menu Product deleted']);
    }
}
