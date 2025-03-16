<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
   
    public function index()
    {
        
        $projects=Project::all();
        if($projects->count()>0){
            return response()->json($projects,200);
        }
        return response()->json(['message'=>'No projects found'],404);
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
