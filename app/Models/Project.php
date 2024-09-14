<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'client_id',
        'start_date',
        'end_date',
        'status',
        'budget_initial',
        'budget_real',
        'montant_facture',
        'isPaid'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}
