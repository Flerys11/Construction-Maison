<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="postes-table">
            <thead>
            <tr>
                <th>Nom</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($postes as $poste)
                <tr>
                    <td>{{ $poste->nom }}</td>
                    <td  style="width: 120px">
                        {!! Form::open(['route' => ['postes.destroy', $poste->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('postes.show', [$poste->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('postes.edit', [$poste->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $postes])
        </div>
    </div>
</div>
