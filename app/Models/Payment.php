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
        'transaction_reference'
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
}
