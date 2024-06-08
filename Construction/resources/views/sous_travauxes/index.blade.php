@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                    <form method="POST" action="{{route('import.mt')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <div class="form-group">
                                    <label for="file" class="sr-only">Sélectionnez un fichier :</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                </div>
                                <div class="form-group">
                                    <label for="fileé" class="sr-only">Sélectionnez un fichier :</label>
                                    <input type="file" class="form-control" id="file2" name="file2">
                                </div>
                                <br>
                                <div class="col-form">
                                    <button type="submit" class="btn btn-primary">Valider</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            <div class="col-sm-6 text-center">
                <h1>Liste Des Traveaux </h1>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            @include('sous_travauxes.table')
        </div>
    </div>

@endsection
