<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportPaiement extends Model
{
    use HasFactory;

    public $table = 'import_paiement';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'ref_devis',
        'ref_paiement',
        'date_paiement',
        'montant'
    ];
}
