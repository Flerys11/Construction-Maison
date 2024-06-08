<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    public $table = 'paiement';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'iddevisencours',
        'montant',
        'ref_paiement',
        'date'
    ];
}
