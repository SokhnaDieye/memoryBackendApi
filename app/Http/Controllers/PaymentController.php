<?php

namespace App\Http\Controllers;

use App\Mail\FactureMail;
use App\Mail\PaymentReminderMail;
use App\Models\Payment;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Exemple de contrôleur
    public function showInvoice($paymentId)
    {
        // Récupérer les informations de paiement avec les relations
        $payment = Payment::with('client', 'project')->findOrFail($paymentId);

        // Passer les données à la vue
        return view('invoice', [
            'payment' => $payment,
            'client' => $payment->client,
            'project' => $payment->project
        ]);
    }


    // Récupérer tous les paiements
    public function index()
    {
        $payments = Payment::with('project', 'client')->get();  // Inclure les relations
        return response()->json($payments);
    }

    // Récupérer un paiement spécifique
    public function show($id)
    {
        $payment = Payment::with('project', 'client')->findOrFail($id);
        return response()->json($payment);
    }

    //Email
    public function sendInvoiceEmail($paymentId)
    {
        $payment = Payment::with('client', 'project')->findOrFail($paymentId);

        // Vérifiez que l'email du client est bien défini
        if (!$payment->client->contact_email) {
            return response()->json(['message' => 'L\'email du client est manquant'], 500);
        }

        // Générer le PDF de la facture
        try {
            $pdf = PDF::loadView('invoice', [
                'payment' => $payment,
                'client' => $payment->client,
                'project' => $payment->project
            ]);

            // Utiliser la classe FactureMail pour envoyer l'email avec pièce jointe
            Mail::to($payment->client->contact_email)->send(new FactureMail($pdf, $payment));
            return response()->json(['message' => 'Facture envoyée avec succès'], 200);
        } catch (\Exception $e) {
            // Capture l'erreur et retourne une réponse
            return response()->json(['message' => 'Échec de l\'envoi de la facture : ' . $e->getMessage()], 500);
        }

    }


    // Méthode de création d'un paiement
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'amount_received' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string|max:255',
            'transaction_reference' => 'required|string|max:255',
        ]);

        // Créer le paiement
        $payment = Payment::create($validatedData);

        // Mettre à jour l'état du projet comme payé
        $project = Project::findOrFail($validatedData['project_id']);
        $project->update(['isPaid' => true]);

        // Envoyer l'email de facture après la création du paiement
        $this->sendInvoiceEmail($payment->id);

        return response()->json($payment, 201);
    }


   /* public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'client_id' => 'required|exists:clients,id',
            'amount_received' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string|max:255',
            'transaction_reference' => 'required|string|max:255',
        ]);

        $payment = Payment::create($validatedData);

        // Envoyer l'email de facture après la création du paiement
        $this->sendInvoiceEmail($payment->id);

        return response()->json($payment, 201);
    }*/

    // Mettre à jour un paiement existant
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validatedData = $request->validate([
            'amount_received' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string|max:255',
            'transaction_reference' => 'required|string|max:255',
        ]);

        $payment->update($validatedData);
        return response()->json($payment);
    }

    // Supprimer un paiement
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return response()->json(null, 204);
    }
}
