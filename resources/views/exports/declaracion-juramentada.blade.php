<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Declaración Juramentada - {{ $declaracion->codigo }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .back_celeste {
            background-color: #BED7F3;
        }
        table td {
            padding: 4px;
        }
    </style>
</head>
<body>
    <header>
        <center>
            <img src="{{ public_path('/img/footer.png') }}" alt="Header" width="100%">
        </center>
        <center>
            <h2>DECLARACIÓN JURAMENTADA DE MERCANCIAS / <i>AFFIDAVIT</i></h2>
            <p><strong>Cada persona mayor de 18 años debe llenar este documento</strong></p>
            <p><strong><i>Every person over 18 must fill in this document</i></strong></p>
        </center>
    </header>
    <h2># Código / Code {{ $declaracion->codigo }}</h2>
    <h3>I. IDENTIFICACIÓN / Personal Particulars</h3>
    <table>
        <tbody>
            <tr>
                <td><strong>Apellidos / <i>Last name</i></strong>:<br>{{ $declaracion->apellidos }}</td>
                <td><strong>Nombres  / <i>Names</i></strong>:<br>{{ $declaracion->nombres }}</td>
                <td><strong>Nacionalidad  / <i>Nacionality</i></strong>:<br>{{ $declaracion->nacionalidad }}</td>
            </tr>
            <tr>
                <td><strong>No. Cédula / <i>Passport number</i></strong>:<br>{{ $declaracion->numero_identificacion }}</td>
                <td><strong>Teléfono / <i>Phone</i></strong>:<br>{{ $declaracion->telefono }}</td>
                <td><strong>Correo electrónico / <i>E-mail</i></strong>:<br>{{ $declaracion->correo_electronico }}</td>
            </tr>
            <tr>
                <td><strong>Lugar de residencia / <i>Residence</i></strong>:<br>{{ $declaracion->lugar_residencia }}</td>
                <td colspan="2"><strong>Dirección domiciliaria / <i>Address</i></strong>:<br>{{ $declaracion->direccion_domicilio }}</td>
            </tr>
            <tr>
                <td><strong>Línea aérea / <i>Airline</i></strong>:<br>{{ $declaracion->linea_aerea }}</td>
                <td><strong>Vuelo No. / <i>Number flight</i></strong>:<br>{{ $declaracion->numero_vuelo }}</td>
                <td><strong>Aeropuerto de origen / <i>Airport of origin</i></strong>:<br>{{ $declaracion->aeropuerto_origen }}</td>
            </tr>
        </tbody>
    </table>
    <h3>II. Declaro bajo juramento que:<br>/ I declare under oath that:</h3>
        <table>
            <tbody>
                <tr class="back_celeste">
                    <td width="75%">
                        <p>
                            <strong>
                                Traigo elementos procesados, frescos o cocidos, plantas, flores, frutos,
                                semillas, yemas, bulbos, animales vivos, madera, artesanías, productos biológicos,
                                tierra, arena, rocas o minerales.
                            </strong>
                        </p>
                        <p>
                            <i>
                                I am bringin processed, fresh or cooked foods, plants, flowers, fruits, seeds, buds,
                                live animals, wood, handcrafts of plant or animal origin, biological products, soil,
                                sand, rocks or minerals.
                            </i>
                        </p>
                        @if ($declaracion->alimentos_procesados === 'S')
                            <p>
                                <strong>Declaro que llevo conmigo: / I declare that I bring:</strong><br>
                                @php
                                    $strProductos = '';
                                    foreach ($declaracion->productos as $key=>$producto) {
                                        $strProductos.= ($key === 0?'':', ') . $producto->descripcion;
                                    }
                                @endphp
                                {{ $strProductos }}
                            </p>
                        @endif
                    </td>
                    <td>
                        <p>
                            <strong>{{ $declaracion->alimentos_procesados === 'S'?'Sí/Yes':'No' }}</strong>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="75%">
                        <p>
                            <strong>
                                He estado en lugares de concentración de animales domésticos o silvestres, en las últimas 72 horas (granjas, zoológicos o áreas protegidas).
                            </strong>
                        </p>
                        <p>
                            <i>
                                I have been where there are concentrations of domestic or wild animas in the last 72 hours (farms, zoos or protected areas).
                            </i>
                        </p>
                    </td>
                    <td>
                        <p>
                            <strong>{{ $declaracion->lugares_concentracion === 'S'?'Sí/Yes':'No' }}</strong>
                        </p>
                    </td>
                </tr>
                <tr class="back_celeste">>
                    <td width="75%">
                        <p>
                            <strong>
                                Traigo equipos de campamento como: carpas, sacos de dormir, calzado de campo u otros.
                            </strong>
                        </p>
                        <p>
                            <i>
                                I am bringing camping equipment, tent, sleeping bag, hiking boots, etc.
                            </i>
                        </p>
                    </td>
                    <td>
                        <p>
                            <strong>{{ $declaracion->equipos_campamento === 'S'?'Sí/Yes':'No' }}</strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table>
            <td width="50%">
                <h4>
                    <strong>Fecha / Date:</strong> {{ $declaracion->fecha->format('d/m/Y') }}
                </h4>
            </td>
            <td>
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrcode) }}"  width="100" height="100" />
            </td>
        </table>
</body>
</html>
