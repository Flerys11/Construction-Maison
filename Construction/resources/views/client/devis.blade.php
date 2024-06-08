@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="text-center">
                    <h1>Listes Maison</h1>
                </div>

            </div>
        </div>
    </section>

    <div class="container">

        <div class="clearfix"></div>
        <div class="row">
                @include('client.listeTout')

        </div>
    </div>

@endsection
