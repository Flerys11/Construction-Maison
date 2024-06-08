@extends('base')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="text-center">
                    <h1>Liste Travaux En Cours</h1>
                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">

        <div class="clearfix">
            <form method="POST" action="{{route('import.paiement')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <div class="form-group">
                            <label for="file" class="sr-only">Sélectionnez un fichier :</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>
                        <br>
                        @if (session('nonMatchingRefs') && count(session('nonMatchingRefs')) > 0)
                            <ul>
                                <p style="color: red;">Erreur des données</p>
                                @foreach (session('nonMatchingRefs') as $ref)
                                    @if(is_array($ref))
                                        <li style="color: red;" >
                                            Ligne {{ $ref['line'] }}: {{ $ref['ref_paiement'] }} - {{ $ref['ref_devis'] }} - {{ $ref['date_paiement'] }} - {{ $ref['montant'] }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif

                        <br>

                        <div class="col-form">
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="container">
            <div class="row">
                @foreach($data as $datas)
                    <div class="col-md-4 col-lg-4 mt-1">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Nom : {{ $datas->nom }}</h5>
                                <p class="card-text">Maison de : {{ $datas->nom_client }}</p>
                                <p class="card-text"><small class="text-muted">Durree : {{ $datas->duree }} Jours</small></p>
                                <p class="card-text"><small class="text-muted">Date Creation : {{ $datas->datedevis }}</small></p>
                            </div>
                            <div class="float-start">
                                <button class="btn btn-success" onclick="modalClick('{{$datas->id}}')">Faire un Paiement</button>
                            </div>
                            <br>
                            <div class="float-end">
                                <a href="{{ route('export.pdf', [$datas->id]) }}">
                                    <button class="btn btn-secondary">Exporter</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>


    <div id="overlay">
        <div id="popup">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parkingDetailsModalLabel">Payer un devis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeFormPopup()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="achat_id" id="achat_id" value="">
                    <div class="form-group">
                        <label>Montant</label>
                        <input type="number" step="any" class="form-control" name="montant" id="montant">
                    </div>
                    <div class="form-group">
                        <label>Reference</label>
                        <input type="text" step="any" class="form-control" name="reference" id="reference">

                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="datetime-local" step="any" class="form-control" name="date" id="date">
                    </div>
                    <div id="error-message" style="color: red;"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="submitForm()">Payer</button>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script async>
        function modalClick(id) {
            console.log(id);
            var achat_id = document.getElementById('achat_id');
            achat_id.value = id;
            document.getElementById('overlay').style.display = 'flex';
        }

        function closeFormPopup(){
            document.getElementById('overlay').style.display = 'none';
        }

        function submitForm(){
            var reference = document.getElementById('reference');
            var achat_id = document.getElementById('achat_id');
            var montant = document.getElementById('montant');
            var date = document.getElementById('date');
            var dataForm = {
                '_token' : '{{ csrf_token() }}',
                'reference' : reference.value,
                'achat_id' : achat_id.value,
                'montant' : montant.value,
                'date' : date.value,
            }
            var jsonData = JSON.stringify(dataForm);
            console.log(jsonData);

            $.ajax({
                url : "{{ route('insert.paiement') }}",
                type : "POST",
                data : jsonData,
                contentType: "application/json; charset=utf-8",
                dataType : "json",
                success: function (data){
                    if (data.message) {
                        //console.log(data.success);
                        closeFormPopup();
                    } else if (data.error) {
                        console.log(data.error);
                        document.getElementById('error-message').innerHTML = data.error;
                    }
                },

                error : function (xhr, status, errorThrown){
                    document.getElementById('error-message').innerHTML = data.error
                }
            });
        }
    </script>

@endsection
