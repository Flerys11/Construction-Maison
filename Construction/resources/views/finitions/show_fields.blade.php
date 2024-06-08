<!-- Nom Field -->
<div class="col-sm-12">
    {!! Form::label('nom', 'Nom:') !!}
    <p>{{ $finition->nom }}</p>
</div>

<!-- Pourcentage Field -->
<div class="col-sm-12">
    {!! Form::label('pourcentage', 'Pourcentage:') !!}
    <p>{{ $finition->pourcentage }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $finition->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $finition->updated_at }}</p>
</div>

