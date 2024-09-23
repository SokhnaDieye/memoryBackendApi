<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'payments:send-reminders';

    protected $description = 'Envoyer des relances de paiement pour les factures en retard';

    public function handle()
    {
        // Récupérer les paiements en retard dont la relance n'a pas encore été envoyée
        $latePayments = Payment::where('payment_status', 'En attente')
            ->where('due_date', '<', Carbon::now())
            ->where('reminder_sent', false)
            ->get();

        foreach ($latePayments as $payment) {
            // Envoyer la relance (logique d'email à intégrer ici)
            $payment->sendReminder();
            $this->info("Relance envoyée pour le paiement ID : {$payment->id}");
        }

        $this->info('Toutes les relances ont été envoyées.');
    }
}
