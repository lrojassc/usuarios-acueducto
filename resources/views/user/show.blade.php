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
                                <select class="form-select" id="statusUser" name="statusUser" @if($mode == 'show') disabled @endif>
                                    <option selected value="{{ $user->status }}">{{ $user->status }}</option>
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="SUSPENDIDO">SUSPENDIDO</option>
                                </select>
                                <label for="statusUser">Estado del Suscriptor</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-floating mb-3 mt-3 col-4">
                                <select class="form-select" id="userFullPayment" name="userFullPayment" @if($mode == 'show') disabled @endif>
                                    <option selected value="{{ $user->full_payment }}">{{ $user->full_payment }}</option>
                                    <option value="SI">SI</option>
                                    <option value="MITAD">PAGA LA MITAD</option>
                                </select>
                                <label for="userFullPayment">¿Usuario Paga Servicio Completo?</label>
                            </div>
                        </div>


                        <!-- Sección de servicios activos por usuario o para registrar-->
                        <hr>
                        <div class="card col-md-8 offset-2">
                            @if($mode == 'show')
                                <div class="card-header">{{ $subscription_status }} y cuenta con los siguientes servicios activos.</div>
                            @else
                                <div class="card-header">Servicios activos o por registrar.</div>
                            @endif

                            <div class="card-body">
                                <div class="row" id="containerNewServices">
                                    @foreach($services_by_user as $key => $service)
                                        @if($service->status == 'ACTIVO')
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="editActiveServices{{$key + 1}}" name="editActiveServices{{$key + 1}}"
                                                       value="{{ $service->service }}" @if($mode == 'show') disabled @endif
                                                >

                                                 <!-- Modal para pagar facturas adelantadas -->
                                                @if($mode == 'show')
                                                    <!-- Declara variable $id_service para enviar al modal -->
                                                    @php ($id_service = $service->id)
                                                    @php ($service_name = $service->service)
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalGenerateInvoices{{ $id_service }}">Facturas Adelantadas</button>
                                                    @include('invoice.modal_facturas', [$id_service, $service_name])
                                                @endif


                                                <!-- Visualizar boton de eliminar servicio-->
                                                @if($mode == 'edit')
                                                    <button type="button" class="btn btn-outline-secondary" id="editActiveServices{{$key + 1}}" onclick="deleteService({{$service}})">Eliminar</button>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if($mode == 'edit')
                                    <button type="button" class="btn btn-outline-secondary" onclick="addNewService()">Nuevo Servicio</button>
                                @endif
                            </div>
                        </div>

                        @if($mode == 'edit')
                            <hr>
                            <button id="btn-guardar_usuario" type="submit" class="btn btn-outline-secondary mt-3">Guardar</button>
                        @endif

                    </form>
                </div>
            </div>

            <!--Enlace para generar estado de cuenta por usuario-->
            <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link mb-2 fs-5" type="button" aria-current="page" href="{{ route('pdf.account_status_by_user', $user) }}">Estado de Cuenta Suscriptor</a>
                </li>
            </ul>
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

    function deleteService(service) {
        event.preventDefault();

        fetch('{{ route("service.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(service)
        })
        .then(response => {
            console.log(response)
            if(response.ok === true) {
                alert('Servicio eliminado')
                window.location.href = window.location.href;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
