@extends('layouts.layout')

@section('title', 'Facturas')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Factura</th>
                <th scope="col">Valor</th>
                <th scope="col">Año</th>
                <th scope="col">Mes</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estado</th>
                <th scope="col">Concepto</th>
                <th scope="col">Usuario</th>
                <th scope="col">Acción</th>
            </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{$invoice->id}}</td>
                    <td>{{$invoice->value}}</td>
                    <td>{{$invoice->year_invoiced}}</td>
                    <td>{{$invoice->month_invoiced}}</td>
                    <td>{{$invoice->description}}</td>
                    <td>{{$invoice->status}}</td>
                    <td>{{$invoice->concept}}</td>
                    <td><a href="{{ route('user.show', $invoice->user_id['id']) }}">{{$invoice->user_id['name']}}</a></td>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}">PAGAR</a></td>
                    <td><a href="{{ route('invoice.delete', $invoice->id) }}">ELIMINAR</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
