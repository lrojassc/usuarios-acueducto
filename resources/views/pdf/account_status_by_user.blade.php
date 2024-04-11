@vite(['resources/scss/app.scss'])

<body class="body-pdf">
    <h1 class="text-pdf">ESTADO DE CUENTA</h1>

    <div class="user-info">
        <h3>Usuario suscriptor: {{$user->name}}</h3>
        <h3>Número de documento: {{$user->document_number}}</h3>
        <h3>Telefono: {{$user->phone_number}}</h3>
        <h3>Dirección: {{$user->address}}</h3>
        <h3>Estado Suscripción: {{$user->paid_subscription}}</h3>
    </div>

    <table class="invoice-data">
        <caption>Resumen de todas las facturas</caption>
        <thead class="head-table">
        <tr style="background-color: #939798">
            <th scope="col">No. </th>
            <th scope="col">Año</th>
            <th scope="col">Mes</th>
            <th scope="col">Estado</th>
            <th scope="col">Concepto</th>
            <th scope="col">Servicio del suscriptor</th>
            <th scope="col">Saldo</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{$invoice->id}}</td>
                <td>{{$invoice->year_invoiced}}</td>
                <td>{{$invoice->month_invoiced}}</td>
                <td>{{$invoice->status}}</td>
                <td>{{$invoice->concept}}</td>
                <td>{{$invoice->service_description}}</td>
                <td>{{$invoice->value}}</td>
            </tr>
        @endforeach
    </table>

    <hr>

    <table>
        <tr>
            <td style="font-weight: bold; font-size: 20px">Saldo Pendiente: </td>
            <td style="font-size: 20px">{{$info_total_invoices['total_valor_pendiente']}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; font-size: 20px">Valor Pagado: </td>
            <td style="font-size: 20px">{{$info_total_invoices['total_pagos_realizados']}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; font-size: 20px">Total Facturas: </td>
            <td style="font-size: 20px">{{$info_total_invoices['total_facturas']}}</td>
        </tr>
    </table>
</body>
