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
                                @error('editUserName') <p>{{ $message }}</p> @enderror
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
                                @error('editUserPhoneNumber') <p>{{ $message }}</p> @enderror
                            </div>
                            <div class="form-floating mb-3 mt-3 col-4">
                                <input type="text" class="form-control" id="editUserAddress" name="editUserAddress" value="{{ $user->address }}" @if($mode == 'show') disabled @endif>
                                <label for="editUserAddress">Dirección</label>
                                @error('editUserAddress') <p>{{ $message }}</p> @enderror
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

                        <!-- Sección de servicios activos por usuario o para registrar-->
                        <div class="card">
                            @if($mode == 'show')
                                <div class="card-header">{{ $subscription_status }} y cuenta con los siguientes servicios activos.</div>
                            @else
                                <div class="card-header">Servicios activos o por registrar.</div>
                            @endif

                            <div class="card-body">
                                <div class="row" id="containerNewServices">
                                    @foreach($services_by_user as $key => $service)
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="editActiveServices{{$key + 1}}" name="editActiveServices{{$key + 1}}" value="{{ $service->service }}" @if($mode == 'show') disabled @endif>
                                            <label for="editActiveServices{{$key + 1}}">Descripción del Servicio {{ $key + 1 }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if($mode == 'edit')
                                    <button type="button" class="btn btn-outline-secondary" onclick="addNewService()">Nuevo Servicio</button>
                                @endif
                            </div>
                        </div>

                        @if($mode == 'edit')
                            <button id="btn-guardar_usuario" type="submit" class="btn btn-outline-secondary mt-3">Guardar</button>
                        @endif

                    </form>
                </div>
            </div>
            @if($mode == 'show')
                @include('invoice.modal_facturas')
            @endif
        </div>
    </div>
    @if($mode == 'show')
        <div class="container-fluid">
            @include('invoice.invoices_by_user', $user)
        </div>
    @endif
@endsection
<script>
    function addNewService() {
        // Crear nuevo elemento input y label
        var nuevoDiv = document.createElement("div");
        var nuevoInput = document.createElement("input");
        var nuevoLabel = document.createElement("label");

        var containerServices = document.getElementById("containerNewServices");
        var inputElements = containerServices.querySelectorAll("input");
        var countInputs = inputElements.length;
        var counter = countInputs + 1;

        if (counter > 5) {
            alert('No es posible agregar mas servicios')
        } else {
            nuevoInput.type = "text";
            nuevoInput.classList = "form-control mb-3";
            nuevoInput.name = "nuevoServicio" + counter;

            nuevoDiv.classList = "form-floating";

            nuevoLabel.textContent = "Descripción del Nuevo Servicio " + counter;

            nuevoDiv.appendChild(nuevoInput);
            nuevoDiv.appendChild(nuevoLabel);

            // Obtener el contenedor donde se agregarán los inputs
            var contenedorInputs = document.getElementById("containerNewServices");

            // Agregar el nuevo input al contenedor
            contenedorInputs.appendChild(nuevoDiv);
        }

    }
</script>
