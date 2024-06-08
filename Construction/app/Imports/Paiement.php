<?php

namespace App\Imports;


use App\Http\Controllers\ImportController;
use App\Models\ImportPaiement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Paiement implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ImportPaiement([
            'ref_devis' => $row['ref_devis'],
            'ref_paiement' => $row['ref_paiement'],
            'date_paiement' => $row['date_paiement'],
            'montant' => str_replace(',', '.', $row['montant']),

        ]);
    }
}
