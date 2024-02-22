@extends('layouts.layout')

@section('title', 'Pago ' . $payment->id)

@section('content')

    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Descripción del Pago</div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf

                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber" value="{{ $payment->id }}" disabled>
                            <label for="invoiceNumber">Número del Pago</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="valueInvoice" name="valueInvoice" value="{{ $payment->value }}" disabled>
                            <label for="valueInvoice">Valor del Pago</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="monthInvoice" name="monthInvoice" value="{{ $payment->description }}" disabled>
                            <label for="monthInvoice">Descripción</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ $payment->method }}" disabled>
                            <label for="descriptionInvoice">Método</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ $payment->created_at }}" disabled>
                            <label for="descriptionInvoice">Fecha del Pago</label>
                        </div>
                        <button id="btn-imprimir_pago" type="submit" class="btn btn-outline-secondary">Imprimir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
