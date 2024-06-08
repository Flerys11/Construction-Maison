<!-- Code Field -->
<div class="col-sm-12">
    {!! Form::label('code', 'Code:') !!}
    <p>{{ $sousTravaux->code }}</p>
</div>

<!-- Nom Field -->
<div class="col-sm-12">
    {!! Form::label('nom', 'Nom:') !!}
    <p>{{ $sousTravaux->nom }}</p>
</div>

<!-- Quantite Field -->
<div class="col-sm-12">
    {!! Form::label('quantite', 'Quantite:') !!}
    <p>{{ $sousTravaux->quantite }}</p>
</div>

<!-- Prix Field -->
<div class="col-sm-12">
    {!! Form::label('prix', 'Prix:') !!}
    <p>{{ $sousTravaux->prix }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $sousTravaux->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $sousTravaux->updated_at }}</p>
</div>

