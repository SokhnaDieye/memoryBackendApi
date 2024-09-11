<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index()
    {
        return Milestone::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|integer|exists:projects,id',
            'date_echeance' => 'required|date',
            'status' => 'required|string',
        ]);

        $milestone = Milestone::create($request->all());
        return response()->json($milestone, 201);
    }

    public function show($id)
    {
        return Milestone::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $milestone = Milestone::findOrFail($id);
        $milestone->update($request->all());
        return response()->json($milestone, 200);
    }

    public function destroy($id)
    {
        Milestone::destroy($id);
        return response()->json(null, 204);
    }
}
