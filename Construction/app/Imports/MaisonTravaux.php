<?php

namespace App\Imports;


use App\Http\Controllers\ImportController;
use App\Models\ImportMaisoTravaux;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaisonTravaux implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ImportMaisoTravaux([
            'type_maison' => $row['type_maison'],
            'description' => $row['description'],
            'surface' => str_replace(',', '.',$row['surface']),
            'code_travaux' => $row['code_travaux'],
            'type_travaux' => $row['type_travaux'],
            'unite' => $row['unite'],
            'prix_unitaire' => str_replace(',', '.', $row['prix_unitaire']),
            'quantite' => str_replace(',', '.',$row['quantite']),
            'duree_travaux' => $row['duree_travaux'],
        ]);
    }
}
