<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de retención/rechazo {{ $retencion->numero_documento }}</title>
    <style>
        .right {
            text-align: right;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 4px;
        }
        .text-right {
            text-align: right;
        }
        .red {
            color: red;
        }
        .bordered tr, .bordered td, .bordered th {
            border: 1px solid;
        }
        .back-gray {
            color: white;
            background-color: grey;
            border-color: black;
        }
        footer {
            font-size: 9px;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    <header>
        <table>
            <tbody>
                <tr>
                    <td width="50%">
                        <img src="{{ public_path('/img/republica-ecuador.png') }}" alt="Ecuador" width="150">
                    </td>
                    <td class="text-right" width="50%">
                        <h2>Agencia de Regulación y Control de la Bioseguridad y Cuarentena para Galápagos</h2>
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    <table class="bordered">
        <tbody>
            <tr>
                <td width="70%">
                    <h2>Registro de Retención/Rechazo Anexo No. 31</h2>
                </td>
                <td width="15%">
                    <p>
                        <strong>Retención:</strong> {{ $retencion->retencion === 'S'?'Sí':'No' }}
                    </p>
                    <p>
                        <strong>Rechazo:</strong> {{ $retencion->rechazo === 'S'?'Sí':'No' }}
                    </p>
                </td>
                <td width="15%">
                    <p>
                        No. <span class="red"><strong>{{ $retencion->numero_documento }}</strong></span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="bordered">
        <tbody>
            <tr>
                <td>
                    <strong>Lugar:</strong><br>{{ $retencion->lugar }}
                </td>
                <td>
                    <strong>Fecha:</strong><br>{{ $retencion->fecha->format('d/m/Y') }}
                </td>
                <td>
                    <strong>Tipo de transporte:</strong><br>{{ $retencion->tipo_transporte }}
                </td>
                <td>
                    <strong>Nombre del transporte:</strong><br>{{ $retencion->nombre_transporte }}
                </td>

            </tr>
            <tr>
                <td>
                    <strong>Destino:</strong><br>{{ $retencion->destino }}
                </td>
                <td>
                    <strong>Procedencia:</strong><br>{{ $retencion->procedencia }}
                </td>
                <td>
                    <strong>Nombre del dueño del producto:</strong><br>{{ $retencion->nombre_completo }}
                </td>
                <td>
                    <strong>Dirección:</strong><br>{{ $retencion->direccion }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>No. Identificación:</strong><br>{{ $retencion->numero_identificacion }}
                </td>
                <td>
                    <strong>Tipo de residencia:</strong><br>
                    @switch($retencion->tipo_residencia)
                        @case('N')
                            Nacional
                            @break
                        @case('R')
                            Residente
                            @break
                        @case('E')
                            Extranjero
                        @break
                        @default
                            No definido
                    @endswitch
                </td>
                <td colspan="2">
                    <strong>Nro. Candado:</strong><br>
                    {{ $retencion->numero_candado }}
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class="bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Peso</th>
                <th>Unidad</th>
                <th>Categoría</th>
                <th>Razón de retención</th>
                <th>Destino del producto</th>
                <th>El producto/organismo era transportado en</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($retencion->productos as $producto)
                <tr>
                    <td>
                        {{ $producto->producto->descripcion }}
                    </td>
                    <td>
                        {{ $producto->cantidad }}
                    </td>
                    <td>
                        {{ $producto->peso }}
                    </td>
                    <td>
                        {{ $producto->unidad }}
                    </td>
                    <td>
                        {{ $producto->categoria }}
                    </td>
                    <td>
                        {{ $producto->razon_retencion }}
                    </td>
                    <td>
                        {{ $producto->destino_producto }}
                    </td>
                    <td>
                        {{ $producto->transportado_en }}
                    </td>
                    <td>
                        {{ $producto->observacion }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th scope="row">
                    Total
                </th>
                <td>
                    {{ $retencion->productos()->sum('cantidad') }}
                </td>
                <td colspan="7"></td>
            </tr>
        </tfoot>
    </table>
    <table class="bordered">
        <tbody>
            <tr>
                <td width="50%">
                    <p>
                        1.- Categoría:
                    </p>
                    <p>
                        P = Permitido; R = Restringido; NP = No Permitido
                    </p>
                </td>
                <td>
                    <p>
                        3.- Destino:
                    </p>
                    <p>
                        INC = Incineración; TTO = Tratamiento; DEV/OR = Devolución al puerto de origen;
                        DEV = Devolución al dueño
                    </p>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <p>
                        2.- Razón de retención:
                    </p>
                    <p>
                        PL = Plagado; ME = Mal estado; SR = Sin requisitos; NP = No permitido
                    </p>
                </td>
                <td>
                    <p>
                        4.- El material/organismo era transportado en:
                    </p>
                    <p>
                        C = Carga; EA = Equipaje acompañado; ENA = Equipaje no acompañado;
                        V = Vestimenta; MT = Medio de transporte
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <center>
        <p><strong>Certificamos que la información contenida en este registro es verdadera</strong></p>
    </center>
    <br>
    <table class="bordered">
        <thead>
            <tr>
                <th>Dueño y/o responsable del producto</th>
                <th>Testigo</th>
                <th>Inspector responsable</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="33%">
                    <p>
                        <strong>Nombre:</strong> {{ $retencion->nombre_completo }}
                    </p>
                    <p>
                        <strong>C.I. o Pasaporte:</strong> {{ $retencion->numero_identificacion }}
                    </p>
                    <p>
                        <hr>
                        <center>Firma:</center>
                    </p>
                </td>
                <td width="33%">
                    <p>
                        <strong>Nombre:</strong> {{ $retencion->nombre_testigo }}
                    </p>
                    <p>
                        <strong>C.I. o Pasaporte:</strong> {{ $retencion->identificacion_testigo }}
                    </p>
                    <p>
                        <hr>
                        <center>Firma:</center>
                    </p>
                </td>
                <td>
                    <p>
                        <strong>Nombre:</strong> {{ $retencion->nombre_inspector_responsable }}
                    </p>
                    <p>
                        <strong>C.I. o Pasaporte:</strong> {{ $retencion->identificacion_inspector_responsable }}
                    </p>
                    <p>
                        <hr>
                        <center>Firma:</center>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td width="50%">
                    <strong>Observaciones:</strong> {{ $retencion->observaciones }}
                </td>
                <td>
                    <table class="bordered">
                        <thead>
                            <tr>
                                <th class="back-gray" colspan="2">Información complementaria</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>% productos en mal estado:</td>
                                <td>
                                    {{ $retencion->porcentaje_mal_estado }}
                                </td>
                            </tr>
                            <tr>
                                <td>% productos plagados:</td>
                                <td>
                                    {{ $retencion->porcentaje_plagados }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <p>Original usuario, copia 1 unidad requiriente, copia 2 archivo</p>
    <hr>
    <footer>
        <table>
            <tbody>
                <tr>
                    <td width="50%">
                        <p><strong>Dirección:</strong> Av. Baltra. <strong>Código postal:</strong> EC200350 / Santa Cruz Ecuador</p>
                        <p><strong>Teléfono:</strong> 593 5 2527414 - 05 2527 023 <strong>- Isabela</strong> 05 2529 491</p>
                        <p><strong>San Cristóbal</strong> 05 2521 100 <strong>Floreana</strong> 05 2535 057 <strong>Quito</strong> 02 2818272</p>
                        <p><strong>Guayaquil Aeropuerto</strong> 04 2292 811 <strong>Guayaquil Puerto</strong> 04 2556 576</p>
                        <p>www.abg-galapagos.info</p>
                    </td>
                    <td class="right">
                        <img src="{{ public_path('/img/gobierno-encuentro.png') }}" alt="Ecuador" width="250">
                    </td>
                </tr>
            </tbody>
        </table>
    </footer>
    @if ($retencion->path_foto != null || $retencion->path_foto2 != null)
        <div class="page_break"></div>
        <h2>Fotos</h3>
        <table class="bordered">
            <tbody>
                <tr>
                    @if ($retencion->path_foto != null)
                        <td width="50%">
                            <img src="{{ storage_path('/app/public/' . $retencion->path_foto) }}" alt="Foto principal" width="100%">
                        </td>
                    @endif
                    @if ($retencion->path_foto2 != null)
                        <td width="50%">
                            <img src="{{ storage_path('/app/public/' . $retencion->path_foto2) }}" alt="Foto adicional" width="100%">
                        </td>
                    @endif
                </tr>
            </tbody>
        </table>
    @endif
</body>
</html>
