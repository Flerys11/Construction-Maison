<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table avec CSS dans le Header</title>
    <style>
        /* Style CSS dans le header */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<!-- Table HTML -->

<div style="text-align: center">
    <h1> DEVIS BTP</h1>
</div>
<br>
<table>
    <thead>
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
                <tr>
                    <td style="font-weight: bold;">{{ $dev->sous->typetravaux->code }}</td>
                    <td style="font-weight: bold;">{{ $dev->sous->typetravaux->nom }}</td>
                    @php
                        $somm = 0;
                    @endphp
                </tr>
            @endif
        @endif
        <tr>
            <td>{{ $dev->sous->code }}</td>
            <td>{{ $dev->sous->nom }}</td>
            <td>{{ $dev->quantite }}</td>
            <td>{{ $dev->sous->quantite }}</td>
            <td>{{ $dev->prix_unitaire }}</td>
            <td>{{ ($dev->quantite / $dev->sous->quantite) * $dev->prix_unitaire }} Ar</td>
            @php
                $montant = ($dev->quantite / $dev->sous->quantite) * $dev->prix_unitaire;
                $somm += $montant;
                $totalPrixTotal += $montant;
                $totalParCode[$dev->sous->typetravaux->code] = $somm;
            @endphp
        </tr>
    @endforeach

    <tr>
        <td colspan="2">Total par code</td>
        <td colspan="2"></td>
        <td colspan="1"></td>
        <td style="font-weight: bold;">
            @foreach($totalParCode as $code => $total)
                Code {{ $code }} : {{ $total }} Ar <br>
            @endforeach
            <p> Pourcentage : {{ ($pource[0]->poucentage * $totalPrixTotal)/100 }} Ar</p>
        </td>
    </tr>

    <tr>
        <td colspan="2">Total</td>
        <td colspan="2"></td>
        <td colspan="1"></td>
        <td style="font-weight: bold;">{{ $totalPrixTotal + (($pource[0]->poucentage * $totalPrixTotal)/100) }} Ar</td>
    </tr>

    </tbody>
</table>
</body>
</html>
