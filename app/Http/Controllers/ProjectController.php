<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\AttributeValue;




class ProjectController extends Controller
{
   
    public function index(Request $request)
    {
        // Start query builder
        $query = Project::query();
    
        // Get filters from request
        $filters = $request->query('filters', []);
    
        // Apply standard filtering (name, status) with operators
        if (!empty($filters)) {
            foreach ($filters as $key => $filter) {
                if (isset($filter['operator']) && isset($filter['value'])) {
                    $operator = $filter['operator'];
                    $value = $filter['value'];
    
                    // Ensure operator is valid
                    if (!in_array($operator, ['=', '>', '<', 'LIKE'])) {
                        return response()->json(['error' => 'Invalid operator'], 400);
                    }
    
                    // Apply filter
                    if (in_array($key, ['name', 'status'])) {
                        $query->where($key, $operator, $operator === 'LIKE' ? "%{$value}%" : $value);
                    }
                }
            }
        }
    
        // Apply EAV filtering (dynamic attributes)
        if (!empty($filters)) {
            foreach ($filters as $key => $filter) {
                if (!in_array($key, ['name', 'status']) && isset($filter['operator']) && isset($filter['value'])) {
                    $operator = $filter['operator'];
                    $value = $filter['value'];
    
                    // Ensure operator is valid
                    if (!in_array($operator, ['=', '>', '<', 'LIKE'])) {
                        return response()->json(['error' => 'Invalid operator'], 400);
                    }
    
                    $query->whereHas('attributes', function ($q) use ($key, $operator, $value) {
                        $q->whereHas('attributeValues', function ($q2) use ($key, $operator, $value) {
                            $q2->whereHas('attribute', function ($q3) use ($key) {
                                $q3->where('name', $key);
                            })->where('value', $operator, $operator === 'LIKE' ? "%{$value}%" : $value);
                        });
                    });
                }
            }
        }
    
        // Fetch projects with attributes
        $projects = $query->with('attributes.attributeValues')->get();
    
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
    foreach ($request->attributes as $attributeId => $value) {
        AttributeValue::updateOrCreate(
            ['project_id' => $attributeId, 'project_id' => $project->id],
            ['value' => $value]
        );
    }

    return response()->json(['message' => 'Attributes updated successfully']);
}

public function getAttributes(Project $project)
{
    return response()->json($project->attributes()->with('attribute')->get());
}
}
