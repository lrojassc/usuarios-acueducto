<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">No. Factura</th>
        <th scope="col">Valor</th>
        <th scope="col">Año</th>
        <th scope="col">Mes</th>
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
            <td>{{$invoice['year_invoiced']}}</td>
            <td>{{$invoice['month_invoiced']}}</td>
            <td>{{$invoice['description']}}</td>
            <td style="@if($invoice['status'] == 'PAGADA') color:green;
                @elseif($invoice['status'] == 'PAGO PARCIAL') color: orange;
                @else color: red;
                @endif
                ">
                {{$invoice['status']}}</td>
            <td>{{$invoice['concept']}}</td>
            <td><a href="{{ route('invoice.show', $invoice['id']) }}">PAGAR</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="fs-5">Valor Pendiente: {{ $total_invoices }}</p>
<p class="fs-5">Valor Pagado: {{ $total_pagos_realizados }}</p>
<p class="fs-5">Total Facturas: {{ $total_facturas }}</p>

<script>
    var checkboxesSeleccionados = [];

    function obtenerValorCheckbox(checkbox) {
        var cuerpoDocumento = document.body;
        // Obtener la fila actual del checkbox
        var fila = checkbox.parentNode.parentNode;

        // Obtener el valor de la primera celda (ID en este caso)
        var valorFactura = fila.cells[2].textContent;
        var montoFormat= valorFactura.replace(/[^0-9\.]+/g,"")

        // Obtener el valor del checkbox
        var valorCheckbox = checkbox.checked;

        if(valorCheckbox) {
            checkboxesSeleccionados.push(checkbox);
        } else {
            checkboxesSeleccionados = checkboxesSeleccionados.filter(item => item !== checkbox);
        }

        if(checkboxesSeleccionados.length >= 2) {
            var nuevoTitle = document.createElement('h3');
            nuevoTitle.textContent= 'pagar facturas'
            cuerpoDocumento.appendChild(nuevoTitle)
        } else {
            var elementoExiste = document.querySelector('h3')
            if(elementoExiste) {
                cuerpoDocumento.removeChild(elementoExiste)
            }
        }

    }
</script>
