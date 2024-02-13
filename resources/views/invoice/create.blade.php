@extends('layouts.layout')

@section('title', 'Crear Factura')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Nueva Factura</div>
                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3 mt-3 col">
                            <select class="form-select" id="userInvoice" name="userInvoice">
                                @foreach($data_users as $data_user)
                                    <option value="{{ $data_user['id'] }}">{{$data_user['name']}}</option>
                                @endforeach
                            </select>
                            <label for="userInvoice">Usuario</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="valueInvoice" name="valueInvoice" value="{{ old('valueInvoice') }}">
                            <label for="valueInvoice">Valor</label>
                            @error('valueInvoice') <p>{{ $message }}</p> @enderror
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ old('descriptionInvoice') }}">
                            <label for="descriptionInvoice">Descripción</label>
                            @error('descriptionInvoice') <p>{{ $message }}</p> @enderror
                        </div>
                        <button id="btn-guardar_factura" type="submit" class="btn btn-outline-secondary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
