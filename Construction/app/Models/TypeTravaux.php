<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTravaux extends Model
{
    use HasFactory;

    public $table = 'typetravaux';
    public $fillable = [
        'id',
        'code',
        'nom'
    ];

    public function gettype()
    {
        return $this->hasMany(SousTravaux::class, 'idtypetravaux');
    }

}
