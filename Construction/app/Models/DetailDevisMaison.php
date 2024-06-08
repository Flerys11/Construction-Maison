<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDevisMaison extends Model
{
    use HasFactory;
    public $table = 'detaildevis';
    public $timestamps = false;
    protected $fillable = [
        'iddevismaison',
        'idst',
        'quantite',
        'prix_unitaire'
    ];

    public function sous()
    {
        return $this->belongsTo(SousTravaux::class, 'idst');
    }
}
