@vite(['resources/scss/app.scss'])

<body class="body-pdf">
    <h1 class="text-pdf">Recibo de pago número {{$payment->id}}</h1>

    <div>
        <table style="margin: 30px">
            <tr>
                <td class="pdf-td title-bold">Valor del pago: </td>
                <td class="pdf-td">{{$format_value}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Descripción del pago: </td>
                <td class="pdf-td">{{$payment->description}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Método de pago: </td>
                <td class="pdf-td">{{$payment->method}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Número de factura: </td>
                <td class="pdf-td">{{$invoice->id}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Mes pagado: </td>
                <td class="pdf-td">{{$invoice->month_invoiced}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Descripción de la factura: </td>
                <td class="pdf-td">{{$invoice->description}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Concepto de la factura: </td>
                <td class="pdf-td">{{$invoice->concept}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Usuario suscriptor: </td>
                <td class="pdf-td">{{$user->name}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Servicio: </td>
                <td class="pdf-td">{{$subscription->service}}</td>
            </tr>
            <tr>
                <td class="pdf-td title-bold">Fecha del pago: </td>
                <td class="pdf-td">{{$payment->created_at}}</td>
            </tr>
        </table>
    </div>

</body>
