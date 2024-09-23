<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReminderMail;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|integer|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|string',
            'budget_initial' => 'required|numeric',
        ]);

        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    public function show($id)
    {
        return Project::with('milestones')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        Project::destroy($id);
        return response()->json(null, 204);
    }
    public function getProjectById($id) {
        $project = Project::with('milestones')->find($id);

        if (!$project) {
            return response()->json(['message' => 'Projet non trouvé'], 404);
        }

        return response()->json([
            'project' => $project,
            'milestones' => $project->milestones ?? []
           /* 'milestones' => $project->milestones*/
        ]);
    }


    public function sendReminder($projectId)
    {
        $project = Project::find($projectId);

        if (!$project || $project->isPaid || $project->end_date > now()) {
            return response()->json(['message' => 'Le projet n\'est pas éligible pour la relance.'], 400);
        }
        // Convertir end_date en Carbon
        $project->end_date = Carbon::parse($project->end_date);

        // Calculer le montant dû en sommant les montants des milestones
        $totalAmountDue = $project->milestones->sum('montant_facture'); // Assurez-vous que 'amount' est le nom correct du champ

        // Envoyer l'email
        Mail::to($project->client->email)->send(new PaymentReminderMail($project, $totalAmountDue));

        return response()->json(['message' => 'Email de relance envoyé avec succès.']);
    }


}
