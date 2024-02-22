@extends('layouts.layout')

@section('title', 'Listado de Pagos')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">No. Pago</th>
                <th scope="col">Valor</th>
                <th scope="col">Descripción</th>
                <th scope="col">Método</th>
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
    </div>
@endsection
