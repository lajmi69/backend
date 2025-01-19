<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    // Définir les champs pouvant être assignés en masse
    protected $fillable = [
        'type',
        'prix_billet',
        'date_depart',
        'date_arrivee',
        'compagnie',
        'places_disponibles',
        
    ];
}

