<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devisencours extends Model
{
    use HasFactory;
    public $table = 'devisencours';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'iddevis',
        'idclient',
        'idfinition',
        'datedevis'
    ];


}
