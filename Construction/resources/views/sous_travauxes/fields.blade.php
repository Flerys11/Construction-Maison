<!-- Code Field -->

<div class="form-group col-sm-6">
    {!! Form::label('travaux', 'Type Travaux:') !!}
    {!! Form::select('finition', $type_travaux->pluck('code', 'id')->toArray(), null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Nom Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control']) !!}
</div>

<!-- Quantite Field -->
<div class="form-group col-sm-6">
    {!! Form::label('quantite', 'Quantite:') !!}
    {!! Form::text('quantite', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Prix Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prix', 'Prix:') !!}
    {!! Form::text('prix', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('unite', 'Unite') !!}
    {!! Form::select('finition', $unite->pluck('nom', 'id')->toArray(), null, ['class' => 'form-control', 'required']) !!}
</div>
