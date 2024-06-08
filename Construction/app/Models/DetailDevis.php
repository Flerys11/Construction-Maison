<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDevis extends Model
{
    use HasFactory;
    public $table = 'encour_final';
    public $timestamps = false;
    public $fillable = [
        'id',
        'iddevis',
        'idclient',
        'datedevis',
        'total_paiement',
        'pourcentage_paiement',
        'total_prix',
        'finition',
        'maison'
    ];
}
