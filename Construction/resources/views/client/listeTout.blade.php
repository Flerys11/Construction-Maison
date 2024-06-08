@foreach($data as $datas)
    <div class="col-md-4 col-lg-4 mt-2">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Nom : {{ $datas->nom }}</h5>
                <p class="card-text">Type Maison : {{ $datas->nom }}</p>
                <p class="card-text"><small class="text-muted">Durree : {{ $datas->duree }} Jours</small></p>
            </div>
            <div class="card-footer">
                <a href="{{ route('choix.devis', [$datas->id]) }}" class="float-start">
                    <button class="btn btn-primary">Nouveaux Devis</button>
                </a>
            </div>
        </div>
    </div>
@endforeach
