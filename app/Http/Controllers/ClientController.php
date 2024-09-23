<?php

namespace App\Http\Controllers;

use App\Mail\PaymentReminderMail;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    /*public function sendReminder($id)
    {
        $client = Client::findOrFail($id);
        $payment = Payment::findOrFail($id);
        $project = $payment->project; // Assurez-vous que la relation est définie

        // Vérifiez que le projet n'est pas payé
        if ($project && !$project->isPaid) {
            // Envoyer un email de relance au client
            Mail::to($payment->client->contact_email)->send(new PaymentReminderMail($payment));

            // Mettre à jour l'état de la relance (si nécessaire)
            $payment->update(['reminder_sent' => true]);

            return response()->json(['message' => 'Relance envoyée'], 200);
        }

        return response()->json(['message' => 'Aucune relance nécessaire'], 400);
    }*/

    public function index()
    {
        return Client::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255|unique:clients',
            'contact_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $client = Client::create($request->all());
        return response()->json($client, 201);
    }

    public function show($id)
    {
        return Client::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        Client::destroy($id);
        return response()->json(null, 204);
    }

}
