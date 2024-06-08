<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatefinitionRequest;
use App\Http\Requests\UpdatefinitionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\finitionRepository;
use Illuminate\Http\Request;
use Flash;

class finitionController extends AppBaseController
{
    /** @var finitionRepository $finitionRepository*/
    private $finitionRepository;

    public function __construct(finitionRepository $finitionRepo)
    {
        $this->finitionRepository = $finitionRepo;
    }

    /**
     * Display a listing of the finition.
     */
    public function index(Request $request)
    {
        $finitions = $this->finitionRepository->paginate(10);

        return view('finitions.index')
            ->with('finitions', $finitions);
    }

    /**
     * Show the form for creating a new finition.
     */
    public function create()
    {
        return view('finitions.create');
    }

    /**
     * Store a newly created finition in storage.
     */
    public function store(CreatefinitionRequest $request)
    {
        $input = $request->all();

        $finition = $this->finitionRepository->create($input);

        Flash::success('Finition saved successfully.');

        return redirect(route('finitions.index'));
    }

    /**
     * Display the specified finition.
     */
    public function show($id)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        return view('finitions.show')->with('finition', $finition);
    }

    /**
     * Show the form for editing the specified finition.
     */
    public function edit($id)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        return view('finitions.edit')->with('finition', $finition);
    }

    /**
     * Update the specified finition in storage.
     */
    public function update($id, UpdatefinitionRequest $request)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        $finition = $this->finitionRepository->update($request->all(), $id);

        Flash::success('Finition updated successfully.');

        return redirect(route('finitions.index'));
    }

    /**
     * Remove the specified finition from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $finition = $this->finitionRepository->find($id);

        if (empty($finition)) {
            Flash::error('Finition not found');

            return redirect(route('finitions.index'));
        }

        $this->finitionRepository->delete($id);

        Flash::success('Finition deleted successfully.');

        return redirect(route('finitions.index'));
    }
}
