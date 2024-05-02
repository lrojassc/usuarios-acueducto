@extends('layouts.layout')

@section('title', 'Configuración General')

@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Configuración General</div>
                <div class="card-body">
                    <form action="{{ route('config.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="value_invoice" name="value_invoice" value="{{ $value_invoice }}">
                            <label for="value_invoice">Valor de Las Facturas Mensuales</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <select class="form-select" id="monthInvoice" name="monthInvoice">
                                <option selected value="{{ $month_selected }}">{{ $month_selected }}</option>
                                @foreach($months as $month)
                                    <option value="{{ $month }}">{{$month}}</option>
                                @endforeach
                            </select>
                            <label for="monthInvoice">Mes Para Las Facturas</label>
                        </div>
                        <button id="btn-guardar_factura" type="submit" class="btn btn-outline-secondary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
