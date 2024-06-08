@extends('base')
@section('content')

    <div class="content px-3">
        <div>
            <a href="{{ route('supp.base') }}">
                <button class="btn btn-secondary">DELETE ALL</button>
            </a>
        </div>
        <h2 class="text-center">Liste Des devis en Cours</h2>
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    @include('admin.tables')
                </div>
            </div>
        </div>
    </div>


@endsection
