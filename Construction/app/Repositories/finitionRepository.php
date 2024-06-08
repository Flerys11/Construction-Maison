<?php

namespace App\Repositories;

use App\Models\finition;
use App\Repositories\BaseRepository;

class finitionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nom',
        'pourcentage'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return finition::class;
    }
}
