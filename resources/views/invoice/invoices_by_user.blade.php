<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">No. Factura</th>
        <th scope="col">Valor</th>
        <th scope="col">Descripción</th>
        <th scope="col">Estado</th>
        <th scope="col">Concepto</th>
        <th scope="col">Acción</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
    @foreach($invoices as $invoice)
        <tr>
            <td>{{$invoice['id']}}</td>
            <td>{{$invoice['value']}}</td>
            <td>{{$invoice['description']}}</td>
            <td>{{$invoice['status']}}</td>
            <td>{{$invoice['concept']}}</td>
            <td><a href="{{ route('invoice.show', $invoice['id']) }}">PAGAR</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="fs-5">Valor Pendiente: {{ $total_invoices }}</p>
<p class="fs-5">Valor Pagado: {{ $total_pagos_realizados }}</p>
<p class="fs-5">Total Facturas: {{ $total_facturas }}</p>
