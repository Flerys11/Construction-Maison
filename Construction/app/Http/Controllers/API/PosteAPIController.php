<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePosteAPIRequest;
use App\Http\Requests\API\UpdatePosteAPIRequest;
use App\Models\Poste;
use App\Repositories\PosteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PosteAPIController
 */
class PosteAPIController extends AppBaseController
{
    private PosteRepository $posteRepository;

    public function __construct(PosteRepository $posteRepo)
    {
        $this->posteRepository = $posteRepo;
    }

    /**
     * Display a listing of the Postes.
     * GET|HEAD /postes
     */
    public function index(Request $request): JsonResponse
    {
        $postes = $this->posteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($postes->toArray(), 'Postes retrieved successfully');
    }

    /**
     * Store a newly created Poste in storage.
     * POST /postes
     */
    public function store(CreatePosteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $poste = $this->posteRepository->create($input);

        return $this->sendResponse($poste->toArray(), 'Poste saved successfully');
    }

    /**
     * Display the specified Poste.
     * GET|HEAD /postes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Poste $poste */
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            return $this->sendError('Poste not found');
        }

        return $this->sendResponse($poste->toArray(), 'Poste retrieved successfully');
    }

    /**
     * Update the specified Poste in storage.
     * PUT/PATCH /postes/{id}
     */
    public function update($id, UpdatePosteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Poste $poste */
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            return $this->sendError('Poste not found');
        }

        $poste = $this->posteRepository->update($input, $id);

        return $this->sendResponse($poste->toArray(), 'Poste updated successfully');
    }

    /**
     * Remove the specified Poste from storage.
     * DELETE /postes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Poste $poste */
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            return $this->sendError('Poste not found');
        }

        $poste->delete();

        return $this->sendSuccess('Poste deleted successfully');
    }
}
