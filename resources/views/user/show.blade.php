@extends('layouts.layout')

@section('title', 'Usuario ' . $user->name)

@section('content')
    <style>
        .form-floating>label {
            left: 10px;
        }
    </style>

    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Información del Usuario</div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user) }}" method="POST">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserName" name="editUserName" value="{{ $user->name }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserName">Nombre completo</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserDocumentType" name="editUserDocumentType" value="{{ $user->document_type }}" @if($mode == 'show') disabled @else($mode == 'show') disabled @endif>
                                <label for="editUserDocumentType">Tipo de documento</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserDocumentNumber" name="editUserDocumentNumber" value="{{ $user->document_number }}" @if($mode == 'show') disabled @else($mode == 'show') disabled @endif>
                                <label for="editUserDocumentNumber">Número de documento</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserEmail" name="editUserEmail" value="{{ $user->email }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserEmail">Correo</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserPhoneNumber" name="editUserPhoneNumber" value="{{ $user->phone_number }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserPhoneNumber">Número de teléfono</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserAddress" name="editUserAddress" value="{{ $user->address }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserAddress">Dirección</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserCity" name="editUserCity" value="{{ $user->city }}" @if($mode == 'show') disabled @else($mode == 'show') disabled @endif>
                                <label for="editUserCity">Ciudad</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserMunicipality" name="editUserMunicipality" value="{{ $user->municipality }}" @if($mode == 'show') disabled @else($mode == 'show') disabled @endif>
                                <label for="editUserMunicipality">Municipio</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserOldCode" name="editUserOldCode" value="{{ $user->old_code }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserOldCode">Código Antiguo de Suscripción</label>
                            </div>
                        </div>
                        @if($mode == 'edit')
                            <button id="btn-guardar_usuario" type="submit" class="btn btn-outline-secondary">Guardar</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($mode == 'show')
        <div class="container-fluid">
            @include('invoice.invoices_by_user', $user)
        </div>
    @endif
@endsection
