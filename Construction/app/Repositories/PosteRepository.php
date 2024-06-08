<?php

namespace App\Repositories;

use App\Models\Poste;
use App\Repositories\BaseRepository;

class PosteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Poste::class;
    }
}
