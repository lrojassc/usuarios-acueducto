@extends('layouts.layout')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Nuevo Usuario</div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="userName" name="userName" value="{{ old('userName') }}">
                                <label for="userName">Nombre completo</label>
                                @error('userName') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <select class="form-select" id="userDocumentType" name="userDocumentType">
                                    <option selected value="CC">CEDULA DE CIUDADANIA</option>
                                    <option value="TI">TARJETA DE IDENTIDAD</option>
                                    <option value="NIT">NIT</option>
                                </select>
                                <label for="userDocumentType">Tipo de documento</label>
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="userDocumentNumber" name="userDocumentNumber" value="{{ old('userDocumentNumber') }}">
                                <label for="userDocumentNumber">Numero de documento</label>
                                @error('userDocumentNumber') <p>{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 col-4">
                                <input type="text" class="form-control" id="userEmail" name="userEmail" value="{{ old('userEmail') }}">
                                <label for="userEmail">Correo</label>
                                @error('userEmail') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 col-4">
                                <input type="text" class="form-control" id="userPhoneNumber" name="userPhoneNumber" value="{{ old('userPhoneNumber') }}">
                                <label for="userPhoneNumber">Número de teléfono</label>
                                @error('userPhoneNumber') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 col-4">
                                <input type="text" class="form-control" id="userAddress" name="userAddress" value="{{ old('userAddress') }}">
                                <label for="userAddress">Dirección</label>
                                @error('userAddress') <p>{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 col-4">
                                <input type="text" class="form-control" id="userCity" name="userCity" value="{{ old('userCity') }}">
                                <label for="userCity">Ciudad</label>
                                @error('userCity') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 col-4">
                                <input type="text" class="form-control" id="userMunicipality" name="userMunicipality" value="{{ old('userMunicipality') }}">
                                <label for="userMunicipality">Municipio</label>
                                @error('userMunicipality') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 col-4">
                                <select class="form-select" id="userStatus" name="userStatus">
                                    <option selected value="ACTIVO">ACTIVO</option>
                                    <option value="SUSPENDIDO">SUSPENDIDO</option>
                                </select>
                                <label for="userStatus">Estado Para el Suscriptor</label>
                            </div>
                        </div>
                        <button id="btn-guardar_usuario" type="submit" class="btn btn-outline-secondary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
