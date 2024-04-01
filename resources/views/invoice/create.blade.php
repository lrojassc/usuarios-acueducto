@extends('layouts.layout')

@section('title', 'Crear Factura')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Nueva Factura</div>
                <div class="card-body">
                    <form action="{{ route('invoice.store') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3 mt-3 col">
                            <select class="form-select" id="userInvoice" name="userInvoice">
                                <option value="seleccione">--Seleccione Suscriptor--</option>
                                @foreach($data_users as $data_user)
                                    <option value="{{ $data_user['id'] }}">{{$data_user['name']}}</option>
                                @endforeach
                            </select>
                            <label for="userInvoice">Usuario Suscriptor</label>
                        </div>
                        <div id="serviceOptions" class="form-floating mb-3 mt-3 col" style="display: none">
                            <!-- Aquí se mostrarán las opciones dependiendo del producto seleccionado -->
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="valueInvoice" name="valueInvoice" value="{{ old('valueInvoice') }}">
                            <label for="valueInvoice">Valor</label>
                            @error('valueInvoice') <p>{{ $message }}</p> @enderror
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <select class="form-select" id="monthInvoice" name="monthInvoice">
                                <option selected value="{{ $current_month }}">{{ $current_month }}</option>
                                @foreach($months as $month)
                                    <option value="{{ $month }}">{{$month}}</option>
                                @endforeach
                            </select>
                            <label for="monthInvoice">Mes de la Factura</label>
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <input type="text" class="form-control" id="descriptionInvoice" name="descriptionInvoice" value="{{ old('descriptionInvoice') }}">
                            <label for="descriptionInvoice">Descripción</label>
                            @error('descriptionInvoice') <p>{{ $message }}</p> @enderror
                        </div>
                        <div class="form-floating mb-3 mt-3 col">
                            <select class="form-select" id="conceptInvoice" name="conceptInvoice">
                                <option selected value="RECONEXION">RECONEXIÓN</option>
                                <option value="SUSCRIPCION">DERECHO DE SUSCRIPCIÓN</option>
                            </select>
                            <label for="conceptInvoice">Concepto</label>
                        </div>
                        <button id="btn-guardar_factura" type="submit" class="btn btn-outline-secondary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('userInvoice').addEventListener('change', function () {
            var userId = this.value;

            if (userId !== '') {
                fetch('/admin/service/' + userId + '/services')
                    .then(response => response.json())
                    .then(data => {
                        // Inicializar el contenedor principal en limpio para el select
                        var opcionesDiv = document.getElementById('serviceOptions');
                        opcionesDiv.innerHTML = '';

                        // Crear los elementos html necesarios para mostrar las opciones
                        var select = document.createElement("select");
                        var label = document.createElement("label");

                        // Agregar propiedades necesarias para los elementos html creados
                        select.classList = "form-select";
                        select.id = "serviceUser";
                        select.name = "serviceUser";
                        label.textContent = "Servicios";

                        // Incorporar los elementos creados al contenedor principal
                        opcionesDiv.appendChild(select);
                        opcionesDiv.appendChild(label);
                        opcionesDiv.style.display = 'block';

                        // Inicializar el contenedor de las opciones disponibles
                        var opcionesSelect = document.getElementById('serviceUser');
                        opcionesSelect.innerHTML = '';

                        // Agregar las opciones disponibles con innerHtml
                        data.services.forEach(function (service) {
                            opcionesSelect.innerHTML += '<option value=' + service.id +'>'+ service.service +'</option>';
                        });
                    })
            } else {
                document.getElementById('serviceOptions').style.display = 'none';
            }
        })
    </script>
@endsection
