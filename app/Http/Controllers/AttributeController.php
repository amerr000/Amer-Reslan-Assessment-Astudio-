<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Attribute;


class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Attribute::all(), 200);
    }

    /**
     * Store a newly created attribute.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:attributes,name',
            'data_type' => 'required|string|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($validated);

        return response()->json($attribute, 201);
    }

    /**
     * Display a specific attribute.
     */
    public function show($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        return response()->json($attribute, 200);
    }

    /**
     * Update an attribute.
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        $validated = $request->validate([
            'name' => "sometimes|string|unique:attributes,name,$id",
            'data_type' => 'sometimes|string|in:text,date,number,select',
        ]);

        $attribute->update($validated);

        return response()->json($attribute, 200);
    }

    /**
     * Remove an attribute from the database.
     */
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        $attribute->delete();

        return response()->json(['message' => 'Attribute deleted'], 200);
    }
}
