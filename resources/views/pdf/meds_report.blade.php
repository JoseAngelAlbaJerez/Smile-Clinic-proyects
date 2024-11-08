<!DOCTYPE html>
<html>

<head>

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
    </style>

    <div class="prescription-background"></div>

 
    <table class="invoice-info-container" style=" margin-right: 100px !important;">
        <tr>
            <td rowspan="2" class="client-name">
              
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
                Fecha: <strong></strong>
            </td>
            <td>
                Duarte 5, Cayetano Germosén 56000
            </td>
        </tr>
        <tr>
            <td>
                No. de Factura: <strong></strong>
            </td>
            <td>
                SmileClinic@gmail.com
            </td>
        </tr>
    </table>

    <h1 class="p-5">Rx</h1>
    <table class="line-items-container mt-5">
        <thead>



            </tr>
        </thead>
        <tbody>
            @foreach ($medsData as $med)
            <tr>

                <td>{{ $med->name }}</td>
                <td>{{ $med->dosis }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>





</body>

</html>