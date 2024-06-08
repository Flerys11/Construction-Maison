<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSousTravauxRequest;
use App\Http\Requests\UpdateSousTravauxRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\SousTravaux;
use App\Models\TypeTravaux;
use App\Models\Unite;
use App\Repositories\SousTravauxRepository;
use Illuminate\Http\Request;
use Flash;

class SousTravauxController extends AppBaseController
{
    /** @var SousTravauxRepository $sousTravauxRepository*/
    private $sousTravauxRepository;

    public function __construct(SousTravauxRepository $sousTravauxRepo)
    {
        $this->sousTravauxRepository = $sousTravauxRepo;
    }

    /**
     * Display a listing of the SousTravaux.
     */
    public function index(Request $request)
    {
        $sousTravauxes = SousTravaux::all();
        //dd($sousTravauxes[0]->unite->nom);

        return view('sous_travauxes.index')
            ->with('sousTravauxes', $sousTravauxes);
    }

    public function create()
    {
        return view('sous_travauxes.create');
    }

    /**
     * Store a newly created SousTravaux in storage.
     */
    public function store(CreateSousTravauxRequest $request)
    {
        $input = $request->all();

        $sousTravaux = $this->sousTravauxRepository->create($input);

        Flash::success('Sous Travaux saved successfully.');

        return redirect(route('sous-travauxes.index'));
    }

    /**
     * Display the specified SousTravaux.
     */
    public function show($id)
    {
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            Flash::error('Sous Travaux not found');

            return redirect(route('sousTravauxes.index'));
        }

        return view('sous_travauxes.show')->with('sousTravaux', $sousTravaux);
    }

    /**
     * Show the form for editing the specified SousTravaux.
     */
    public function edit($id)
    {
        $sousTravaux = $this->sousTravauxRepository->find($id);
        $unite = Unite::all();
        $type_travaux = TypeTravaux::all();

        if (empty($sousTravaux)) {
            Flash::error('Sous Travaux not found');

            return redirect(route('sous-travauxes.index'));
        }
    //dd($unite);
        return view('sous_travauxes.edit')->with(['sousTravaux'=> $sousTravaux, 'unite'=> $unite, 'type_travaux' =>$type_travaux]);
    }

    /**
     * Update the specified SousTravaux in storage.
     */
    public function update($id, UpdateSousTravauxRequest $request)
    {
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            Flash::error('Sous Travaux not found');

            return redirect(route('sous-travauxes.index'));
        }

        $sousTravaux = $this->sousTravauxRepository->update($request->all(), $id);

        Flash::success('Sous Travaux updated successfully.');

        return redirect(route('sous-travauxes.index'));
    }

    /**
     * Remove the specified SousTravaux from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            Flash::error('Sous Travaux not found');

            return redirect(route('sous-travauxes.index'));
        }

        $this->sousTravauxRepository->delete($id);

        Flash::success('Sous Travaux deleted successfully.');

        return redirect(route('sous-travauxes.index'));
    }
}
