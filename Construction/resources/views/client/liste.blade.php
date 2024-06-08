<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="postes-table">
            <thead>
            <tr>
                <th>Nom Client</th>
                <th>Nom Maison</th>
                <th>Duree</th>
                <th>Date de Creation</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $datas)
                <tr>
                    <td>{{ $datas->nom_client }}</td>
                    <td>{{ $datas->nom }}</td>
                    <td>{{ $datas->duree }}</td>
                    <td>{{ $datas->date_creation }}</td>
                    <td  style="width: 120px">

                        <div class='btn-group'>
                            <a href="{{ route('devis.detail', [$datas->iddevis]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye">Detail</i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
