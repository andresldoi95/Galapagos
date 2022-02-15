<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Declaraciones juramentadas</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Número de identificación</th>
                <th>Teléfono</th>
                <th>Correo electrónico</th>
                <th>Lugar de residencia</th>
                <th>Nacionalidad</th>
                <th>Dirección de domicilio</th>
                <th>Línea aérea</th>
                <th>Número de vuelo</th>
                <th>Aeropuerto de origen</th>
                <th>¿Lleva productos?</th>
                <th>¿Lugares?</th>
                <th>¿Equipamento?</th>
                <th>Productos</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($declaraciones as $declaracion)
                <tr>
                    <td>
                        {{ $declaracion->codigo }}
                    </td>
                    <td>
                        {{ $declaracion->fecha->format('d/m/Y') }}
                    </td>
                    <td>
                        {{ $declaracion->nombres }}
                    </td>
                    <td>
                        {{ $declaracion->apellidos }}
                    </td>
                    <td>
                        {{ $declaracion->numero_identificacion }}
                    </td>
                    <td>
                        {{ $declaracion->telefono }}
                    </td>
                    <td>
                        {{ $declaracion->correo_electronico }}
                    </td>
                    <td>
                        {{ $declaracion->lugar_residencia }}
                    </td>
                    <td>
                        {{ $declaracion->nacionalidad }}
                    </td>
                    <td>
                        {{ $declaracion->direccion_domicilio }}
                    </td>
                    <td>
                        {{ $declaracion->linea_aerea }}
                    </td>
                    <td>
                        {{ $declaracion->numero_vuelo }}
                    </td>
                    <td>
                        {{ $declaracion->aeropuerto_origen }}
                    </td>
                    <td>
                        {{ $declaracion->alimentos_procesados }}
                    </td>
                    <td>
                        {{ $declaracion->lugares_concentracion }}
                    </td>
                    <td>
                        {{ $declaracion->equipos_campamento }}
                    </td>
                    <td>
                        @php
                            $strProductos = '';
                            foreach ($declaracion->productos as $key=>$producto) {
                                $strProductos.= ($key === 0?'':', ') . $producto->descripcion;
                            }
                        @endphp
                        {{ $strProductos }}
                    </td>
                    <td>
                        {{ $declaracion->estado }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
