<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $table = 'client';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'contact'
    ];
}
