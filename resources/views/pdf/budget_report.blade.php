<!DOCTYPE html>
<html>

<head>
<title>Reporte Abonos</title>
<body>

    <style>
    /*
  Common invoice styles. These styles will work in a browser or using the HTML
  to PDF anvil endpoint.
*/

    body {
        font-size: 16px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table tr td {
        padding: 0;
    }

    table tr td:last-child {
        text-align: right;
    }

    .bold {
        font-weight: bold;
    }

    .right {
        text-align: right;
    }

    .large {
        font-size: 2em;
    }

    .total {
        font-weight: bold;
        color: #fb7578;
    }

    .logo-container {
        margin: 0 0 20px 0;


    }

    .invoice-info-container {
        font-size: 0.875em;
        margin-left: 15px;
    }

    .invoice-info-container td {
        padding: 4px 0;
    }

    .client-name {
        font-size: 2em;
        vertical-align: top;
    }

    .line-items-container {
        margin: 20px 0;
        font-size: 0.875em;
    }

    .line-items-container th {
        text-align: left;
        color:var(--background);
        border-bottom: 2px solid #ddd;
        padding: 10px 0 15px 0;
        font-size: 1em;
        text-transform: uppercase;
    }

    .line-items-container th:last-child {
        text-align: right;
    }

    .line-items-container td {
        padding: 15px 0;
    }

    .line-items-container tbody tr:first-child td {
        padding-top: 25px;
    }

    .line-items-container.has-bottom-border tbody tr:last-child td {
        padding-bottom: 25px;
        border-bottom: 2px solid #ddd;
    }

    .line-items-container.has-bottom-border {
        margin-bottom: 0;
    }

    .line-items-container th.heading-quantity {
        width: 50px;
    }

    .line-items-container th.heading-price {
        text-align: right;
        width: 100px;
    }

    .line-items-container th.heading-subtotal {
        width: 100px;
    }

    .payment-info {
        width: 38%;
        font-size: 1em;
        line-height: 1.5;
    }

    .footer {
        margin-top: 100px;
    }

    .footer-thanks {
        font-size: 1.125em;
    }

    .footer-thanks img {
        display: inline-block;
        position: relative;
        top: 1px;
        width: 16px;
        margin-right: 4px;
    }

    .footer-info {
        float: right;
        margin-top: 5px;
        font-size: 0.75em;
        color: #ccc;
    }

    .footer-info span {
        padding: 0 5px;
        color: black;
    }

    .footer-info span:last-child {
        padding-right: 0;
    }

    td {
        font-size: 1em;
    }
    </style>

    <div class="logo-container">
        <img height="50" width="200" src="{{ asset('img/Logo-COLOR.jpg') }}" alt="Logo">
    </div>

    <table class="invoice-info-container">
        <tr>
            <td rowspan="2" class="client-name">
                {{$patient->name}}
            </td>
            <td>
                Smile Clinic
            </td>
        </tr>
        <tr>
            <td>
                (809) 970-4382
            </td>
        </tr>
        <tr>
            <td>
                Fecha: <strong>{{$patient->created_at->toDateString()}}</strong>
            </td>
            <td>
                Duarte 5, Cayetano Germosén 56000
            </td>
        </tr>
        <tr>
            <td>
                Tipo de Factura: <strong> @if (!isset($budget['emission_date']) || $budget['emission_date'] === null)
                    Contado
                    @else
                    Credito
                    @endif
                </strong>
            </td>
            <td>
                SmileClinic@gmail.com
            </td>
        </tr>
    </table>
    @php
    $total = 0;
    @endphp

    <table class="line-items-container">
        <thead>
            <th>#</th>
            <th>Procedimiento</th>
            <th>Tratamiento</th>
            <th>Cantidad</th>
            <th>Monto</th>
            <th>Descuento</th>
            <th>Cobertura</th>
            <th>Total</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($budgets as $budget)
            <tr>
                <td style=" text-align: center;"><b>{{ $budget['id'] }}</b></td>
                <td style="text-align: center;">{{ $budget['procedure'] }}</td>
                <td style="text-align: center;">{{ $budget['treatment'] ?? '' }}</td>
                <td style="text-align: center;">{{ $budget['quantity'] }}</td>
                <td style="text-align: center;">{{ number_format($budget['amount']) }} $</td>
                <td style="text-align: center;">{{ $budget['discount'] }}%</td>
                <td style="text-align: center;">{{ $budget['coberture'] }}%</td>
                <td style="text-align: center;">{{ number_format($budget['total']) }} $</td>
            </tr>

            @php
            $total += $budget['total'];
            @endphp
            @endforeach


        </tbody>
    </table>

    <hr style="color: #ddd;">

    <table class="line-items-container has-bottom-border">
        <thead>
            <tr>
                <th>Informacion del Paciente</th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total a Pagar</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="payment-info">
                    <div>
                        No de Paciente: <strong>{{$patient->pacient_id}}</strong>
                    </div>
                    <div>
                        Nombre de Paciente: <strong>{{$patient->name}}</strong>
                    </div>
                    <div>
                        Edad: <strong> @php
                            $birthdate = \Carbon\Carbon::parse($patient->date_of_birth);
                            $now = \Carbon\Carbon::now();
                            $years = $birthdate->diffInYears($now);
                            $months = $birthdate->diffInMonths($now) % 12;
                            @endphp

                            @if ($years > 0)
                            {{ $years }} años
                            @else
                            {{ $months }} meses
                            @endif</strong>
                    </div>
                </td>
                <td>

                </td>

                <td>

                </td>
                <td>

                </td>

                <td class="large total">
                    {{number_format($total)}} $

            </tr>
        </tbody>
    </table>


</body>

<script>

</script>

</html>