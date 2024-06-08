<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDevis extends Model
{
    use HasFactory;
    public $table = 'import_devis';
    public $timestamps = false;
    public $fillable = [
        'client',
        'ref_devis',
        'type_maison',
        'finition',
        'taux_finition',
        'date_devis',
        'date_debut',
        'lieu'
    ];
}
