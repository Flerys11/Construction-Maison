<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="finitions-table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Pourcentage</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($finitions as $finition)
                <tr>
                    <td>{{ $finition->nom }}</td>
                    <td>{{ $finition->pourcentage }}</td>
                    <td  style="width: 120px">
{{--                        {!! Form::open(['route' => ['finitions.destroy', $finition->id], 'method' => 'delete']) !!}--}}
                        <div class='btn-group'>
                            <a href="{{ route('finitions.edit', [$finition->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="bx bx-edit"></i>
                            </a>
{{--                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                        </div>
{{--                        {!! Form::close() !!}--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $finitions])
        </div>
    </div>
</div>
