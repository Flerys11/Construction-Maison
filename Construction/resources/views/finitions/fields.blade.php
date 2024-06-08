<!-- Nom Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nom', 'Nom:') !!}
    {!! Form::text('nom', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Pourcentage Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pourcentage', 'Pourcentage:') !!}
    {!! Form::number('pourcentage', null, ['class' => 'form-control', 'required']) !!}
</div>