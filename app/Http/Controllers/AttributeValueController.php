<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;


class AttributeValueController extends Controller
{
   
    // Get all attribute values
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->get();
        return response()->json($attributeValues);
    }

    // Store a new attribute value
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'project_id' => 'required|exists:projects,id',
            'value' => 'required'
        ]);

        $attributeValue = AttributeValue::create($validated);

        return response()->json([
            'message' => 'Attribute value created successfully!',
            'attribute_value' => $attributeValue
        ], 201);
    }

    // Show a single attribute value
    public function show(AttributeValue $attributeValue)
    {
        return response()->json($attributeValue);
    }

    // Update an existing attribute value
    public function update(Request $request, AttributeValue $attributeValue)
    {
        $validated = $request->validate([
            'value' => 'required'
        ]);

        $attributeValue->update($validated);

        return response()->json([
            'message' => 'Attribute value updated successfully!',
            'attribute_value' => $attributeValue
        ], 200);
    }

    // Delete an attribute value
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return response()->json(['message' => 'Attribute value deleted successfully']);
    }

 
}
