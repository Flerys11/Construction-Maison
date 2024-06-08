<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table" id="postes-table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Type Finition</th>
                <th>Prix Total</th>
                <th>Paiement Total</th>
                <th>Porucentage de Paiement</th>
                <th>Date de Creation</th>
                <th colspan="3">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $datas)
                <tr>
                    <td>{{ $datas->maison }}</td>
                    <td>{{ $datas->finition }}</td>
                    <td>{{ $datas->total_prix }} Ar</td>
                    <td>{{ $datas->total_paiement }} Ar</td>
                    <td>{{ $datas->pourcentage_paiement }} %</td>
                    <td>{{ $datas->datedevis }}</td>
                    <td  style="width: 120px">
                        <div class='btn-group'>
                            <a href="{{ route('detail.encours', [$datas->id]) }}">
                                <i class="bx bx-right-arrow-circle bx-fade-right-hover"></i>
                            </a>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
