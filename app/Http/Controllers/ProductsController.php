<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    // List all products
    public function index()
    {
        return response()->json(Products::all());
    }

    // Show a single product
    public function show($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    // Create a new product
    /*public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:128|unique:products,name',
            'price' => 'required|decimal:0,2|min:0',
            'image_path' => 'nullable|string|max:255',
        ]);

        $product = Products::create($validated);

        return response()->json($product, 201);
    }*/

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:128|unique:products,name',
                'price' => 'required|decimal:0,2|min:0',
                'image_path' => 'nullable|string|max:255',
            ]);

            $product = Products::create($validated);

            return response()->json([
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 400); 
        }
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:128',
                Rule::unique('products')->ignore($product->id),
            ],
            'price' => 'required|decimal:0,2|min:0',
            'image_path' => 'nullable|string|max:255',
        ]);

        

        $product->update($validated);

        
        

        return response()->json($product);
    }

    // Delete a product (soft delete)
    public function destroy($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}