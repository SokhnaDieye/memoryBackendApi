<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'amount_received',
        'payment_date',
        'payment_type',
        'transaction_reference',
        'total_amount_due',
        'due_date',
        'payment_status',
        'reminder_sent'

    ];

    // Relation avec le projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Vérifier si le paiement est en retard
    public function isLate()
    {
        return $this->payment_status === 'En retard' && $this->payment_date === null;
    }

    // Méthode pour envoyer un rappel
    public function sendReminder()
    {
        // Logique pour envoyer un email de relance
        // Par exemple, Mail::to($this->client->email)->send(new PaymentReminder($this));
        $this->reminder_sent = true;
        $this->save();
    }
}
