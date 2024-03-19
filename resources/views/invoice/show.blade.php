@extends('layouts.layout')

@section('title', 'Factura ' . $invoice->id)

@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Ver / Pagar Factura</div>
                <div class="card-body">
                    <form action="{{ route('payment.invoice', $invoice) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="invoiceNumber" name="invoiceNumber" value="{{ $invoice->id }}" disabled>
                            <label for="invoiceNumber">Número de Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="invoiceNameUser" name="invoiceNameUser" value="{{ $invoice->user_id['name'] }}" disabled>
                            <label for="invoiceNameUser">Titular de la Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="valueInvoice" name="valueInvoice" value="{{ $invoice->value }}" disabled>
                            <label for="valueInvoice">Valor Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="monthInvoice" name="monthInvoice" value="{{ $invoice->month_invoiced }}" disabled>
                            <label for="monthInvoice">Mes a Pagar</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ $invoice->description }}" disabled>
                            <label for="descriptionInvoice">Descripción</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="conceptInvoice" name="conceptInvoice" value="{{ $invoice->concept }}" disabled>
                            <label for="conceptInvoice">Concepto</label>
                        </div>
                        @if($invoice->value == '$0' and $invoice->status == 'PAGADA')
                            <div class="form-floating mb-3 mt-3 col">
                                <input type="text" class="form-control" id="paymentStatus" name="paymentStatus" value="{{ $invoice->status }}" @if($invoice->value == '$0' and $invoice->status == 'PAGADA') disabled @endif >
                                <label for="paymentStatus">Estado</label>
                            </div>
                        @else
                            <div class="form-floating mb-3 mt-3 col">
                                <input type="text" class="form-control" id="paymentValue" name="paymentValue" value="{{ old('paymentValue') }}" @if($invoice->value == '$0' and $invoice->status == 'PAGADA') disabled @endif >
                                <label for="paymentValue">Valor a Pagar</label>
                                @error('paymentValue') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 mt-3 col">
                                <input type="text" class="form-control" id="paymentDescription" name="paymentDescription" value="{{ old('paymentDescription') }}" @if($invoice->value == '$0' and $invoice->status == 'PAGADA') disabled @endif >
                                <label for="paymentDescription">Descripción del Pago</label>
                            </div>
                            <button id="btn-guardar_pago" type="submit" class="btn btn-outline-secondary">Guardar</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        @include('payment.payments_by_invoice', $invoice)
    </div>
@endsection
