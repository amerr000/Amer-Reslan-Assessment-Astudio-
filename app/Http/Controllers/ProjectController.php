<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\AttributeValue;
use App\Models\Attribute;




class ProjectController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Project::query();
    
        $filters = $request->query('filters', []);
    
        $validOperators = ['=', 'LIKE', '<', '>'];
    
        foreach ($filters as $key => $filter) {
            if (!isset($filter['operator']) || !isset($filter['value'])) {
                return response()->json(["error" => "Filter '$key' is missing 'operator' or 'value'"], 400);
            }
    
            $operator = strtoupper($filter['operator']);
            $value = $filter['value'];
    
            if (!in_array($operator, $validOperators)) {
                return response()->json(["error" => "Invalid operator '$operator' for attribute '$key'"], 400);
            }
    
            if (in_array($operator, ['>', '<']) && !is_numeric($value)) {
                return response()->json(["error" => "Operator '$operator' can only be used with numeric values"], 400);
            }
    
            $filters[$key]['operator'] = $operator;
        }
    
        foreach ($filters as $key => $filter) {
            $operator = $filter['operator'];
            $value = $filter['value'];
    
            if (in_array($key, ['name', 'status'])) {
                $query->where($key, $operator, $operator === 'LIKE' ? "%{$value}%" : $value);
            }
        }
    
        // To be continued (apply eav filtering here)###############################
        foreach ($filters as $key => $filter) {
            if (!in_array($key, ['name', 'status'])) {
                $operator = $filter['operator'];
                $value = $filter['value'];
    
                $query->whereHas('attributeValues', function ($q) use ($key, $operator, $value) {
                    $q->whereHas('attribute', function ($q2) use ($key) {
                        $q2->where('name', $key);
                    })->where(function ($q2) use ($operator, $value) {
                        if ($operator === 'LIKE') {
                            $q2->where('value', 'LIKE', "%{$value}%");
                        } else {
                            $q2->whereRaw("LOWER(value) = LOWER(?)", [$value]);
                        }
                    });
                });
            }
        }
    
        $projects = $query->with(['attributeValues.attribute'])->get();
    
        return response()->json($projects);
    }
    
    
    
    

   
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:projects,name',
            'status' => 'required|string',
        ]);

        $project = Project::create($validated);

        return response()->json([
            'message' => 'Project created successfully!',
            'project' => $project,
        ], 201);
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Eager load the attributeValues with attribute
        $project->load('attributeValues.attribute');
    
        return response()->json($project, 200);
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:projects,name,' . $project->id,
            'status' => 'sometimes|string',
        ]);

        $project->update($validated);

        return response()->json([
            'message' => 'Project updated successfully!',
            'project' => $project,
        ], 200);
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully!'
        ], 200);
    }

    public function setAttributes(Request $request, Project $project)
    {
        $validated = $request->validate([
            'attributes' => 'required|array',
            'attributes.*' => 'string'
        ]);
    
        foreach ($validated['attributes'] as $attributeId => $value) {
            AttributeValue::updateOrCreate(
                ['attribute_id' => $attributeId, 'project_id' => $project->id],
                ['value' => $value]
            );
        }
    
        return response()->json(['message' => 'Attributes updated successfully']);
    }

public function getAttributes(Project $project)
{
    $values=Project::with('attributeValues.attribute')->find($project->id);

    return response()->json($values);
}
}
