<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class finition extends Model
{
    public $table = 'finition';
    public $timestamps = false;
    public $fillable = [
        'nom',
        'pourcentage'
    ];

    protected $casts = [
        'nom' => 'string',
        'pourcentage' => 'float'
    ];

    public static array $rules = [
        'nom' => 'required',
        'pourcentage' => 'required'
    ];


}
