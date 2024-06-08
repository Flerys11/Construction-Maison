<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePosteRequest;
use App\Http\Requests\UpdatePosteRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Poste;
use App\Repositories\PosteRepository;
use Illuminate\Http\Request;
use Flash;

class PosteController extends AppBaseController
{
    /** @var PosteRepository $posteRepository*/
    private $posteRepository;

    public function __construct(PosteRepository $posteRepo)
    {
        $this->posteRepository = $posteRepo;
    }

    /**
     * Display a listing of the Poste.
     */
    public function index(Request $request)
    {
        $postes = $this->posteRepository->paginate(10);

        return view('postes.index')
            ->with('postes', $postes);
    }

    /**
     * Show the form for creating a new Poste.
     */
    public function create()
    {
        return view('postes.create');
    }

    /**
     * Store a newly created Poste in storage.
     */
    public function store(CreatePosteRequest $request)
    {
        $input = $request->all();
        $input['id'] = Poste::getId();
        //dd($input);

        $poste = $this->posteRepository->create($input);

        Flash::success('Poste saved successfully.');

        return redirect(route('postes.index'));
    }

    /**
     * Display the specified Poste.
     */
    public function show($id)
    {
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            Flash::error('Poste not found');

            return redirect(route('postes.index'));
        }

        return view('postes.show')->with('poste', $poste);
    }

    /**
     * Show the form for editing the specified Poste.
     */
    public function edit($id)
    {
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            Flash::error('Poste not found');

            return redirect(route('postes.index'));
        }

        return view('postes.edit')->with('poste', $poste);
    }

    /**
     * Update the specified Poste in storage.
     */
    public function update($id, UpdatePosteRequest $request)
    {
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            Flash::error('Poste not found');

            return redirect(route('postes.index'));
        }

        $poste = $this->posteRepository->update($request->all(), $id);

        Flash::success('Poste updated successfully.');

        return redirect(route('postes.index'));
    }

    /**
     * Remove the specified Poste from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $poste = $this->posteRepository->find($id);

        if (empty($poste)) {
            Flash::error('Poste not found');

            return redirect(route('postes.index'));
        }

        $this->posteRepository->delete($id);

        Flash::success('Poste deleted successfully.');

        return redirect(route('postes.index'));
    }
}
