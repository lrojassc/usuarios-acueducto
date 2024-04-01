@extends('layouts.layout')

@section('title', 'Resumen Pagos')

@section('content')
    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">No. Pago</th>
                <th scope="col">Valor</th>
                <th scope="col">Descripción</th>
                <th scope="col">Método</th>
                <th scope="col">Mes Pagado</th>
                <th scope="col">Desc. Factura</th>
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
                    <td>{{$payment->format_value}}</td>
                    <td>{{$payment->description}}</td>
                    <td>{{$payment->method}}</td>
                    <td>{{$payment->invoice->month_invoiced}}</td>
                    <td>{{$payment->invoice->description}}</td>
                    <td>{{$payment->invoice->concept}}</td>
                    <td>{{$payment->user->name}}</td>
                    <td>{{$payment->subscription->service}}</td>
                    <td>{{$payment->created_at}}</td>
                    <td><a href="{{ route('payment.show', $payment) }}">VER</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
