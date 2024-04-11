<div class="justify-content-center mt-4">
    <div class="card">
        <div class="card-header">Pagos o abonos realizados</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">No. Pago</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Método</th>
                    <th scope="col">Mes Pagado</th>
                    <th scope="col">Descripción Factura</th>
                    <th scope="col">Concepto Factura</th>
                    <th scope="col">Suscriptor</th>
                    <th scope="col">Servicio</th>
                    <th scope="col">Fecha de pago</th>
                    <th scope="col">Acción</th>
                </tr>
                </thead>
                <tbody class="table-group-divider">
                @foreach($payments as $payment)
                    <tr>
                        <td>{{$payment->id}}</td>
                        <td>{{$payment->value}}</td>
                        <td>{{$payment->description}}</td>
                        <td>{{$payment->method}}</td>
                        <td>{{$payment->created_at}}</td>
                        <td><a href="{{ route('payment.show', $payment->id) }}">VER</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <p class="fs-4">Total Pagado: {{ $payment_total }}</p>
        </div>
    </div>
</div>
