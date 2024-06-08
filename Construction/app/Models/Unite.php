<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    use HasFactory;

    public $table = 'unite';
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nom'
    ];

    public function sousTravaux()
    {
        return $this->hasMany(SousTravaux::class, 'id_unite');
    }
}
