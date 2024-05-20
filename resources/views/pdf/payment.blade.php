@vite(['resources/scss/app.scss'])

<body class="massive_invoice">
    <div class="container-invoices">
        @foreach(array_chunk($imprimir_invoices, 2) as $invoices)
            <div class="row-invoice">
                @foreach($invoices as $invoice)
                    <div class="invoice">
                        <p style="font-weight: bold; text-align: center; margin-bottom: 2px!important;">JUNTA ADMINISTRADORA DE ACUEDUCTO DEL CENTRO POBLADO QUITURO - TARQUI</p>
                        <p style="text-decoration: underline; text-align: center; margin-bottom: 5px!important;">NIT: 900.260.525-4</p>

                        <div class="info_invoice">
                            <table class="table-invoice-massive">
                                <tr style="padding: 2px!important;">
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Subscriptor</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['usuario']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Dirección / Barrio</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['direccion']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Código / Servicio</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">No. {{$invoice['codigo_usuario']}} - {{$invoice['servicio']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Factura / Valor</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">No. {{$invoice['id_ultima_factura']}} - {{$invoice['valor_ultima_factura']}}</td>
                                </tr>
                                @if($invoice['debe_suscripcion'] === true)
                                    <tr>
                                        <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Debe suscripcion</td>
                                        <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['descripcion_suscripcion']}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Periodo facturado</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['periodo']}}</td>
                                </tr>
                            </table>
                            <br>
                            <table class="table-invoice-massive">
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Atrasos</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['atrasos']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Descripción</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['observacion']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Facturas pendientes</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['facturas_pendientes']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">Fecha limite pago</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['fecha_limite_pago']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 40%; font-size: 15px!important; padding: 2.5px!important;">TOTAL A PAGAR</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 2.5px!important;">{{$invoice['valor_total_facturas']}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="separate_invoice"></div>
                        <div class="info_payment_invoice">
                            <p style="font-weight: bold; text-align: center; font-size: 12px!important; margin-bottom: 1px!important;">JUNTA ADMINISTRADORA DE ACUEDUCTO DEL CENTRO POBLADO QUITURO - TARQUI</p>
                            <p style="text-decoration: underline; text-align: center; font-size: 12px!important; margin-bottom: 8px!important;">NIT: 900.260.525-4</p>
                            <table class="table-invoice-massive">
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; font-size: 15px!important; padding: 4px!important;">Factura</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;">No. {{$invoice['id_ultima_factura']}}</td>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; font-size: 15px!important; padding: 4px!important;">Código</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;">No. {{$invoice['codigo_usuario']}}</td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; font-size: 15px!important; padding: 4px!important;">Valor</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;"></td>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; font-size: 15px!important; padding: 4px!important;">Fecha</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;"></td>
                                </tr>
                                <tr>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; height: 25px; font-size: 15px!important; padding: 4px!important;">Recibido</td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;"></td>
                                    <td class="title-bold pdf-massive-td" style="width: 20%; height: 25px; font-size: 15px!important; padding: 4px!important;"></td>
                                    <td class="pdf-massive-td" style="font-size: 15px!important; padding: 4px!important;"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="clearfix-dos"></div>
        @endforeach
    </div>
</body>
