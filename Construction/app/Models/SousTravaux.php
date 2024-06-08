<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousTravaux extends Model
{
    public $table = 'soustravaux';
    public $timestamps = false;
    public $fillable = [
        'id',
        'idtypetravaux',
        'code',
        'nom',
        'id_unite',
        'quantite',
        'prix'

    ];

    public static array $rules = [
        'code' => 'required',
        'nom' => 'required',
        'quantite' => 'required',
        'prix' => 'required'
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class, 'id_unite');
    }

    public function typetravaux()
    {
        return $this->belongsTo(TypeTravaux::class, 'idtypetravaux');
    }

    public function detail()
    {
        return $this->hasMany(DetailDevisMaison::class, 'idst');

    }
}
