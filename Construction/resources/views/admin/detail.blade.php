@extends('base')

    @section('content')
            <div class="text-center">
                <h1>DEVIS BTP</h1>
            </div>
            <br>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>NUMERO</th>
                    <th>DESIGNATION</th>
                    <th>U</th>
                    <th>Q</th>
                    <th>PU</th>
                    <th>TOTAL</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $totalPrixTotal = 0;
                    $totalParCode = [];
                @endphp

                @foreach($devis as $index => $dev)
                    @if($dev->sous->typetravaux != null)
                        @if($index === 0 || $devis[$index - 1]->sous->typetravaux == null || $devis[$index - 1]->sous->typetravaux->code != $dev->sous->typetravaux->code)
                            <tr class="table-primary">
                                <td colspan="6"><strong>{{ $dev->sous->typetravaux->code }} - {{ $dev->sous->typetravaux->nom }}</strong></td>
                            </tr>
                        @endif
                    @endif
                    <tr>
                        <td>{{ $dev->sous->code }}</td>
                        <td>{{ $dev->sous->nom }}</td>
                        <td>{{ $dev->sous->unite->nom }}</td>
                        <td>{{ $dev->quantite }}</td>
                        <td>{{ $dev->prix_unitaire }}</td>
                        <td>{{ ($dev->quantite / $dev->sous->quantite) * $dev->prix_unitaire }} Ar</td>
                        @php
                            $montant = ($dev->quantite / $dev->sous->quantite) * $dev->prix_unitaire;
                            $totalPrixTotal += $montant;
                            if(isset($totalParCode[$dev->sous->typetravaux->code])) {
                                $totalParCode[$dev->sous->typetravaux->code] += $montant;
                            } else {
                                $totalParCode[$dev->sous->typetravaux->code] = $montant;
                            }
                        @endphp
                    </tr>
                @endforeach

                <tr class="table-secondary">
                    <td colspan="2">Total par code</td>
                    <td colspan="4"></td>
                </tr>
                @foreach($totalParCode as $code => $total)
                    <tr class="table-secondary">
                        <td colspan="4">Code {{ $code }}</td>
                        <td colspan="2">{{ $total }} Ar</td>
                    </tr>
                @endforeach

                <tr class="table-success">
                    <td colspan="2">Total</td>
                    <td colspan="4"></td>
                    <td>{{ $totalPrixTotal }} Ar</td>
                </tr>

                <tr class="table-success">
                    <td colspan="2">Pourcentage</td>
                    <td colspan="4"></td>
                    <td>{{ ($pource[0]->poucentage * $totalPrixTotal)/100 }} Ar</td>
                </tr>

                <tr class="table-success">
                    <td colspan="2">Total final</td>
                    <td colspan="4"></td>
                    <td>{{ $totalPrixTotal + (($pource[0]->poucentage * $totalPrixTotal)/100) }} Ar</td>
                </tr>
                </tbody>
            </table>

    @endsection
