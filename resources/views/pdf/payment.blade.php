<h1>FACTURAS</h1>
@foreach($imprimir_invoices as $invoices)
    @foreach($invoices as $invoice)
        <h3>Nombre de usuario: {{$invoice['usuario']}}</h3>
        <h3>Valor total de facturas: {{$invoice['valor_total_facturas']}}</h3>
        <h3>Facturas pendientes: {{$invoice['facturas_pendientes']}}</h3>
        <h3>Valor factura actual: {{$invoice['valor_ultima_factura']}}</h3>
        <h3>Descripción factura: {{$invoice['descripcion_ultima_factura']}}</h3>
        <h3>DIAS PENDIENTES: {{$invoice['descripcion_facturas_pendientes']}}</h3>
        <h3>Mes facturado: {{$invoice['mes_facturado']}}</h3>
        <hr>
    @endforeach
@endforeach
