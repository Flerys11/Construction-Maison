<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Poste extends Model
{
    public $table = 'poste';
    public $timestamps = false;
    public $primaryKey = 'id';

    public $keyType = 'string';

    public $fillable = [
        'id',
        'nom'
    ];

    protected $casts = [
        'nom' => 'string'
    ];

    public static array $rules = [
        'nom' => 'required'
    ];


    public static function getId()
    {
        return DB::select("select poste_id()")[0]->poste_id;
    }


}
