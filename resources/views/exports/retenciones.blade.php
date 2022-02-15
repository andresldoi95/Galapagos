<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Retenciones</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th># Documento</th>
                <th>Lugar</th>
                <th>Tipo de transporte</th>
                <th>Nombre de transporte</th>
                <th>Destino</th>
                <th>Procedencia</th>
                <th>Fecha</th>
                <th>Retención</th>
                <th>Rechazo</th>
                <th>Númerop de candado</th>
                <th>Nombre completo</th>
                <th>Dirección</th>
                <th>Número de identificación</th>
                <th>Tipo de residencia</th>
                <th>Observaciones</th>
                <th>% Mal estado</th>
                <th>% Plagados</th>
                <th>Inspector responsable</th>
                <th>Id. Inspector responsable</th>
                <th>Nombre de testigo</th>
                <th>Id. Testigo</th>
                <th>Usuario de registro</th>
                <th>Fecha de registro</th>
                <th>Cod. Producto</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Peso</th>
                <th>Categoría</th>
                <th>Razón de retención</th>
                <th>Destino de producto</th>
                <th>Transportación de producto</th>
                <th>Observación de producto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($retenciones as $retencion)
                @foreach ($retencion->productos as $item)
                    <tr>
                        <td>
                            {{ $retencion->numero_documento }}
                        </td>
                        <td>
                            {{ $retencion->lugar }}
                        </td>
                        <td>
                            {{ $retencion->tipo_transporte }}
                        </td>
                        <td>
                            {{ $retencion->nombre_transporte }}
                        </td>
                        <td>
                            {{ $retencion->destino }}
                        </td>
                        <td>
                            {{ $retencion->procedencia }}
                        </td>
                        <td>
                            {{ $retencion->fecha }}
                        </td>
                        <td>
                            {{ $retencion->retencion }}
                        </td>
                        <td>
                            {{ $retencion->rechazo }}
                        </td>
                        <td>
                            {{ $retencion->numero_candado }}
                        </td>
                        <td>
                            {{ $retencion->nombre_completo }}
                        </td>
                        <td>
                            {{ $retencion->direccion }}
                        </td>
                        <td>
                            {{ $retencion->numero_identificacion }}
                        </td>
                        <td>
                            {{ $retencion->tipo_residencia }}
                        </td>
                        <td>
                            {{ $retencion->observaciones }}
                        </td>
                        <td>
                            {{ $retencion->porcentaje_mal_estado }}
                        </td>
                        <td>
                            {{ $retencion->porcentaje_plagados }}
                        </td>
                        <td>
                            {{ $retencion->nombre_inspector_responsable }}
                        </td>
                        <td>
                            {{ $retencion->identificacion_inspector_responsable }}
                        </td>
                        <td>
                            {{ $retencion->nombre_testigo }}
                        </td>
                        <td>
                            {{ $retencion->identificacion_testigo }}
                        </td>
                        <td>
                            {{ $retencion->creador != null?$retencion->creador->name:'' }}
                        </td>
                        <td>
                            {{ $retencion->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td>
                            {{ $item->producto->codigo }}
                        </td>
                        <td>
                            {{ $item->producto->descripcion }}
                        </td>
                        <td>
                            {{ $item->cantidad }}
                        </td>
                        <td>
                            {{ $item->unidad }}
                        </td>
                        <td>
                            {{ $item->peso }}
                        </td>
                        <td>
                            {{ $item->categoria }}
                        </td>
                        <td>
                            {{ $item->razon_retencion }}
                        </td>
                        <td>
                            {{ $item->destino_producto }}
                        </td>
                        <td>
                            {{ $item->transportado_en }}
                        </td>
                        <td>
                            {{ $item->observacion }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
