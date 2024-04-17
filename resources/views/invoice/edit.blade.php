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
                <div class="card-header">Actualizar Información de la Factura</div>
                <div class="card-body">
                    <form action="{{ route('invoice.update', $invoice) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateInvoiceNumber" name="updateInvoiceNumber" value="{{ $invoice->id }}" disabled>
                            <label for="updateInvoiceNumber">Número de Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateInvoiceNameUser" name="updateInvoiceNameUser" value="{{ $invoice->user_id['name'] }}" disabled>
                            <label for="updateInvoiceNameUser">Titular de la Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateValueInvoice" name="updateValueInvoice" value="{{ $invoice->value }}">
                            <label for="updateValueInvoice">Valor Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateMonthInvoice" name="updateMonthInvoice" value="{{ $invoice->month_invoiced }}" disabled>
                            <label for="updateMonthInvoice">Mes a Pagar</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateDescriptionInvoice" name="updateDescriptionInvoice" value="{{ $invoice->description }}" disabled>
                            <label for="updateDescriptionInvoice">Descripción</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="updateConceptInvoice" name="updateConceptInvoice" value="{{ $invoice->concept }}" disabled>
                            <label for="updateConceptInvoice">Concepto</label>
                        </div>
                        <button id="btn-guardar_pago" type="submit" class="btn btn-outline-secondary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
