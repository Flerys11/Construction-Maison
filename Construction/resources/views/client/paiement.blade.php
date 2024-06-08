
@extends('base')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
                        Creation Devis
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'insert.paiement']) !!}

            <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-6">
                        {!! Form::label('montant', 'Montant:') !!}
                        {!! Form::number('montant', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('date', 'Date:') !!}
                        {!! Form::datetimeLocal('date', null, ['class' => 'form-control']) !!}
                    </div>
                    <input type="hidden" name="id" id="" value="{{ $id }}">
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('home.client') }}" class="btn btn-default"> Cancel </a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
