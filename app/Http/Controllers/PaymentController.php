<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
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

        // Générer le PDF de la facture
        $pdf = PDF::loadView('invoice', ['payment' => $payment, 'client' => $payment->client, 'project' => $payment->project]);

        // Envoyer l'email avec la facture en pièce jointe
        Mail::send([], [], function ($message) use ($payment, $pdf) {
            $message->to($payment->client->email)
                ->subject('Votre Facture')
                ->attachData($pdf->output(), 'facture.pdf', ['mime' => 'application/pdf']);
        });

        return response()->json(['message' => 'Facture envoyée avec succès'], 200);
    }

    // Créer un nouveau paiement
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

        $payment = Payment::create($validatedData);
        // Envoyer l'email de facture
        $this->sendInvoiceEmail($payment->id);

        return response()->json($payment, 201);
    }

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
