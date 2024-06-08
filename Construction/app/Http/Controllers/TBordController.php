<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TBordController extends Controller
{
    //
    public function index(){
        $stat_annee = DB::select('select * from stat_annee');

        foreach ($stat_annee as $item) {
            $item->total_prix = number_format($item->total_prix, 2, '.', '');
        }

        foreach ($stat_annee as $item) {
            $item->year_month = date('Y', strtotime($item->year_month));
        }

        $date = $stat_annee[0]->year_month;
        if($date == null){
            $date = 2024;
        }

        $total_paiement = DB::select('select * from paiemenet_somme');
        $total_devis  = DB::select('select * from somme_encours');

        //dd($total_paiement);
        $stat_mois = DB::select('SELECT * FROM stat_mois WHERE EXTRACT(YEAR FROM month) =?', [$date]);
        //dd($stat_mois);

        return view('admin.tableaubord')->with(['stat_mois' => $stat_mois, 'stat_annee' => $stat_annee, 'total_paiement' => $total_paiement,
            'total_devis' => $total_devis]);
    }

    public function getDateChart(Request $request)
    {
        $stat_annee = DB::select('select * from stat_annee');


        foreach ($stat_annee as $item) {
            $item->total_prix = number_format($item->total_prix, 2, '.', '');
        }

        foreach ($stat_annee as $item) {
            $item->year_month = date('Y', strtotime($item->year_month));
        }

        $date = $request->get('annee');
        //dd($date);
        $stat_mois = DB::select('SELECT * FROM stat_mois WHERE EXTRACT(YEAR FROM month) =?', [$date]);
        $total_paiement = DB::select('select * from paiemenet_somme');

        $total_devis  = DB::select('select * from somme_encours');
        return view('admin.tableaubord')->with(['stat_mois' => $stat_mois, 'stat_annee' => $stat_annee, 'total_paiement' => $total_paiement,
            'total_devis' => $total_devis]);
    }

}
