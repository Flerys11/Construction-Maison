<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="sous-travauxes-table">
            <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Quantite</th>
                <th>Prix</th>
                <th>Unite</th>

                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sousTravauxes as $sousTravaux)
                <tr>
                    <td>{{ $sousTravaux->code }}</td>
                    <td>{{ $sousTravaux->nom }}</td>
                    <td>{{ $sousTravaux->quantite }}</td>
                    <td>{{ $sousTravaux->prix }}</td>
                    <td>{{ $sousTravaux->unite->nom }}</td>
                    <td  style="width: 120px">

                        <div class='btn-group'>

                            <a href="{{ route('sous-travauxes.edit', [$sousTravaux->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="bx bx-edit"></i>
                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
{{--        <div class="float-right">--}}
{{--            @include('adminlte-templates::common.paginate', ['records' => sous-travauxes])--}}
{{--        </div>--}}
    </div>
</div>
