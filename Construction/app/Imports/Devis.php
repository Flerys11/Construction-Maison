<?php

namespace App\Imports;


use App\Http\Controllers\ImportController;
use App\Models\ImportDevis;
use App\Models\ImportMaisoTravaux;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Devis implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ImportDevis([
            'client' => $row['client'],
            'ref_devis' => $row['ref_devis'],
            'type_maison' => $row['type_maison'],
            'finition' => $row['finition'],
            'taux_finition' => str_replace(',', '.', str_replace('%', '', $row['taux_finition'])),
            'date_devis' => $row['date_devis'],
            'date_debut' => $row['date_debut'],
            'lieu' => $row['lieu'],
        ]);
    }
}
