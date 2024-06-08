<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportMaisoTravaux extends Model
{
    use HasFactory;
    public $table = 'import_maison_travaux';
    public $timestamps = false;
    protected $fillable = [
        'type_maison',
        'description',
        'surface',
        'code_travaux',
        'type_travaux',
        'unite',
        'prix_unitaire',
        'quantite',
        'duree_travaux'
    ];
}
