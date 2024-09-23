<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project; // Rendre le paiement accessible dans la vue

    /**
     * Créer une nouvelle instance de l'email.
     *
     * @param Project $project
     */
    public function __construct($project, $totalAmountDue)
    {
        $this->project = $project;
        $this->totalAmountDue = $totalAmountDue; // Stocker le montant dû
    }

    /**
     * Créer le message de l'email.
     *
     * @return $this
     */
    // PaymentReminderMail.php
    public function build()
    {
        return $this->from('dieyesokhna2021@gmail.com', 'Sokhna')
            ->to($this->project->client->contact_email)
            ->view('payment_reminder')
            ->subject('Relance de paiement')
            ->with([
                'project' => $this->project,
                'client' => $this->project->client ,
                'totalAmountDue' => $this->totalAmountDue
            ]);
    }


}
