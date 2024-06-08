<?php

namespace App\Http\Controllers;

use App\Models\DetailDevisMaison;
use App\Models\Devisencours;
use App\Models\Finition;
use App\Models\Paiement;
use App\Models\SousTravaux;
use App\Models\TypeTravaux;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;

class DevisClientController extends Controller
{
    public function index(){
        $data = DB::select('select * from get_dd_maison');
        //dd($data);
        return view('client.devis')->with('data', $data);
    }

    public function getListTravaux()
    {
        $id = session('id_client');
        $data = DB::select('select * from get_list_Devis_Client where idclient = ?', [$id]);
        //dd($data);
        return view('client.travaux')->with('data', $data);
    }

    public function expordPDF($id)
    {
        //dd(TypeTravaux::all()->skip(1)->first()->id);

//        $preparatoirTypeId = TypeTravaux::all()->first()->id;
//        $terrassementTypeId = TypeTravaux::all()->skip(1)->first()->id;
//        $infraTypeId = TypeTravaux::all()->skip(2)->first()->id;
//
//        $preparatoir = DB::select('SELECT * FROM somme_detail WHERE idtypetravaux = ? AND iddevismaison = ?', [$preparatoirTypeId, $id]);
//        $terrassement = DB::select('SELECT * FROM somme_detail WHERE idtypetravaux = ? AND iddevismaison = ?', [$terrassementTypeId, $id]);
//        $infra = DB::select('SELECT * FROM somme_detail WHERE idtypetravaux = ? AND iddevismaison = ?', [$infraTypeId, $id]);
//
//        $this->loadPDF($preparatoir,$terrassement,$infra);
        $pouce = DB::select('select * from devisEnCours where id = ?', [$id]);
        $id_d = $pouce[0]->iddevis;
        $devis = DetailDevisMaison::where ('iddevismaison', $id_d)->get();

       //dd($devis);
//        dd($devis[0]->sous->unite->nom);
        //$this->loadPDF($devis);

       //return view('client.pdf')->with(['devis' => $devis, 'pource' =>$pouce]);
        $this->loadPDF($devis,$pouce);

    }

    public function DetailEnCours($id)
    {
        $pouce = DB::select('select * from devisEnCours where id = ?', [$id]);
        $id_d = $pouce[0]->iddevis;
        $devis = DetailDevisMaison::where ('iddevismaison', $id_d)->get();
        return view('admin.detail')->with(['devis' => $devis,'pource' =>$pouce]);
    }

    private function loadPDF($devis,$pouce)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('client.pdf', ['devis' =>$devis,'pource' =>$pouce]));
        $dompdf->setPaper('a4', 'portrait');
        $dompdf->render();
        $daty = Carbon::now('Indian/Antananarivo')->format('Y-m-d H:i:s');
        return $dompdf->stream($daty.'devis.pdf');
    }

    public function creationDevis($id)
    {
        $finitions = Finition::all();

//        $finitions = array(
//            'id' => $nomsFinition = Finition::pluck('id'),
//            'nom' => $nomsFinition = Finition::pluck('nom'),
//        );
        //dd($finitions);
        return view('client.creation')->with(['finition' => $finitions, 'id' => $id]);
    }

    public function insertDevis(Request $request)
    {
        $date = request()->input('date');
        $id = request()->input('id');
        $finition = request()->input('finition');

        Devisencours::create([
            'iddevis' => $id,
            'idclient' => session('id_client'),
            'idfinition' => $finition,
            'datedevis' => $date
        ]);

        return redirect()->route('liste.travaux');


    }

    public function getPaiement($id)
    {
        //dd($id);
        return view('client.paiement')->with('id', $id);
    }

    public function insertPaiemenet(Request $request)
    {
        $achat_id = $request->input('achat_id');
        $montant = $request->input('montant');
        $reference = $request->input('reference');
        $date = $request->input('date');

        if (!empty($achat_id) && !empty($montant) && !empty($reference) && !empty($date)) {
            $id_client = session('id_client');
            $montant_total = DB::select('select * from paiement_effectue_et_pourcentage where id_encours = ?', [$achat_id]);
            if (!empty($montant_total)) {
                $total_p = floatval($montant_total[0]->total_paiement) + $montant;
                $prix = floatval($montant_total[0]->total_prix);
                if ($total_p < $prix) {
                    Paiement::create([
                        'iddevisencours' => $achat_id,
                        'montant' => $montant,
                        'ref_paiement' => $reference,
                        'date'=> $date
                    ]);
                    return response()->json(['message' => "Insertion effectuée"]);
                } else {
                    return response()->json(['error' => 'Montant dépasse le reste à payer']);
                }
            } else {
                return response()->json(['error' => 'Données non trouvées pour le ID d\'achat spécifié']);
            }
        } else {
            return response()->json(['error' => 'Des données requises sont manquantes ou vides']);
        }


    }
    //

}
