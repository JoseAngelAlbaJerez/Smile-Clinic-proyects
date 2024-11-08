<!DOCTYPE html>
<html>

<head>
<title>Reporte Recetas</title>
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
        font-size: 1.75em;
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


    }

    .invoice-info-container td {
        padding: 4px 0;

    }

    .prescription-background {
        background-image: url('{{ asset('logo.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.2;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        /* Envía el fondo detrás del contenido */
    }

    .client-name {
        font-size: 1.5em;
        vertical-align: top;

    }

    .line-items-container {
        margin: 20px 0;
        font-size: 0.875em;
    }

    .line-items-container th {
        text-align: left;
        color:var(--background);
        border-bottom: 2px solid #ddFFd;
        padding: 10px 0 15px 0;
        font-size: 0.85em;
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
        font-size: 0.75em;
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
    h1{
        font-size: 3em;
    }
    </style>
  <?php
// Set your timezone
date_default_timezone_set('America/Santo_Domingo'); 

// Get the current date
$currentDate = date('Y-m-d');
?>
    
    <table class="invoice-info-container" style=" margin-right: 100px !important;">
        <tr>
            <td rowspan="2" class="client-name">
                {{ $patient->name }}
            </td>
          
        </tr>
        <tr>
      
            <td>
                Fecha: <strong>{{$currentDate}}</strong>
            </td>
         
        </tr>
    </table>

    <h1 >RX</h1>
    <table class="line-items-container">
        <thead>

            <th>Medicamento</th>
            <th>Dosis</th>
            <th>Dias</th>
            <th>horas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medsData as $medData)
            <tr>

            <td>{{ $medData['medication']->name }}</td>
            <td>{{ $medData['medication']->dosis }}</td>
            <td>Cada: {{ $medData['hour'] }} horas</td>
            <td>Por:  @if ( $medData['day'] <8 )
            {{ $medData['day'] }} dias
            @elseif($medData['day'] == 8)
            1 mes
            @elseif( $medData['day']== 9 )
           2 meses
           @elseif( $medData['day']== 10 )
           3 meses
           @elseif( $medData['day']== 11 )
           6 meses
           @elseif( $medData['day']== 12 )
           1 año
            @endif</td>
        

            </tr>
            @endforeach
        </tbody>
    </table>





</body>

</html>