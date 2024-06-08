<?php

namespace App\Http\Controllers;

use App\Models\DetailDevis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisControlle extends Controller
{
    //
    public function index(){

        $data = DetailDevis::all();
        foreach ($data as $item) {
            $item->total_prix = number_format($item->total_prix, 2, '.', '');
            $item->pourcentage_paiement = number_format($item->pourcentage_paiement, 2, '.', '');
        }
        // dd($data);
        return view('admin.listeD',['data'=>$data]);
    }

    public function supprime_base(){
        DB::select('CALL delete_all_table()');

        return redirect('List/Devis');
    }


}
