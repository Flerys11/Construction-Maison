<?php

namespace App\Http\Controllers;

use App\Imports\Devis;
use App\Imports\MaisonTravaux;
use App\Imports\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //
    public function importMT(Request $request){
        if($request->hasFile('file') && $request->hasFile('file2')) {
            $file = $request->file("file");
            $file2 = $request->file("file2");
            $nomFichier = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
            $nomFichier2 = Carbon::now()->format('Ymd_His') .'_'. $file2->getClientOriginalName();
            $file->move(public_path('upload'), $nomFichier);
            $file2->move(public_path('upload'), $nomFichier2);
            Excel::import(new MaisonTravaux(), 'upload/'. $nomFichier);
            Excel::import(new Devis(), 'upload/'. $nomFichier2);
            DB::select('CALL somme_import()');
//            $data = Excel::toArray([], 'upload/'. $nomFichier2);
//
//            foreach($data as $row){
//                dd($row);
//            }

            return redirect(route('tableau'));
        }
    }


    public function importP(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file("file");
            $nomFichier = Carbon::now()->format('Ymd_His') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $nomFichier);
            //Excel::import(new Paiement(), 'upload/'. $nomFichier);
            //DB::select('select insert_paiement()');
            $data = Excel::toArray(new Paiement(), 'upload/'. $nomFichier);
            $paiement = DB::select('select * from paiement');
            $nonMatchingRefs = [];
            $ref_paiements = array_map(function($item) {
                return $item->ref_paiement;
            }, $paiement);
//            foreach ($data as $row) { // assuming $data contains multiple sheets
//                for ($i = 0 ; $i < count($row); $i++) {
//                    $imported_ref_paiement = $row[$i]['ref_paiement'];
//                    if (in_array($imported_ref_paiement, $ref_paiements)) {
//                        $matchingRefs[] = $imported_ref_paiement;
//                    } else {
//                        $nonMatchingRefs[] = $imported_ref_paiement;
//                    }
//                }
//            }
            
            foreach ($data as $sheet) {
                for ($i = 0; $i < count($sheet); $i++) {
                    if (isset($sheet[$i]['ref_paiement'])) {
                        $imported_ref_paiement = $sheet[$i]['ref_paiement'];

                        if (in_array($imported_ref_paiement, $ref_paiements)) {
                            $nonMatchingRefs[] = array_merge($sheet[$i], ['line' => $i + 1]);

                        } else {
                            \App\Models\Paiement::create([
                                'iddevisencours' => 60,
                                'montant' => $sheet[$i]['montant'],
                                'ref_paiement' => $sheet[$i]['ref_paiement'],
                                'date' => $sheet[$i]['date_paiement']
                            ]);
                        }
                    }
                }
            }


        }

        return redirect()->route('liste.travaux')->with('nonMatchingRefs', $nonMatchingRefs);
    }
}
