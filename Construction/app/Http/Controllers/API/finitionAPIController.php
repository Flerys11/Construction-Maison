<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatefinitionAPIRequest;
use App\Http\Requests\API\UpdatefinitionAPIRequest;
use App\Models\finition;
use App\Repositories\finitionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class finitionAPIController
 */
class finitionAPIController extends AppBaseController
{
    private finitionRepository $finitionRepository;

    public function __construct(finitionRepository $finitionRepo)
    {
        $this->finitionRepository = $finitionRepo;
    }

    /**
     * Display a listing of the finitions.
     * GET|HEAD /finitions
     */
    public function index(Request $request): JsonResponse
    {
        $finitions = $this->finitionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($finitions->toArray(), 'Finitions retrieved successfully');
    }

    /**
     * Store a newly created finition in storage.
     * POST /finitions
     */
    public function store(CreatefinitionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $finition = $this->finitionRepository->create($input);

        return $this->sendResponse($finition->toArray(), 'Finition saved successfully');
    }

    /**
     * Display the specified finition.
     * GET|HEAD /finitions/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        return $this->sendResponse($finition->toArray(), 'Finition retrieved successfully');
    }

    /**
     * Update the specified finition in storage.
     * PUT/PATCH /finitions/{id}
     */
    public function update($id, UpdatefinitionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        $finition = $this->finitionRepository->update($input, $id);

        return $this->sendResponse($finition->toArray(), 'finition updated successfully');
    }

    /**
     * Remove the specified finition from storage.
     * DELETE /finitions/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var finition $finition */
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            return $this->sendError('Finition not found');
        }

        $finition->delete();

        return $this->sendSuccess('Finition deleted successfully');
    }
}
