@vite(['resources/scss/app.scss'])

<body class="massive_invoice">
    <div class="container-invoices">
        @foreach(array_chunk($imprimir_invoices, 2) as $invoices)
            <div class="row-invoice">
                @foreach($invoices as $invoice)
                    <div class="invoice">
                        <p style="font-weight: bold; text-align: center">JUNTA ADMINISTRADORA DE ACUEDUCTO DE QUITURO - TARQUI</p>
                        <p style="text-decoration: underline; text-align: center">NIT: 900.260.525-4</p>

                        <table class="table-invoice-massive">
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">Subscriptor</td>
                                <td class="pdf-massive-td">{{$invoice['usuario']}}</td>
                            </tr>
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">Dirección / Barrio</td>
                                <td class="pdf-massive-td">{{$invoice['direccion']}}</td>
                            </tr>
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">Código / Servicio</td>
                                <td class="pdf-massive-td">{{$invoice['codigo']}} - {{$invoice['servicio']}}</td>
                            </tr>
                            <tr>
                                <td class="title-bold pdf-massive-td">Valor Factura</td>
                                <td class="pdf-massive-td">{{$invoice['valor_ultima_factura']}}</td>
                            </tr>
                            <tr>
                                <td class="title-bold pdf-massive-td">Periodo</td>
                                <td class="pdf-massive-td">{{$invoice['periodo']}}</td>
                            </tr>
                        </table>
                        <br>
                        <table class="table-invoice-massive">
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">Atrasos</td>
                                <td class="pdf-massive-td">{{$invoice['atrasos']}}</td>
                            </tr>
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">Descripción</td>
                                <td class="pdf-massive-td">{{$invoice['observacion']}}</td>
                            </tr>
                        </table>
                        <br>
                        <table class="table-invoice-massive">
                            <tr>
                                <td class="title-bold pdf-massive-td" style="width: 40%;">TOTAL A PAGAR</td>
                                <td class="pdf-massive-td">{{$invoice['valor_total_facturas']}}</td>
                            </tr>
                        </table>

                    </div>
                @endforeach
            </div>
            <div class="clearfix-dos"></div>
        @endforeach
    </div>
</body>
