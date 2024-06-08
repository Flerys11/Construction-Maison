<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSousTravauxAPIRequest;
use App\Http\Requests\API\UpdateSousTravauxAPIRequest;
use App\Models\SousTravaux;
use App\Repositories\SousTravauxRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SousTravauxAPIController
 */
class SousTravauxAPIController extends AppBaseController
{
    private SousTravauxRepository $sousTravauxRepository;

    public function __construct(SousTravauxRepository $sousTravauxRepo)
    {
        $this->sousTravauxRepository = $sousTravauxRepo;
    }

    /**
     * Display a listing of the SousTravauxes.
     * GET|HEAD /sous-travauxes
     */
    public function index(Request $request): JsonResponse
    {
        $sousTravauxes = $this->sousTravauxRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sousTravauxes->toArray(), 'Sous Travauxes retrieved successfully');
    }

    /**
     * Store a newly created SousTravaux in storage.
     * POST /sous-travauxes
     */
    public function store(CreateSousTravauxAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $sousTravaux = $this->sousTravauxRepository->create($input);

        return $this->sendResponse($sousTravaux->toArray(), 'Sous Travaux saved successfully');
    }

    /**
     * Display the specified SousTravaux.
     * GET|HEAD /sous-travauxes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var SousTravaux $sousTravaux */
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            return $this->sendError('Sous Travaux not found');
        }

        return $this->sendResponse($sousTravaux->toArray(), 'Sous Travaux retrieved successfully');
    }

    /**
     * Update the specified SousTravaux in storage.
     * PUT/PATCH /sous-travauxes/{id}
     */
    public function update($id, UpdateSousTravauxAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var SousTravaux $sousTravaux */
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            return $this->sendError('Sous Travaux not found');
        }

        $sousTravaux = $this->sousTravauxRepository->update($input, $id);

        return $this->sendResponse($sousTravaux->toArray(), 'SousTravaux updated successfully');
    }

    /**
     * Remove the specified SousTravaux from storage.
     * DELETE /sous-travauxes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var SousTravaux $sousTravaux */
        $sousTravaux = $this->sousTravauxRepository->find($id);

        if (empty($sousTravaux)) {
            return $this->sendError('Sous Travaux not found');
        }

        $sousTravaux->delete();

        return $this->sendSuccess('Sous Travaux deleted successfully');
    }
}
