<?php

namespace App\Repositories;

use App\Models\SousTravaux;
use App\Repositories\BaseRepository;

class SousTravauxRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'nom',
        'quantite',
        'prix'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SousTravaux::class;
    }
}
