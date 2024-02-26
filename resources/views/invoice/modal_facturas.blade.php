@if(session('success'))
    <div class="alert alert-success mt-3" role="alert">
        {{ session('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger mt-3" role="alert">
        {{ session('error') }}
    </div>
@endif

<ul class="nav nav-underline">
    <li class="nav-item">
        <a class="nav-link mb-2 fs-5" type="button" aria-current="page" data-bs-toggle="modal" data-bs-target="#modalGenerateInvoices">¿Desea generar facturas masivas para pago adelantado?</a>
    </li>
</ul>
<div class="modal fade" id="modalGenerateInvoices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Generar Facturas Para Pago Adelantado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.create_invoice_by_user', $user) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Seleccione los meses a facturar para el año {{ now()->year }}</label>
                        <input class="form-check-input" type="hidden" value="{{ now()->year }}" id="year" name="year">
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="mesEnero">Enero</label>
                        <input class="form-check-input" type="checkbox" value="ENERO" id="mesEnero" name="mesEnero">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="FEBRERO" id="mesFebrero" name="mesFebrero">
                        <label class="form-check-label" for="mesFebrero">Febrero</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="MARZO" id="mesMarzo" name="mesMarzo">
                        <label class="form-check-label" for="mesMarzo">Marzo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="ABRIL" id="mesAbril" name="mesAbril">
                        <label class="form-check-label" for="mesAbril">Abril</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="MAYO" id="mesMayo" name="mesMayo">
                        <label class="form-check-label" for="mesMayo">Mayo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="JUNIO" id="mesJunio" name="mesJunio">
                        <label class="form-check-label" for="mesJunio">Junio</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="JULIO" id="mesJulio" name="mesJulio">
                        <label class="form-check-label" for="mesJulio">Julio</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="AGOSTO" id="mesAgosto" name="mesAgosto">
                        <label class="form-check-label" for="mesAgosto">Agosto</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="SEPTIEMBRE" id="mesSeptiembre" name="mesSeptiembre">
                        <label class="form-check-label" for="mesSeptiembre">Septiembre</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="OCTUBRE" id="mesOctubre" name="mesOctubre">
                        <label class="form-check-label" for="mesOctubre">Octubre</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NOVIEMBRE" id="mesNoviembre" name="mesNoviembre">
                        <label class="form-check-label" for="mesNoviembre">Noviembre</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="DICIEMBRE" id="mesDiciembre" name="mesDiciembre">
                        <label class="form-check-label" for="mesDiciembre">Diciembre</label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                        <button id="btn-guardar_factura_por_usuario" type="submit" class="btn btn-primary" >Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
