<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use Illuminate\Support\Facades\Auth;


class TimesheetController extends Controller
{
     
     public function index()
     {
         $timesheets = Timesheet::all();
         
         return response()->json($timesheets, 200);
     }
 
     // Store a new timesheet record
     public function store(Request $request)
     {
         $validated = $request->validate([
             'task_name' => 'required|string|max:255',
             'date' => 'required|date',
             'hours' => 'required|numeric|min:0.5|max:24',
             'project_id' => 'required|exists:projects,id',
         ]);
 
         $timesheet = Timesheet::create(array_merge($validated, ['user_id' => Auth::id()]));
         
         return response()->json($timesheet, 201);
     }
 
     // Show a specific timesheet
     public function show(Timesheet $timesheet)
     {
         $this->authorize('view', $timesheet);
         return response()->json($timesheet);
     }
 
     // Update a timesheet record
     public function update(Request $request, Timesheet $timesheet)
     {
         $this->authorize('update', $timesheet);
     
         $validated = $request->validate([
             'task_name' => 'sometimes|string|max:255',
             'date' => 'sometimes|date',
             'hours' => 'sometimes|numeric|min:0.5|max:24',
             'project_id' => 'sometimes|exists:projects,id',
         ]);
     
         $timesheet->update($validated);
     
         return response()->json([
             'message' => 'Timesheet updated successfully!',
             'timesheet' => $timesheet,
         ], 200);
     }
 
     // Delete a timesheet
     public function destroy(Timesheet $timesheet)
     {
         $timesheet->delete();
         return response()->json(['message' => 'Timesheet deleted successfully']);
     }
}
