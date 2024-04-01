@extends('layouts.layout')

@section('title', 'Pago ' . $payment->id)

@section('content')

    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Descripción del Pago</div>
                <div class="card-body">
                    <form action="{{ route('pdf.status_payment', $payment) }}" method="POST">
                        @csrf

                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="paymentNumber" name="paymentNumber" value="{{ $payment->id }}" disabled>
                            <label for="paymentNumber">Número del Pago</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="valuePayment" name="valuePayment" value="{{ $payment->format_value }}" disabled>
                            <label for="valuePayment">Valor del Pago</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionPayment" name="descriptionPayment" value="{{ $payment->description }}" disabled>
                            <label for="descriptionPayment">Descripción</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="methodPayment" name="methodPayment" value="{{ $payment->method }}" disabled>
                            <label for="methodPayment">Método</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="monthPayment" name="monthPayment" value="{{ $payment->invoice->month_invoiced }}" disabled>
                            <label for="monthPayment">Mes Pagado</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ $payment->invoice->description }}" disabled>
                            <label for="descriptionInvoice">Descripción Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="conceptInvoice" name="conceptInvoice" value="{{ $payment->invoice->concept }}" disabled>
                            <label for="conceptInvoice">Concepto Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="userSubscription" name="userSubscription" value="{{ $payment->user->name }}" disabled>
                            <label for="userSubscription">Suscriptor</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="serviceUserSubscriptor" name="serviceUserSubscriptor" value="{{ $payment->subscription->service }}" disabled>
                            <label for="serviceUserSubscriptor">Servicio</label>
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
